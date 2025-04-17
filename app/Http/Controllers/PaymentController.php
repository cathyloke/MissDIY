<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Cart;
use App\Models\User;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\SaleDetail;
use App\Models\SaleVoucher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $userId = Auth::id();
        $selectedProductIds = $request->input('selected_product', []); // get selected product IDs from request

        if (empty($selectedProductIds)) {
            session()->flash('error', 'Please select at least one item to checkout.');
            return redirect()->route('cart.index');
        }

        // fetch only selected cart items for current user
        $selectedItems = Cart::where('userId', $userId)
                            ->whereIn('id', $selectedProductIds) // filter by selected product IDs
                            ->get();
        
        $subtotal = $selectedItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        session(['subtotal' => $subtotal]); // update subtotal in session
        session()->put('total_discount', 0);

        $user = User::find($userId);
        $userAddress = $user->address;

        return view('payment.payment', compact('selectedItems', 'subtotal', 'userAddress'));
    }

    public function process(Request $request)
    {
        Log::info($request->all());

        // Validate payment method first
        $validator = Validator::make($request->only('payment_method'), [
            'payment_method' => 'required|in:touch_n_go,card,online_banking',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Store applied vouchers
        $appliedVouchers = json_decode($request->input('applied_vouchers', '[]'), true);
        session()->put('applied_vouchers', $appliedVouchers);

        // Conditional validation based on payment method
        switch ($request->payment_method) {
            case 'touch_n_go':
                // No extra validation
                break;

            case 'card':
                $cardValidator = Validator::make($request->only([
                    'card_number',
                    'cardholder_name',
                    'expiry_date',
                    'cvv'
                ]), [
                    'card_number' => 'required|numeric',
                    'cardholder_name' => 'required|string|min:3|max:255',
                    'expiry_date' => 'required|date_format:m/y',
                    'cvv' => 'required|digits:3|numeric',
                ]);

                if ($cardValidator->fails()) {
                    return response()->json(['errors' => $cardValidator->errors()], 422);
                }
                break;

            case 'online_banking':
                $bankValidator = Validator::make($request->only([
                    'bank_name',
                    'account_number'
                ]), [
                    'bank_name' => 'required|string',
                    'account_number' => 'required|string|min:10',
                ]);

                if ($bankValidator->fails()) {
                    return response()->json(['errors' => $bankValidator->errors()], 422);
                }
                break;
        }

        // Process payment and create sale
        $userId = Auth::id();
        $cartItems = Cart::with('product')->where('userId', $userId)->get();
        $subtotal = session('subtotal', 0);
        $totalDiscount = session('total_discount', 0);
        $netTotal = $subtotal - $totalDiscount;

        DB::beginTransaction();
        try {
            $sale = new Sale();
            $sale->date = now();
            $sale->totalAmount = $subtotal;
            $sale->netTotalAmount = $netTotal;
            $sale->status = 'completed';
            $sale->userId = $userId;
            $sale->save();

            foreach ($cartItems as $item) {
                SaleDetail::create([
                    'quantity' => $item->quantity,
                    'productId' => $item->product->id,
                    'salesId' => $sale->id,
                    'userId' => $userId,
                ]);

                $product = Product::find($item->product->id);
                if ($product) {
                    $product->quantity = max(0, $product->quantity - $item->quantity);
                    $product->save();
                }
            }

            foreach ($appliedVouchers as $code) {
                $voucher = Voucher::where('code', $code)->first();
                if ($voucher) {
                    SaleVoucher::create([
                        'salesId' => $sale->id,
                        'voucherId' => $voucher->id,
                    ]);
                }
            }

            Cart::where('userId', $userId)->delete();
            session()->forget(['subtotal', 'total_discount', 'applied_vouchers']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Payment successful! Your order has been placed.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred during checkout: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function applyDiscount(Request $request)
    {
        $discountCode = $request->input('discount_code');
        $subtotal = (float) $request->input('subtotal');
    
        $voucher = Voucher::where('code', $discountCode)
                        ->where('expiration_date', '>', now())
                        ->where('validity', 'active')
                        ->first();
    
        if ($voucher) {
            $discountAmount = 0;
    
            if ($voucher->type === 'percentage') {
                $discountAmount = ($voucher->discount / 100) * $subtotal;
            } elseif ($voucher->type === 'fixed') {
                if ($voucher->discount > $subtotal) {
                    return response()->json(['success' => false]);
                } else {
                    $discountAmount = min($voucher->discount, $subtotal); // ensure discount doesn't exceed subtotal
                }
            }
    
            // Get the current total discount from the session
            $totalDiscount = session()->get('total_discount', 0);
    
            // Update the total discount and discounted subtotal
            $totalDiscount += $discountAmount;
            $discountedSubtotal = $subtotal - $discountAmount;
    
            // Store the updated total discount in the session
            session()->put('total_discount', $totalDiscount);
    
            return response()->json([
                'success' => true,
                'discountAmount' => (float) $discountAmount,
                'discountedTotal' => (float) $discountedSubtotal,
            ]);
        }
        return response()->json(['success' => false]);
    }
}

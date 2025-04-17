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
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $paymentType = '';
        switch ($request->payment_method) {
            case 'touch_n_go':
                $paymentType = 'Touch n Go eWallet';
                break;

            case 'card':
                $validator = Validator::make($request->all(), [
                    'card_number' => 'required|numeric',
                    'cardholder_name' => 'required|string|min:3|max:255',
                    'expiry_date' => 'required|date_format:m/y',
                    'cvv' => 'required|digits:3|numeric',
                ]);

                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }

                $paymentType = 'Credit/Debit Card';
                break;

            case 'online_banking':
                $validator = Validator::make($request->all(), [
                    'bank_name' => 'required|string',
                    'account_number' => 'required|string|min:10',
                ]);

                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }

                $paymentType = 'Online Banking';
                break;

            default:
                return response()->json(['errors' => ['payment_method' => ['Invalid payment method']]], 422);
        }

        $sale = Sale::where('userId', Auth::id())->latest->first();
        if (!$sale) {
            return response()->json(['errors' => ['sale' => ['No sale record found for the user']]], 404);
        }

        $saleDetails = SaleDetail::where('salesId', $sale->id)->get();

        foreach ($saleDetails as $detail) {
            $product = Product::withTrashed() ->find($detail->productId);

            if ($product) {
                $product->quantity -= $detail->quantity;
                if ($product->quantity < 0) {
                    $product->quantity = 0;
                }
                $product->save();
            }
        }

        Cart::where('userId', Auth::id())->delete();

        return response()->json([
            'success' => true,
            'message' => 'Payment successful! Your order has been placed.',
        ]);
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

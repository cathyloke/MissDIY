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

        $subtotal = $selectedItems->sum(function ($item) {
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

        switch ($request->payment_method) {
            case 'touch_n_go':
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
                break;

            case 'online_banking':
                $validator = Validator::make($request->all(), [
                    'bank_name' => 'required|string',
                    'account_number' => 'required|string|min:10',
                ]);

                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }
                break;

            default:
                return response()->json(['errors' => ['payment_method' => ['Invalid payment method']]], 422);
        }

        $discount_codes = json_decode($request->discount_code);

        // validate all vouchers
        $vouchers = Voucher::whereIn('code', $discount_codes)
            ->where('validity', 'active')
            ->get();

        if ($vouchers->count() !== count($discount_codes)) {
            return response()->json(['error' => 'One or more vouchers are inactive or invalid.'], 404);
        }

        $userId = Auth::id();
        $selectedItems = json_decode($request->selected_items);
        $discountedTotal = $request->discounted_total;

        if (empty($selectedItems)) {
            return response()->json(['errors' => ['cart' => ['No selected items found in selected cart']]], 404);
        }

        $selectedCartItems = [];
        foreach ($selectedItems as $item) {
            $cart = Cart::find($item); // quantity
            $product = Product::find($cart->productId); //product - price and productid
            $selectedCartItems[] = [
                'quantity' => $cart->quantity,
                'productPrice' => $product->price,
                'productId' => $product->id,
            ];
        }

        $totalAmount = collect($selectedCartItems)->sum(function ($item) {
            return $item['productPrice'] * $item['quantity'];
        });

        if ($discountedTotal === null) {
            $discountedTotal = $totalAmount;
        }

        $sale = Sale::create([
            'date' => now(),
            'totalAmount' => $totalAmount,
            'netTotalAmount' => $discountedTotal,
            'status' => 'pending',
            'userId' => $userId,
        ]);

        foreach ($selectedCartItems as $item) {
            SaleDetail::create([
                'quantity' => $item['quantity'],
                'productId' => $item['productId'],
                'salesId' => $sale->id,
                'userId' => $userId,
            ]);

            $product = Product::find($item['productId']);
            if ($product) {
                $product->quantity -= $item['quantity'];
                $product->save();
            }

            Cart::where('userId', $userId)
                ->where('productId', $item['productId'])
                ->delete();
        }

        foreach ($vouchers as $voucher) {
            if ($voucher) {
                SaleVoucher::create([
                    'salesId' => $sale->id,
                    'voucherId' => $voucher->id,
                ]);
            }
        }

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

            // get current total discount from session
            $totalDiscount = session()->get('total_discount', 0);

            // update total discount and discounted subtotal
            $totalDiscount += $discountAmount;
            $discountedSubtotal = $subtotal - $discountAmount;

            // store updated total discount in session
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

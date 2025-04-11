<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Cart;
use App\Models\User;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Show payment page
    public function index(Request $request)
    {
        $userId = Auth::id();
        $selectedProductIds = $request->input('selected_product', []); // Get selected product IDs from the request

        if (empty($selectedProductIds)) {
            session()->flash('error', 'Please select at least one item to checkout.');
            return redirect()->route('cart.index');
        }

        // fetch only selected cart items for current user
        $selectedItems = Cart::where('userId', $userId)
                            ->whereIn('id', $selectedProductIds) // Filter by selected product IDs
                            ->get();
        
        $subtotal = $selectedItems->sum(function($item) {
            return $item->productPrice * $item->productQty;
        });

        session(['subtotal' => $subtotal]); // Update subtotal in the session

        $user = User::find($userId);
        $userAddress = $user->address;

        return view('payment.payment', compact('selectedItems', 'subtotal', 'userAddress'));
    }

    // Process payment
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

        Cart::where('userId', Auth::id())->delete();

        return response()->json([
            'success' => true,
            'message' => 'Payment successful! Your order has been placed.',
        ]);
    }
}

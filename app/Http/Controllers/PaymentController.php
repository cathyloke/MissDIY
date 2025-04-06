<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Show payment page
    public function index()
    {
        $userId = Auth::id();
        $cartItems = Cart::where('userId', $userId)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty. Please add items to your cart before proceeding to payment.');
        } 

        $subtotal = $cartItems->sum(function ($item) {
            return $item->productPrice * $item->productQty;
        });

        session(['subtotal' => $subtotal]); // Update subtotal in the session

        // return view('payment', compact('cartItems', 'subtotal'));
        // return view('payment', compact('cartItems'));
        return redirect()->route('payment.index');
    }

    // Process payment
    public function process(Request $request)
    {
        $request->validate([
            'payment_method' => 'required',
        ]);

        $userId = Auth::id();

        // Handle different payment methods
        switch ($request->payment_method) {
            case 'touch_n_go':
                $paymentType = 'Touch n Go eWallet';
                break;

            case 'card':
                $request->validate([
                    'card_number' => 'required|digits:16',
                    'cardholder_name' => 'required|string',
                    'expiry_date' => 'required|date_format:m/y',
                    'cvv' => 'required|digits:3',
                ]);
                $paymentType = 'Credit/Debit Card';
                break;
            
            case 'online_banking':
                $request->validate([
                    'bank_name' => 'required|string',
                    'account_number' => 'required|string',
                ]);
                $paymentType = 'Online Banking';
                break;
                
            default:
                return back()->withErrors(['payment_method' => 'Invalid payment method selected.']);                
        }

        // Clear cart
        Cart::where('userId', $userId)->delete();

        return redirect()->route('home')->with('success', 'Payment successful! Your order has been placed.');
    }
}

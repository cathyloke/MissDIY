<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        return view('payment', compact('selectedItems', 'subtotal', 'userAddress'));
    }

    // Process payment
    public function process(Request $request)
    {
        $request->validate([
            'payment_method' => 'required',
        ]);

        $userId = Auth::id();

        switch ($request->payment_method) {
            case 'touch_n_go':
                $paymentType = 'Touch n Go eWallet';
                break;

            case 'card':
                $request->validate([
                    'card_number' => 'required|digits:16|numeric',
                    'cardholder_name' => 'required|string|min:3|max:255',
                    'expiry_date' => 'required|date_format:m/y',
                    'cvv' => 'required|digits:3|numeric',
                ]);
                $paymentType = 'Credit/Debit Card';
                break;

            case 'online_banking':
                $request->validate([
                    'bank_name' => 'required|string',
                    'account_number' => 'required|string|min:10',
                ]);
                $paymentType = 'Online Banking';
                break;

            default:
                return redirect()->back()->withErrors(['payment_method' => 'Invalid payment method selected.']);
                // return response()->json([
                //     'success' => false,
                //     'errors' => ['payment_method' => 'Invalid payment method selected.'],
                // ]);
        }

        Cart::where('userId', $userId)->delete(); // Clear cart after successful payment

        return redirect()->route('home')->with('success', 'Payment successful! Your order has been placed.');
    }
}

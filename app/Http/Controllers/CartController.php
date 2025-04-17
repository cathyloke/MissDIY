<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CartController extends Controller
{
    function index()
    {
        $userId = Auth::id();

        $cartItems = Cart::where('userId', $userId)->get();

        foreach ($cartItems as $item) {
            $product = $item->product;
            if ($product->trashed() || $product->quantity <= 0) {
                $item->isUnavailable = true;
            } else {
                $item->isUnavailable = false;
            }
        }

        session(['subtotal' => number_format(0.00, 2)]); // Initialize subtotal to 0.00

        return view("cart", compact('cartItems'));
    }

    function addToCart($productId, Request $request)
    {
        $product = Product::findOrFail($productId);
        $quantity = $request->input('quantity');
        $userId = Auth::id();

        $error = $this->validateProductStock($product, $quantity);
        if ($error) {
            return redirect()->route('products.index')->with('error', $error);
        }

        //Check if the product already exists in the cart
        $cartItem = Cart::where('userId', $userId)->where('productId', $productId)->first();
        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            $cart = new Cart();
            $cart->id = uniqid();
            $cart->userId = $userId;
            $cart->productId = $product->id;
            $cart->quantity = $quantity;
            $cart->save();
        }

        return redirect()->route('products.index')->with('success', 'Product added to cart successfully!');
        //display the toast message in layout/app once user authentication is done
    }

    function removeProduct($productId)
    {
        $cartItem = Cart::find($productId);

        if ($cartItem) {
            $cartItem->delete();
            return response()->json(['success' => 'Product removed from cart.']);
        } else {
            return response()->json(['error' => 'Product not found in the cart.']);
        }
    }

    function updateCartQuantity(Request $request, $cartItemId)
    {
        $cartItem = Cart::find($cartItemId);

        if (!$cartItem) {
            return response()->json(['error' => 'Product not found in the cart.'], 404);
        }

        $product = $cartItem->product;
        $requestedQuantity = $request->input('quantity');

        if ($requestedQuantity > $product->quantity) {
            return response()->json([
                'error' => 'Requested quantity exceeds available stock.',
                'resetQuantity' => 1 // optional: send back value to reset
            ], 400);
        }

        $cartItem->quantity = $requestedQuantity;
        $cartItem->save();

        return response()->json(['success' => 'Product quantity updated successfully.']);
    }

    // check quantity
    private function validateProductStock($product, $requestedQty)
    {
        if ($product->trashed() || $product->quantity <= 0) {
            return 'This product is currently unavailable.';
        }

        if ($requestedQty > $product->quantity) {
            return 'Requested quantity exceeds available stock.';
        }

        return null;
    }

}

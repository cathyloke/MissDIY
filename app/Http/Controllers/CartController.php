<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\DB;


class CartController extends Controller
{
    function index()
    {
        $userId = DB::table('users')->where('name', 'Cathy')->value('id');

        $cartItems = Cart::where('userId', $userId)->get();

        session(['subtotal' => number_format(0.00, 2)]); // Initialize subtotal to 0.00

        return view("cart", compact('cartItems'));
    }

    function addToCart($productId, Request $request)
    {
        $product = Product::findOrFail($productId);
        $quantity = $request->input('quantity');
        //temporary code to get userId**
        $userId = DB::table('users')->where('name', 'Cathy')->value('id');

        //Check if the product already exists in the cart
        $cartItem = Cart::where('userId', $userId)->where('productId', $productId)->first();
        if ($cartItem) {
            $cartItem->productQty += $quantity;
            $cartItem->save();
        } else {
            $cart = new Cart();
            $cart->id = uniqid();
            $cart->userId = $userId;
            $cart->productId = $product->id;
            $cart->productImg = $product->image;
            $cart->productName = $product->name;
            $cart->productPrice = $product->price;
            $cart->productQty = $quantity;
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

    function updateCartQuantity(Request $request, $productId)
    {
        $cartItem = Cart::find($productId);
        if ($cartItem) {
            $cartItem->productQty = $request->input('quantity');
            $cartItem->save();
            return response()->json(['success' => 'Product quantity updated successfully.']);
        } else {
            return response()->json(['error' => 'Product not found in the cart.']);
        }
    }
}

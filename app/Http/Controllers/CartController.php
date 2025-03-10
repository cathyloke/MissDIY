<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
    function index(){
        $cart = Cart::all();
        return view("cart");
    }

    function removeProduct($productId){
        $product=Cart::find( $productId );
        $product->delete();
        return redirect("index");
    }
}

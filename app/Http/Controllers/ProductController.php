<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ProductController extends Controller
{
    function index(Request $request)
    {
        $categoryId = $request->query('categoryId');

        if (!$categoryId) {
            // When "All Categories" is selected
            $products = Product::all();
            $category = null; 
        } else {
            $category = Category::where('id', $categoryId)->first();

            // Fetch products for the given category
            $products = Product::where('categoryId', $categoryId)->get();
        }

        return view("products.index", compact('products', 'category'));
    }

    function show($id)
    {
        $product = Product::findOrFail($id);

        if(request()->expectsJson()) {
            return response()->json($product);
        }
        
        return view('products.show', compact('product'));
    }

}

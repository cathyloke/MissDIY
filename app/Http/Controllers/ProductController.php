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
        $sortOrder = $request->query('sort', 'asc'); 
        
        $categories = Category::all();
        $query = Product::query();
        
        if ($categoryId) {
            $query->where('categoryId', $categoryId);
        }
        
        $products = $query->orderBy('price', $sortOrder)->get();
        $selectedCategory = $categoryId ? Category::find($categoryId) : null;
        
        return view("products.index", compact('products', 'categories', 'selectedCategory', 'sortOrder'));
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

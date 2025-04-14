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


    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:0',
            'categoryId' => 'required|exists:category,id', 
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->categoryId = $request->categoryId; 

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $product->image = basename($imagePath);
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::withTrashed()->findOrFail($id);

        if ($request->has('status')) {
            if ($request->status == 'unavailable') {
                $product->quantity = 0;
                $product->save();
                if (!$product->trashed()) {
                    $product->delete();
                }
            } elseif ($request->status == 'available' && $product->trashed()) {
                $product->restore();
            }
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'categoryId' => 'required|exists:category,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product->name = $request->name;
        $product->price = $request->price;
        $product->categoryId = $request->categoryId;

        // Only overwrite quantity if status is 'available'
        if ($request->status === 'available') {
            $product->quantity = $request->quantity;
        }

        if ($request->hasFile('image')) {
            if ($product->image && \File::exists(public_path('images/' . $product->image))) {
                \File::delete(public_path('images/' . $product->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $product->image = $filename;
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }


}

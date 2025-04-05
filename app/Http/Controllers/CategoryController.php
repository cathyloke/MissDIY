<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryController extends Controller
{
    function getCategories(): View
    {
        $categories = Category::withCount('products')->get();
        return view('layouts.app', compact('categories'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(request()->hasCookie('recent_products')){
            $recentIds = explode(',', request()->cookie('recent_products', ''));
            $recentProducts = Product::whereIn('id', $recentIds)->get(); 
            return view('home', compact('recentProducts'));
        }
        $newProducts = Product::orderBy('created_at', 'desc')->take(3)->get();
        return view('home', compact('newProducts'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('featured', true)->with('category')->take(8)->get();
        $categories = Category::take(6)->get();
        $newArrivals = Product::where('is_new_arrival', true)->with('images')->latest()->get();

        return view('home', compact('featuredProducts', 'categories', 'newArrivals'));
    }
}

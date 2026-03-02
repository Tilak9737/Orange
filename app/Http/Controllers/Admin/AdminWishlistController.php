<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminWishlistController extends Controller
{
    /**
     * Display a listing of products with their wishlist counts.
     */
    public function index()
    {
        $products = Product::has('wishlists')
            ->withCount('wishlists')
            ->orderBy('wishlists_count', 'desc')
            ->paginate(10);

        return view('admin.wishlists.index', compact('products'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Review;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        // Optional: Check if user bought the product
        $hasOrdered = Order::where('user_id', Auth::id())
            ->where('status', '!=', 'cancelled')
            ->whereHas('items', function ($q) use ($request) {
                $q->where('product_id', $request->product_id);
            })->exists();

        if (!$hasOrdered) {
            return redirect()->back()->with('error', 'You can only review products you have purchased.');
        }

        // Check if already reviewed
        $existing = Review::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'You have already reviewed this product.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        // Update product average rating (optional optimization)
        $product = \App\Models\Product::find($request->product_id);
        $product->rating_avg = $product->reviews()->avg('rating');
        $product->save();

        return redirect()->back()->with('success', 'Thank you for your review!');
    }
}

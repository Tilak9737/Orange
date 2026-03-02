<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cart = $this->cartService->getCart()->load('items.product');
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1'
            ]);

            $cart = $this->cartService->getCart();
            $product = Product::findOrFail($request->product_id);

            if ($product->stock <= 0) {
                return response()->json(['success' => false, 'message' => 'This product is currently sold out.'], 422);
            }

            $cartItem = $cart->items()->where('product_id', $product->id)->first();
            $currentQty = $cartItem ? $cartItem->quantity : 0;
            $newQty = $currentQty + $request->quantity;

            if ($newQty > $product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => "Only {$product->stock} units are available. You already have {$currentQty} in your cart."
                ], 422);
            }

            if ($cartItem) {
                $cartItem->quantity = $newQty;
                $cartItem->save();
            } else {
                $cart->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $request->quantity
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart',
                'cart_count' => $cart->items()->sum('quantity')
            ]);
        } catch (\Exception $e) {
            Log::error('Cart Add Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'item_id' => 'required|exists:cart_items,id',
                'quantity' => 'required|integer|min:1'
            ]);

            $cart = $this->cartService->getCart();
            $cartItem = CartItem::where('id', $request->item_id)
                ->where('cart_id', $cart->id)
                ->with('product')
                ->firstOrFail();

            if ($request->quantity > $cartItem->product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => "Only {$cartItem->product->stock} units are available."
                ], 422);
            }

            $cartItem->update(['quantity' => $request->quantity]);

            $cart->load('items.product');
            $total = collect($cart->items)->sum(function ($item) {
                return ($item->product->sale_price ?? $item->product->price) * $item->quantity;
            });

            return response()->json([
                'success' => true,
                'item_total' => ($cartItem->product->sale_price ?? $cartItem->product->price) * $cartItem->quantity,
                'cart_total' => $total,
                'cart_count' => $cart->items()->sum('quantity')
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function remove(Request $request)
    {
        try {
            $request->validate([
                'item_id' => 'required|exists:cart_items,id'
            ]);

            $cart = $this->cartService->getCart();
            $cartItem = CartItem::where('id', $request->item_id)
                ->where('cart_id', $cart->id)
                ->firstOrFail();

            $cartItem->delete();

            $cart->load('items.product');
            $total = collect($cart->items)->sum(function ($item) {
                return ($item->product->sale_price ?? $item->product->price) * $item->quantity;
            });

            return response()->json([
                'success' => true,
                'cart_total' => $total,
                'cart_count' => $cart->items()->sum('quantity')
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }
}

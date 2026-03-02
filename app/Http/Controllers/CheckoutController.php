<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $total = $this->calculateCartTotal($cart);

        return view('checkout.index', compact('cart', 'total'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'city' => 'required|string',
            'zip' => 'required|string',
        ]);

        $cart = Cart::with('items.product')->where('user_id', Auth::id())->firstOrFail();

        if ($cart->items->isEmpty()) {
            return redirect()->back()->with('error', 'Cart is empty');
        }

        DB::beginTransaction();
        try {
            $total = $this->calculateCartTotal($cart);

            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $total,
                'status' => 'pending',
                'shipping_address' => [
                    'address' => $request->address,
                    'city' => $request->city,
                    'zip' => $request->zip,
                ]
            ]);

            foreach ($cart->items as $item) {
                // Skip if product was somehow deleted
                if (!$item->product) {
                    continue;
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                // Update stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Clear cart
            $cart->items()->delete();

            DB::commit();

            return redirect()->route('checkout.success', $order);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    /**
     * Calculate the total price of items in the cart.
     *
     * @param Cart $cart
     * @return float
     */
    private function calculateCartTotal(Cart $cart): float
    {
        return (float) $cart->items->reduce(function ($carry, $item) {
            return $carry + ($item->product ? $item->product->price * $item->quantity : 0);
        }, 0);
    }

    public function success(Order $order)
    {
        // Security check
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('checkout.success', compact('order'));
    }
}

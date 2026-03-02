@extends('layouts.app')

@section('title', 'Orange | Your Cart')

@section('content')
    <div class="pt-32 pb-24 min-h-[80vh]">
        <div class="container mx-auto px-6">

            <div class="flex items-end justify-between border-b border-gray-800 pb-6 mb-8" data-aos="fade-up">
                <div>
                    <h1 class="text-4xl md:text-5xl font-heading font-black">Your Cart</h1>
                    <p class="text-text-muted mt-2">{{ $cart ? $cart->items->count() : 0 }} items in your cart</p>
                </div>
                <a href="{{ route('shop') }}" class="btn btn-outline text-sm interactive hidden sm:flex">Continue
                    Shopping</a>
            </div>

            @if($cart && $cart->items->count() > 0)
                <div class="flex flex-col lg:flex-row gap-12">

                    <!-- Cart Items -->
                    <div class="w-full lg:w-2/3">
                        <div
                            class="hidden sm:grid grid-cols-12 gap-4 pb-4 border-b border-gray-800 text-sm font-medium text-text-muted mb-6">
                            <div class="col-span-6">Product</div>
                            <div class="col-span-3 text-center">Quantity</div>
                            <div class="col-span-2 text-right">Total</div>
                            <div class="col-span-1"></div>
                        </div>

                        <div class="space-y-6">
                            @foreach($cart->items as $index => $item)
                                <div class="cart-item glass-panel p-4 rounded-xl flex flex-col sm:grid sm:grid-cols-12 gap-4 items-center group transition-all"
                                    data-id="{{ $item->id }}" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">

                                    <!-- Product Details -->
                                    <div class="col-span-6 flex items-center gap-4 w-full">
                                        <a href="{{ route('product.show', $item->product->slug) }}"
                                            class="w-24 h-24 rounded-lg overflow-hidden flex-shrink-0 bg-surface">
                                            @if(!empty($item->product->images) && count($item->product->images) > 0)
                                                <img src="{{ (\Illuminate\Support\Str::startsWith($item->product->images[0]['path'], ['http://', 'https://']) ? $item->product->images[0]['path'] : Storage::url($item->product->images[0]['path'])) }}"
                                                    alt="{{ $item->product->name }}"
                                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                            @else
                                                <i
                                                    class="ri-image-line text-2xl text-text-muted flex items-center justify-center w-full h-full"></i>
                                            @endif
                                        </a>
                                        <div>
                                            <h3 class="font-heading font-bold text-lg mb-1 line-clamp-2">
                                                <a href="{{ route('product.show', $item->product->slug) }}"
                                                    class="hover:text-orange transition-colors interactive">{{ $item->product->name }}</a>
                                            </h3>
                                            <div class="text-orange font-bold">
                                                ${{ number_format($item->product->sale_price ?? $item->product->price, 2) }}</div>
                                        </div>
                                    </div>

                                    <!-- Quantity -->
                                    <div class="col-span-3 flex justify-center w-full sm:w-auto mt-4 sm:mt-0">
                                        <div class="flex items-center bg-bg rounded-lg border border-gray-800 h-10 px-1">
                                            <button type="button" onclick="updateCartItem({{ $item->id }}, -1)"
                                                class="w-8 h-8 flex items-center justify-center text-text-muted hover:text-orange transition-colors interactive">
                                                <i class="ri-subtract-line"></i>
                                            </button>
                                            <input type="number" id="qty-{{ $item->id }}" value="{{ $item->quantity }}" min="1"
                                                max="{{ $item->product->stock }}"
                                                class="w-10 text-center bg-transparent font-bold focus:outline-none appearance-none m-0 text-sm"
                                                readonly>
                                            <button type="button" onclick="updateCartItem({{ $item->id }}, 1)"
                                                class="w-8 h-8 flex items-center justify-center text-text-muted hover:text-orange transition-colors interactive">
                                                <i class="ri-add-line"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Subtotal -->
                                    <div class="col-span-2 text-right w-full sm:w-auto mt-2 sm:mt-0 flex justify-between sm:block">
                                        <span class="sm:hidden text-text-muted">Total:</span>
                                        <span class="font-bold text-lg item-total"
                                            data-price="{{ $item->product->sale_price ?? $item->product->price }}">${{ number_format(($item->product->sale_price ?? $item->product->price) * $item->quantity, 2) }}</span>
                                    </div>

                                    <!-- Remove -->
                                    <div class="col-span-1 flex justify-end w-full sm:w-auto">
                                        <button onclick="removeCartItem({{ $item->id }}, this)"
                                            class="w-10 h-10 rounded-full hover:bg-red-500/20 text-text-muted hover:text-red-500 flex items-center justify-center transition-colors interactive">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="w-full lg:w-1/3" data-aos="fade-left">
                        <div class="glass-panel p-8 rounded-2xl sticky top-24">
                            <h2 class="text-2xl font-heading font-bold mb-6">Order Summary</h2>

                            <div class="space-y-4 mb-8">
                                <div class="flex justify-between text-text-muted">
                                    <span>Subtotal</span>
                                    <span id="cart-subtotal" class="font-medium text-white">$0.00</span>
                                </div>
                                <div class="flex justify-between text-text-muted">
                                    <span>Shipping</span>
                                    <span>Calculated at checkout</span>
                                </div>
                                <div class="flex justify-between text-text-muted">
                                    <span>Taxes</span>
                                    <span>Calculated at checkout</span>
                                </div>
                            </div>

                            <div class="border-t border-gray-800 pt-6 mb-8 flex justify-between items-center">
                                <span class="text-lg font-medium">Estimated Total</span>
                                <span id="cart-total" class="text-3xl font-black font-heading text-orange">$0.00</span>
                            </div>

                            <a href="{{ route('checkout') }}"
                                class="btn btn-primary w-full text-lg py-4 shadow-orange interactive">
                                Proceed to Checkout <i class="ri-arrow-right-line ml-2"></i>
                            </a>

                            <div class="mt-6 flex items-center gap-2 text-xs text-text-muted justify-center">
                                <i class="ri-lock-2-line"></i> Secure Payment Processing
                            </div>
                        </div>
                    </div>

                </div>
            @else
                <!-- Empty Cart -->
                <div class="glass-panel text-center py-24 rounded-2xl flex flex-col items-center justify-center max-w-2xl mx-auto"
                    data-aos="zoom-in">
                    <div class="w-32 h-32 mb-8 relative">
                        <!-- Setup animated GSAP empty cart icon -->
                        <div class="absolute inset-0 bg-orange blur-2xl opacity-20 rounded-full"></div>
                        <i class="ri-shopping-cart-line text-7xl text-orange relative z-10 empty-cart-icon inline-block"></i>
                    </div>
                    <h2 class="text-3xl font-heading font-bold mb-4">Your cart is empty</h2>
                    <p class="text-text-muted mb-8 text-lg">Looks like you haven't added any heat to your cart yet.</p>
                    <a href="{{ route('shop') }}" class="btn btn-primary px-8 py-3 text-lg interactive">Start Shopping</a>
                </div>
            @endif

        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Hide number input arrows here too */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            calculateTotals();

            // GSAP Empty Cart Animation
            if (document.querySelector('.empty-cart-icon')) {
                gsap.to('.empty-cart-icon', {
                    x: 20,
                    yoyo: true,
                    repeat: -1,
                    duration: 1.5,
                    ease: "power1.inOut"
                });
            }
        });

        function calculateTotals() {
            let subtotal = 0;
            document.querySelectorAll('.item-total').forEach(el => {
                const price = parseFloat(el.getAttribute('data-price'));
                const qty = parseInt(document.getElementById('qty-' + el.closest('.cart-item').getAttribute('data-id')).value);
                const lineTotal = price * qty;
                el.innerText = '$' + lineTotal.toFixed(2);
                subtotal += lineTotal;
            });

            const subtotalEl = document.getElementById('cart-subtotal');
            const totalEl = document.getElementById('cart-total');

            if (subtotalEl && totalEl) {
                subtotalEl.innerText = '$' + subtotal.toFixed(2);
                totalEl.innerText = '$' + subtotal.toFixed(2);
            }
        }

        async function updateCartItem(id, change) {
            const input = document.getElementById('qty-' + id);
            let val = parseInt(input.value) + change;
            const max = parseInt(input.getAttribute('max'));

            if (val < 1) val = 1;
            if (val > max) {
                showToast(`Sorry, only ${max} items left in stock.`, 'warning');
                val = max;
            }

            // If no change, do nothing
            if (val === parseInt(input.value)) return;

            // Update UI optimistically
            input.value = val;
            calculateTotals();

            // Sync with server
            try {
                const data = await fetchJson(`{{ route('cart.update') }}`, {
                    method: 'POST',
                    body: JSON.stringify({ item_id: id, quantity: val })
                });

                if (data.success) {
                    // Update global badge
                    document.querySelectorAll('.cart-count').forEach(badge => badge.textContent = data.cart_count);
                }
            } catch (error) {
                // Revert on failure
                input.value = val - change;
                calculateTotals();
            }
        }

        async function removeCartItem(id, btn) {
            const row = btn.closest('.cart-item');

            // Animate row removal
            gsap.to(row, {
                x: -100,
                opacity: 0,
                duration: 0.3,
                onComplete: () => {
                    row.remove();
                    calculateTotals();

                    // If cart is empty now, reload page to show empty state
                    if (document.querySelectorAll('.cart-item').length === 0) {
                        window.location.reload();
                    }
                }
            });

            try {
                const data = await fetchJson(`{{ route('cart.remove') }}`, {
                    method: 'POST',
                    body: JSON.stringify({ item_id: id })
                });

                if (data.success) {
                    showToast('Item removed from cart');
                    document.querySelectorAll('.cart-count').forEach(badge => badge.textContent = data.cart_count);
                }
            } catch (error) {
                // Error handling done by fetchJson
                window.location.reload(); // Fallback reload
            }
        }
    </script>
@endpush
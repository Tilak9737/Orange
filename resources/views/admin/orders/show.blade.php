@extends('layouts.admin')

@section('title', 'Order Details #' . str_pad($order->id, 6, '0', STR_PAD_LEFT))

@section('content')
    <div class="space-y-6 max-w-6xl">

        <!-- Top Actions -->
        <div class="flex items-center justify-between mb-6" data-aos="fade-right">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.orders.index') }}"
                    class="w-10 h-10 rounded-full bg-surface border border-gray-800 flex items-center justify-center text-text-muted hover:text-white transition-colors interactive">
                    <i class="ri-arrow-left-line"></i>
                </a>
                <div>
                    <h2 class="text-2xl font-heading font-bold flex items-center gap-3">
                        Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                        <span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider
                                            @if($order->status == 'pending') bg-yellow-500/10 text-yellow-500 border border-yellow-500/20
                                            @elseif($order->status == 'processing') bg-blue-500/10 text-blue-500 border border-blue-500/20
                                            @elseif($order->status == 'shipped') bg-purple-500/10 text-purple-400 border border-purple-500/20
                                            @elseif($order->status == 'delivered') bg-green-500/10 text-green-400 border border-green-500/20
                                            @else bg-red-500/10 text-red-500 border border-red-500/20 @endif">
                            {{ $order->status }}
                        </span>
                    </h2>
                    <p class="text-sm text-text-muted mt-1">{{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
                </div>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('admin.orders.export', $order->id) }}"
                    class="btn btn-outline text-sm py-2 px-3 hover:border-orange hover:text-orange transition-colors">
                    <i class="ri-printer-line mr-2"></i> Print Invoice
                </a>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" data-aos="fade-up">

            <!-- Left Column: Order Items & Status -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Items Card -->
                <div class="glass-panel p-6 rounded-2xl border border-gray-800">
                    <h3 class="text-lg font-heading font-bold mb-4 border-b border-gray-800 pb-4">Order Items
                        ({{ $order->items->sum('quantity') }})</h3>

                    <div class="space-y-4">
                        @foreach($order->items as $item)
                            <div class="flex gap-4 items-center p-3 rounded-xl hover:bg-surface-hover/50 transition-colors">
                                <div
                                    class="w-16 h-16 rounded-lg bg-surface border border-gray-800 flex-shrink-0 overflow-hidden relative">
                                    @if(!empty($item->product->images) && count($item->product->images) > 0)
                                        <img src="{{ (\Illuminate\Support\Str::startsWith($item->product->images[0]['path'], ['http://', 'https://']) ? $item->product->images[0]['path'] : Storage::url($item->product->images[0]['path'])) }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-600"><i
                                                class="ri-image-line text-xl"></i></div>
                                    @endif
                                    <!-- Quantity Badge -->
                                    <span
                                        class="absolute -top-2 -right-2 w-5 h-5 bg-orange text-white text-[10px] rounded-full flex items-center justify-center font-bold z-10">{{ $item->quantity }}</span>
                                </div>
                                <div class="flex-grow">
                                    <h4 class="font-bold text-sm leading-tight mb-1">
                                        <a href="{{ route('product.show', $item->product->slug) }}" target="_blank"
                                            class="hover:text-orange transition-colors">{{ $item->product->name }}</a>
                                    </h4>
                                    <div class="text-xs text-text-muted">SKU:
                                        {{ strtoupper(substr(md5($item->product->id), 0, 8)) }}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold">${{ number_format($item->price * $item->quantity, 2) }}</div>
                                    <div class="text-xs text-text-muted">${{ number_format($item->price, 2) }} each</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Totals -->
                    <div class="mt-6 pt-6 border-t border-gray-800 space-y-3">
                        <div class="flex justify-between text-sm text-text-muted">
                            <span>Subtotal</span>
                            <span>${{ number_format($order->total, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-text-muted">
                            <span>Shipping</span>
                            <span>$0.00</span>
                        </div>
                        @if($order->coupon)
                            <div class="flex justify-between text-sm text-emerald-400 font-bold">
                                <span>Discount ({{ $order->coupon->code }})</span>
                                <span>-${{ number_format($order->coupon->value, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between text-lg font-bold font-heading pt-3 border-t border-gray-800">
                            <span>Total</span>
                            <span class="text-orange">${{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Status Update Card -->
                <div class="glass-panel p-6 rounded-2xl border border-gray-800">
                    <h3 class="text-lg font-heading font-bold mb-4 border-b border-gray-800 pb-4">Update Order Status</h3>

                    <form action="{{ route('admin.orders.update', $order) }}" method="POST"
                        class="flex flex-col sm:flex-row gap-4 items-end">
                        @csrf
                        @method('PUT')

                        <div class="flex-grow w-full">
                            <label class="block text-sm font-medium mb-2 text-text-muted">Status</label>
                            <select name="status" class="form-control bg-surface text-white">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing
                                </option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered
                                </option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                                </option>
                            </select>
                        </div>

                        <button type="submit"
                            class="btn btn-primary interactive w-full sm:w-auto h-[46px] whitespace-nowrap">
                            Update Status
                        </button>
                    </form>
                </div>

            </div>

            <!-- Right Column: Customer & Shipping Info -->
            <div class="space-y-6">

                <!-- Customer Card -->
                <div class="glass-panel p-6 rounded-2xl border border-gray-800">
                    <h3 class="text-lg font-heading font-bold mb-4 border-b border-gray-800 pb-4">
                        Customer Info
                    </h3>

                    <div class="flex items-center gap-4 mb-6">
                        <div
                            class="w-12 h-12 rounded-full bg-orange-glow border border-orange flex items-center justify-center text-orange font-bold text-lg uppercase">
                            {{ substr($order->user->name, 0, 1) }}
                        </div>
                        <div>
                            <div class="font-bold">{{ $order->user->name }}</div>
                            <div class="text-sm text-text-muted">{{ $order->user->orders->count() }} Orders</div>
                        </div>
                    </div>

                    <div class="space-y-3 text-sm">
                        <div class="flex items-start gap-3">
                            <i class="ri-mail-line text-text-muted mt-0.5"></i>
                            <a href="mailto:{{ $order->user->email }}"
                                class="text-white hover:text-orange transition-colors truncate">{{ $order->user->email }}</a>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="ri-phone-line text-text-muted mt-0.5"></i>
                            <a href="tel:{{ $order->shipping_address['phone'] ?? 'N/A' }}"
                                class="text-white hover:text-orange transition-colors">{{ $order->shipping_address['phone'] ?? 'No phone provided' }}</a>
                        </div>
                    </div>
                </div>

                <!-- Shipping Card -->
                <div class="glass-panel p-6 rounded-2xl border border-gray-800">
                    <h3 class="text-lg font-heading font-bold mb-4 border-b border-gray-800 pb-4">Shipping Address</h3>

                    @if(isset($order->shipping_address['address']))
                        <div class="text-sm space-y-1 text-gray-300">
                            <p class="font-bold text-white">{{ $order->shipping_address['first_name'] ?? '' }}
                                {{ $order->shipping_address['last_name'] ?? '' }}
                            </p>
                            <p>{{ $order->shipping_address['address'] ?? '' }}</p>
                            <p>{{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['state'] ?? '' }}
                                {{ $order->shipping_address['zip'] ?? '' }}
                            </p>
                            <p class="uppercase">{{ $order->shipping_address['country'] ?? '' }}</p>
                        </div>

                        <div class="mt-4 pt-4 border-t border-gray-800">
                            <a href="https://maps.google.com/?q={{ urlencode($order->shipping_address['address'] . ' ' . $order->shipping_address['city'] . ' ' . $order->shipping_address['zip']) }}"
                                target="_blank" class="text-sm text-orange hover:underline flex items-center gap-1">
                                <i class="ri-map-pin-line"></i> View on Map
                            </a>
                        </div>
                    @else
                        <p class="text-sm text-text-muted italic">No shipping details provided (Digital order or error).</p>
                    @endif
                </div>

                <!-- Payment Card -->
                <div class="glass-panel p-6 rounded-2xl border border-gray-800">
                    <h3 class="text-lg font-heading font-bold mb-4 border-b border-gray-800 pb-4">Payment Information</h3>

                    <div class="flex items-center gap-3 text-sm mb-2">
                        <i class="ri-secure-payment-line text-xl text-emerald-400"></i>
                        <div>
                            <div class="font-bold">Payment Approved</div>
                            <div class="text-xs text-text-muted">Demo Transaction</div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
@extends('layouts.app')

@section('title', 'Orange | Your Orders')

@section('content')
    <div class="pt-32 pb-24 min-h-screen bg-bg">
        <div class="container mx-auto px-6 max-w-6xl">

            <div class="flex items-end justify-between border-b border-gray-800 pb-6 mb-8" data-aos="fade-up">
                <div>
                    <h1 class="text-4xl font-heading font-black">Order History</h1>
                    <p class="text-text-muted mt-2">Track and manage your past purchases.</p>
                </div>
                <a href="{{ route('profile.edit') }}" class="btn btn-outline text-sm interactive hidden sm:flex">
                    <i class="ri-user-settings-line mr-2"></i> Profile Settings
                </a>
            </div>

            @if($orders->count() > 0)
                <div class="space-y-6">
                    @foreach($orders as $index => $order)
                        <div class="glass-panel p-6 rounded-2xl border border-gray-800 hover:border-orange/50 transition-colors"
                            data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">

                            <!-- Order Header -->
                            <div
                                class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6 pb-6 border-b border-gray-800">
                                <div>
                                    <div class="flex items-center gap-3 mb-1">
                                        <span class="text-lg font-bold">Order #{{ $order->id }}</span>
                                        <span class="px-2 py-1 rounded text-xs font-bold uppercase tracking-wider
                                                @if($order->status == 'pending') bg-yellow-500/20 text-yellow-500
                                                @elseif($order->status == 'processing') bg-blue-500/20 text-blue-500
                                                @elseif($order->status == 'shipped') bg-purple-500/20 text-purple-400
                                                @elseif($order->status == 'delivered') bg-green-500/20 text-green-400
                                                @else bg-red-500/20 text-red-500 @endif">
                                            {{ $order->status }}
                                        </span>
                                    </div>
                                    <span class="text-sm text-text-muted">Placed on
                                        {{ $order->created_at->format('M d, Y') }}</span>
                                </div>

                                <div class="text-left md:text-right">
                                    <span class="block text-sm text-text-muted mb-1">Total Amount</span>
                                    <span
                                        class="text-2xl font-black font-heading text-orange">${{ number_format($order->total, 2) }}</span>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="space-y-4">
                                @foreach($order->items as $item)
                                    <div class="flex items-center gap-4">
                                        <a href="{{ route('product.show', $item->product->slug) }}"
                                            class="w-16 h-16 rounded-lg overflow-hidden bg-surface flex-shrink-0 relative group interactive">
                                            @if(!empty($item->product->images) && count($item->product->images) > 0)
                                                <img src="{{ (\Illuminate\Support\Str::startsWith($item->product->images[0]['path'], ['http://', 'https://']) ? $item->product->images[0]['path'] : Storage::url($item->product->images[0]['path'])) }}"
                                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                                            @else
                                                <i class="ri-image-line text-text-muted flex items-center justify-center w-full h-full"></i>
                                            @endif
                                            <!-- Qty Badge -->
                                            <span
                                                class="absolute -top-1 -right-1 w-5 h-5 bg-orange text-white text-[10px] font-bold rounded-full flex items-center justify-center border border-bg">{{ $item->quantity }}</span>
                                        </a>
                                        <div class="flex-grow">
                                            <a href="{{ route('product.show', $item->product->slug) }}"
                                                class="text-sm font-bold hover:text-orange transition-colors interactive line-clamp-1">{{ $item->product->name }}</a>
                                            <span class="text-xs text-text-muted">${{ number_format($item->price, 2) }} each</span>
                                        </div>
                                        <!-- View/Review button could go here -->
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8 flex justify-center custom-pagination">
                    {{ $orders->links() }}
                </div>

            @else
                <!-- Empty State -->
                <div class="glass-panel text-center py-20 rounded-2xl border border-gray-800" data-aos="zoom-in">
                    <div
                        class="w-24 h-24 mx-auto rounded-full bg-surface-hover flex items-center justify-center mb-6 text-orange text-4xl">
                        <i class="ri-shopping-bag-3-line"></i>
                    </div>
                    <h3 class="text-2xl font-heading font-bold mb-2">No orders yet</h3>
                    <p class="text-text-muted mb-6">When you place an order, it will appear here.</p>
                    <a href="{{ route('shop') }}" class="btn btn-primary interactive">Start Shopping</a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .bg-yellow-500\/20 {
            background-color: rgba(234, 179, 8, 0.2);
        }

        .text-yellow-500 {
            color: #eab308;
        }

        .bg-blue-500\/20 {
            background-color: rgba(59, 130, 246, 0.2);
        }

        .text-blue-500 {
            color: #3b82f6;
        }

        .bg-purple-500\/20 {
            background-color: rgba(168, 85, 247, 0.2);
        }

        .text-purple-400 {
            color: #c084fc;
        }

        .text-green-400 {
            color: #4ade80;
        }

        .bg-red-500\/20 {
            background-color: rgba(239, 68, 68, 0.2);
        }

        .text-red-500 {
            color: #ef4444;
        }

        .w-16 {
            width: 4rem;
        }

        .h-16 {
            height: 4rem;
        }

        .-top-1 {
            top: -0.25rem;
        }

        .-right-1 {
            right: -0.25rem;
        }

        .w-5 {
            width: 1.25rem;
        }

        .h-5 {
            height: 1.25rem;
        }

        .text-\[10px\] {
            font-size: 10px;
        }

        .border-bg {
            border-color: var(--c-bg);
        }

        .hover\:scale-110:hover {
            transform: scale(1.1);
        }

        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Pagination style reuse */
        .custom-pagination nav {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }

        .custom-pagination a,
        .custom-pagination span[aria-disabled] {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 36px;
            height: 36px;
            border-radius: 6px;
            background: var(--c-surface);
            border: 1px solid #1f2937;
            color: var(--c-text-muted);
            font-size: 0.875rem;
        }

        .custom-pagination a:hover {
            border-color: var(--c-orange);
            color: var(--c-orange);
        }

        .custom-pagination span[aria-current="page"]>span {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 36px;
            height: 36px;
            border-radius: 6px;
            background: var(--c-orange);
            color: white;
            border-color: var(--c-orange);
        }

        .custom-pagination p {
            display: none;
        }
    </style>
@endpush
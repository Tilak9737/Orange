@extends('layouts.admin')

@section('title', 'Wishlist Management')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center bg-surface p-6 rounded-2xl border border-gray-800" data-aos="fade-down">
            <div>
                <h2 class="text-2xl font-heading font-bold mb-1">Wishlist Insights</h2>
                <p class="text-text-muted text-sm">Discover which products your customers are most excited about.</p>
            </div>
            <div
                class="w-12 h-12 rounded-xl bg-orange-glow text-orange flex items-center justify-center text-xl">
                <i class="ri-heart-line"></i>
            </div>
        </div>

        <!-- Wishlists Table -->
        <div class="glass-panel rounded-2xl border border-gray-800 overflow-hidden" data-aos="fade-up">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-hover/50 text-text-muted text-xs uppercase tracking-widest font-bold">
                            <th class="px-6 py-4 border-b border-gray-800">Product</th>
                            <th class="px-6 py-4 border-b border-gray-800">Category</th>
                            <th class="px-6 py-4 border-b border-gray-800 text-center">Stock Status</th>
                            <th class="px-6 py-4 border-b border-gray-800 text-center text-orange">Wishlist Count</th>
                            <th class="px-6 py-4 border-b border-gray-800 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @forelse($products as $product)
                            <tr class="hover:bg-surface-hover/30 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-lg bg-surface border border-gray-700 overflow-hidden">
                                            @if(!empty($product->images) && count($product->images) > 0)
                                                <img src="{{ (\Illuminate\Support\Str::startsWith($product->images[0]['path'], ['http://', 'https://']) ? $product->images[0]['path'] : Storage::url($product->images[0]['path'])) }}" 
                                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-600">
                                                    <i class="ri-image-line"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-bold text-white">{{ $product->name }}</div>
                                            <div class="text-xs text-text-muted">ID: #{{ $product->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-text-muted font-medium">{{ $product->category->name }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($product->stock <= 0)
                                        <span class="px-2.5 py-1 rounded-md bg-red-500/10 text-red-500 text-[10px] font-bold uppercase tracking-wider">Sold Out</span>
                                    @elseif($product->stock <= 5)
                                        <span class="px-2.5 py-1 rounded-md bg-orange-glow text-orange text-[10px] font-bold uppercase tracking-wider">Low Stock ({{ $product->stock }})</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-md bg-green-500/10 text-green-500 text-[10px] font-bold uppercase tracking-wider">In Stock ({{ $product->stock }})</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="inline-flex items-center gap-2 bg-orange-glow px-4 py-1.5 rounded-full border border-orange/20">
                                        <i class="ri-heart-fill text-orange text-sm"></i>
                                        <span class="font-black text-orange">{{ number_format($product->wishlists_count) }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('product.show', $product->slug) }}" target="_blank"
                                            class="w-8 h-8 rounded-lg bg-surface-hover border border-gray-700 flex items-center justify-center text-text-muted hover:text-white hover:border-orange transition-all interactive" 
                                            title="View in Store">
                                            <i class="ri-external-link-line"></i>
                                        </a>
                                        <a href="{{ route('admin.products.edit', $product->id) }}"
                                            class="w-8 h-8 rounded-lg bg-surface-hover border border-gray-700 flex items-center justify-center text-text-muted hover:text-orange hover:border-orange transition-all interactive"
                                            title="Edit Product">
                                            <i class="ri-pencil-line"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-text-muted italic">
                                    <div class="flex flex-col items-center gap-3">
                                        <i class="ri-heart-line text-4xl opacity-20"></i>
                                        <p>No products have been wishlisted yet.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($products->hasPages())
                <div class="px-6 py-4 border-t border-gray-800 bg-surface-hover/30">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

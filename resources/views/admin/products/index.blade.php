@extends('layouts.admin')

@section('title', 'Manage Products')

@section('content')
    <div class="space-y-6">

        <!-- Top Actions -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <form action="{{ route('admin.products.index') }}" method="GET" class="relative w-full sm:w-96">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..."
                    class="w-full bg-surface border border-gray-800 rounded-lg py-2 pl-10 pr-4 text-sm focus:outline-none focus:border-orange transition-colors">
                <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-text-muted"></i>
            </form>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary text-sm interactive whitespace-nowrap">
                <i class="ri-add-line mr-2"></i> Add Product
            </a>
        </div>

        <!-- Products Table -->
        <div class="glass-panel rounded-2xl border border-gray-800 overflow-hidden" data-aos="fade-up">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead
                        class="bg-surface border-b border-gray-800 text-text-muted uppercase tracking-wider text-[10px] font-bold">
                        <tr>
                            <th class="px-6 py-4">Product</th>
                            <th class="px-6 py-4">Category</th>
                            <th class="px-6 py-4">Price / Sale</th>
                            <th class="px-6 py-4">Stock</th>
                            <th class="px-6 py-4">Rating</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @forelse($products as $product)
                            <tr
                                class="hover:bg-surface-hover/50 transition-colors {{ $product->featured ? 'border-l-4 border-orange bg-orange/5' : '' }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-12 h-12 rounded-lg bg-surface border border-gray-800 overflow-hidden flex-shrink-0">
                                            @if(!empty($product->images) && count($product->images) > 0)
                                                <img src="{{ (\Illuminate\Support\Str::startsWith($product->images[0]['path'], ['http://', 'https://']) ? $product->images[0]['path'] : Storage::url($product->images[0]['path'])) }}"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-600"><i
                                                        class="ri-image-line"></i></div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-bold flex items-center gap-2 flex-wrap">
                                                {{ $product->name }}
                                                @if($product->featured)
                                                    <span
                                                        class="bg-orange text-white text-[9px] px-1.5 py-0.5 rounded-sm uppercase font-black tracking-tighter">Featured</span>
                                                @endif
                                                @if($product->is_new_arrival)
                                                    <span
                                                        class="bg-emerald-500 text-black text-[9px] px-1.5 py-0.5 rounded-sm uppercase font-black tracking-tighter">New</span>
                                                @endif
                                            </div>
                                            <div class="text-xs text-text-muted mt-1">
                                                {{ Str::limit($product->description, 30) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="bg-surface border border-gray-700 px-2 py-1 rounded text-xs text-text-muted">{{ $product->category->name }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium">${{ number_format($product->price, 2) }}</div>
                                    @if($product->sale_price)
                                        <div class="text-orange text-xs font-bold mt-1">
                                            ${{ number_format($product->sale_price, 2) }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="flex items-center gap-1.5 {{ $product->stock > 10 ? 'text-emerald-400' : ($product->stock > 0 ? 'text-yellow-500' : 'text-red-500') }}">
                                        <div
                                            class="w-2 h-2 rounded-full {{ $product->stock > 10 ? 'bg-emerald-400' : ($product->stock > 0 ? 'bg-yellow-500' : 'bg-red-500') }}">
                                        </div>
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center text-[#FFC107]">
                                        <i class="ri-star-fill mr-1"></i>
                                        <span>{{ number_format($product->rating_avg, 1) }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right relative">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.products.edit', $product) }}"
                                            class="w-8 h-8 rounded-full bg-surface border border-gray-700 flex items-center justify-center hover:text-orange hover:border-orange transition-colors"
                                            title="Edit">
                                            <i class="ri-edit-line text-sm"></i>
                                        </a>

                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this product?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-8 h-8 rounded-full bg-surface border border-gray-700 flex items-center justify-center text-red-500 hover:bg-red-500 hover:text-white hover:border-red-500 transition-colors"
                                                title="Delete">
                                                <i class="ri-delete-bin-line text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-text-muted">
                                    <div
                                        class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-surface border border-gray-800 mb-4 text-2xl">
                                        <i class="ri-inbox-line"></i>
                                    </div>
                                    <p>No products found in the catalog.</p>
                                    <a href="{{ route('admin.products.create') }}"
                                        class="btn btn-outline text-sm mt-4 interactive">Create your first product</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($products->hasPages())
                <div class="p-4 border-t border-gray-800 bg-surface/50 custom-pagination">
                    {{ $products->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection

@push('styles')
    <style>
        /* Pagination reuse */
        .custom-pagination nav {
            display: flex;
            gap: 0.5rem;
            justify-content: space-between;
            align-items: center;
        }

        .custom-pagination a,
        .custom-pagination span[aria-disabled],
        .custom-pagination span[aria-current="page"]>span {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 32px;
            height: 32px;
            border-radius: 6px;
            font-size: 0.875rem;
        }

        .custom-pagination a {
            background: var(--c-surface);
            border: 1px solid #1f2937;
            color: var(--c-text-muted);
        }

        .custom-pagination a:hover {
            border-color: var(--c-orange);
            color: var(--c-orange);
        }

        .custom-pagination span[aria-current="page"]>span {
            background: var(--c-orange);
            color: white;
            border: 1px solid var(--c-orange);
        }
    </style>
@endpush
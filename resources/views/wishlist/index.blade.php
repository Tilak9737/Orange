@extends('layouts.app')

@section('title', 'Orange | Your Wishlist')

@section('content')
    <div class="pt-32 pb-24 min-h-[80vh] bg-bg">
        <div class="container mx-auto px-6 max-w-6xl">

            <div class="flex items-end justify-between border-b border-gray-800 pb-6 mb-8" data-aos="fade-up">
                <div>
                    <h1 class="text-4xl font-heading font-black">Your Wishlist <i
                            class="ri-heart-fill text-orange ml-2"></i></h1>
                    <p class="text-text-muted mt-2">Saved items you're keeping an eye on.</p>
                </div>
                <a href="{{ route('shop') }}" class="btn btn-outline text-sm interactive hidden sm:flex">
                    Discover More
                </a>
            </div>

            @if($wishlists->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($wishlists as $index => $item)
                        <div class="relative group" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}"
                            id="wishlist-item-{{ $item->product->id }}">

                            <!-- Remove button overlaid on card -->
                            <button onclick="removeFromWishlist({{ $item->product->id }})"
                                class="absolute -top-3 -right-3 z-20 w-8 h-8 rounded-full bg-surface border border-gray-800 text-text-muted hover:text-red-500 hover:border-red-500 shadow-lg flex items-center justify-center transition-all opacity-0 group-hover:opacity-100 interactive">
                                <i class="ri-close-line"></i>
                            </button>

                            <x-product-card :product="$item->product" />
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12 flex justify-center custom-pagination">
                    {{ $wishlists->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="glass-panel text-center py-24 rounded-2xl border border-gray-800 flex flex-col items-center justify-center"
                    data-aos="zoom-in">
                    <div class="w-24 h-24 mb-6 relative">
                        <div class="absolute inset-0 bg-orange blur-xl opacity-20 rounded-full"></div>
                        <i class="ri-heart-3-line text-6xl text-orange relative z-10 animate-pulse"></i>
                    </div>
                    <h3 class="text-2xl font-heading font-bold mb-2">Your wishlist is empty</h3>
                    <p class="text-text-muted mb-8">Save items you love and build your perfect collection.</p>
                    <a href="{{ route('shop') }}" class="btn btn-primary interactive px-8">Browse Products</a>
                </div>
            @endif

        </div>
    </div>
@endsection

@push('styles')
    <style>
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

@push('scripts')
    <script>
        async function removeFromWishlist(id) {
            const cardContainer = document.getElementById('wishlist-item-' + id);

            // Optimistic UI Removal with GSAP
            gsap.to(cardContainer, {
                scale: 0.8,
                opacity: 0,
                duration: 0.3,
                onComplete: () => {
                    cardContainer.style.display = 'none';
                }
            });

            try {
                const data = await fetchJson('{{ route("wishlist.toggle") }}', {
                    method: 'POST',
                    body: JSON.stringify({ product_id: id })
                });

                if (data.success && data.status === 'removed') {
                    showToast('Item removed from wishlist');
                    // Check if last element and refresh if needed
                    const visibleItems = document.querySelectorAll('[id^="wishlist-item-"]:not([style*="display: none"])');
                    if (visibleItems.length === 0) {
                        setTimeout(() => window.location.reload(), 500);
                    }
                }
            } catch (error) {
                // Revert GSAP animation on fail
                gsap.to(cardContainer, { scale: 1, opacity: 1, duration: 0.3, onComplete: () => cardContainer.style.display = '' });
            }
        }
    </script>
@endpush
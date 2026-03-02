@extends('layouts.app')

@section('title', 'Orange | ' . $product->name)

@section('content')
<div class="pt-32 pb-24 bg-bg">
    <div class="container mx-auto px-6">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center text-sm font-medium text-text-muted mb-8" data-aos="fade-in">
            <a href="{{ route('home') }}" class="hover:text-orange transition-colors">Home</a>
            <i class="ri-arrow-right-s-line mx-2"></i>
            <a href="{{ route('shop') }}" class="hover:text-orange transition-colors">Shop</a>
            <i class="ri-arrow-right-s-line mx-2"></i>
            <a href="{{ route('shop', ['category' => $product->category->slug]) }}" class="hover:text-orange transition-colors">{{ $product->category->name }}</a>
            <i class="ri-arrow-right-s-line mx-2"></i>
            <span class="text-white">{{ $product->name }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            
            <!-- Image Gallery -->
            <div class="relative" data-aos="fade-right">
                <!-- Main Image -->
                <div class="glass-panel rounded-2xl overflow-hidden aspect-square mb-4 relative group">
                    @if($product->featured)
                        <span class="absolute top-6 left-6 z-10 bg-orange text-white text-xs uppercase font-bold px-3 py-1.5 rounded-sm tracking-wider shadow-orange">Featured Heat</span>
                    @endif
                    
                    <!-- Skeleton Loader -->
                    <div id="main-skeleton" class="absolute inset-0 skeleton z-0 w-full h-full"></div>
                    
                    @if(!empty($product->images) && count($product->images) > 0)
                        <img id="main-image" src="{{ (\Illuminate\Support\Str::startsWith($product->images[0]['path'], ['http://', 'https://']) ? $product->images[0]['path'] : Storage::url($product->images[0]['path'])) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-500 cursor-zoom-in relative z-10 opacity-0" onload="this.classList.remove('opacity-0'); document.getElementById('main-skeleton').style.display='none';">
                    @else
                        <div class="w-full h-full bg-surface-hover flex items-center justify-center relative z-10">
                            <i class="ri-image-line text-6xl text-text-muted"></i>
                        </div>
                        <script>document.getElementById('main-skeleton').style.display='none';</script>
                    @endif
                    
                    <!-- Zoom Lens Effect Area -->
                    <div id="zoom-lens" class="absolute w-40 h-40 border-2 border-orange/50 rounded-full pointer-events-none hidden bg-no-repeat bg-surface/10 backdrop-blur-sm z-20"></div>
                </div>

                <!-- Thumbnails -->
                @if(!empty($product->images) && count($product->images) > 1)
                    <div class="grid grid-cols-4 gap-4">
                        @foreach($product->images as $index => $image)
                            <button onclick="changeMainImage('{{ (\Illuminate\Support\Str::startsWith($image['path'], ['http://', 'https://']) ? $image['path'] : Storage::url($image['path'])) }}', this)" 
                                    class="thumbnail-btn glass-panel aspect-square rounded-xl overflow-hidden interactive {{ $index == 0 ? 'border-2 border-orange opacity-100' : 'border border-transparent opacity-60 hover:opacity-100' }} transition-all">
                                <img src="{{ (\Illuminate\Support\Str::startsWith($image['path'], ['http://', 'https://']) ? $image['path'] : Storage::url($image['path'])) }}" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="flex flex-col justify-center" data-aos="fade-left">
                <div class="mb-8">
                    <span class="text-orange text-sm font-bold tracking-widest uppercase mb-3 block">{{ $product->category->name }}</span>
                    <h1 class="text-4xl md:text-5xl font-heading font-black mb-4">{{ $product->name }}</h1>
                    
                    <div class="flex items-center gap-4 mb-6">
                        <!-- Stars -->
                        <div class="flex items-center text-[#FFC107] text-lg">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="ri-star-{{ $i <= round($product->rating_avg) ? 'fill' : 'line' }}"></i>
                            @endfor
                            <span class="text-text-muted text-sm ml-2 font-body font-medium">({{ $product->reviews->count() }} reviews)</span>
                        </div>
                        <div class="w-1 h-1 rounded-full bg-text-muted"></div>
                        <span class="text-sm font-medium {{ $product->stock > 0 ? ($product->stock < 5 ? 'text-orange animate-pulse' : 'text-green-400') : 'text-red-400' }}">
                            @if($product->stock <= 0)
                                Sold Out
                            @elseif($product->stock < 5)
                                Only {{ $product->stock }} left in stock!
                            @else
                                In Stock ({{ $product->stock }})
                            @endif
                        </span>
                    </div>

                    <div class="flex items-end gap-3 mb-8 pb-8 border-b border-gray-800">
                        @if($product->sale_price)
                            <span class="text-4xl font-black font-heading">${{ number_format($product->sale_price, 2) }}</span>
                            <span class="text-xl text-text-muted line-through mb-1">${{ number_format($product->price, 2) }}</span>
                            <span class="bg-red-500/20 text-red-400 text-xs font-bold px-2 py-1 rounded-md mb-2 uppercase">Sale</span>
                        @else
                            <span class="text-4xl font-black font-heading">${{ number_format($product->price, 2) }}</span>
                        @endif
                    </div>

                    <div class="prose prose-invert prose-orange max-w-none text-text-muted leading-relaxed mb-10">
                        {{ $product->description }}
                    </div>

                    <!-- Add to Cart Action -->
                    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden">
                        <!-- Background glow effect -->
                        <div class="absolute -inset-4 bg-orange-glow blur-3xl opacity-20 pointer-events-none"></div>

                        <form id="add-to-cart-form" class="relative z-10 flex flex-col sm:flex-row gap-4">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            
                            <div class="flex items-center bg-bg rounded-xl border border-gray-800 h-[60px] px-2 w-full sm:w-32 justify-between {{ $product->stock <= 0 ? 'opacity-50 pointer-events-none' : '' }}">
                                <button type="button" onclick="updateQty(-1)" class="w-10 h-10 flex items-center justify-center text-text-muted hover:text-orange transition-colors interactive">
                                    <i class="ri-subtract-line"></i>
                                </button>
                                <input type="number" name="quantity" id="qty-input" value="{{ $product->stock > 0 ? 1 : 0 }}" min="{{ $product->stock > 0 ? 1 : 0 }}" max="{{ $product->stock }}" class="w-10 text-center bg-transparent font-bold focus:outline-none appearance-none m-0" readonly>
                                <button type="button" onclick="updateQty(1)" class="w-10 h-10 flex items-center justify-center text-text-muted hover:text-orange transition-colors interactive">
                                    <i class="ri-add-line"></i>
                                </button>
                            </div>

                            <button type="submit" class="btn btn-primary h-[60px] flex-grow text-lg shadow-orange interactive" {{ $product->stock == 0 ? 'disabled' : '' }}>
                                @if($product->stock > 0)
                                    Add to Cart <i class="ri-shopping-cart-2-line ml-2"></i>
                                @else
                                    Out of Stock
                                @endif
                            </button>
                            
                            <button type="button" class="w-[60px] h-[60px] rounded-xl glass-panel border border-gray-800 flex items-center justify-center text-xl hover:text-orange hover:border-orange transition-all interactive add-to-wishlist" data-id="{{ $product->id }}">
                                <i class="ri-heart-line"></i>
                            </button>
                        </form>
                        
                        <div class="mt-6 flex items-center justify-center gap-6 text-sm text-text-muted font-medium">
                            <div class="flex items-center gap-2">
                                <i class="ri-shield-check-line text-lg text-orange"></i> Secure Checkout
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="ri-truck-line text-lg text-orange"></i> Fast Shipping
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details & Reviews Tabs -->
        <div class="mt-32" data-aos="fade-up">
            <div class="border-b border-gray-800 mb-8 flex gap-8">
                <button onclick="switchTab('reviews')" id="tab-reviews" class="pb-4 font-heading font-bold text-xl text-orange border-b-2 border-orange transition-colors">Reviews ({{ $product->reviews->count() }})</button>
                <button onclick="switchTab('details')" id="tab-details" class="pb-4 font-heading font-bold text-xl text-text-muted border-b-2 border-transparent hover:text-white transition-colors">Details</button>
            </div>

            <!-- Reviews Content -->
            <div id="content-reviews" class="block animate-fade-in">
                <!-- Write Review -->
                @auth
                    <div class="glass-panel p-8 rounded-2xl mb-12">
                        <h3 class="text-2xl font-heading font-bold mb-6">Write a Review</h3>
                        <form action="{{ route('reviews.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="mb-6">
                                <label class="block text-sm font-medium mb-2 text-text-muted">Your Rating</label>
                                <div class="flex items-center gap-2 text-2xl text-gray-600" id="star-rating">
                                    <input type="hidden" name="rating" id="rating-input" required>
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="ri-star-fill cursor-pointer hover:text-[#FFC107] transition-colors star-select" data-val="{{ $i }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <div class="mb-6">
                                <label class="block text-sm font-medium mb-2 text-text-muted">Your Review</label>
                                <textarea name="comment" rows="4" class="form-control resize-none" placeholder="What did you think about this product?"></textarea>
                            </div>
                            <button type="submit" class="btn btn-outline interactive">Submit Review</button>
                        </form>
                    </div>
                @else
                    <div class="bg-surface p-6 rounded-xl border border-gray-800 mb-12 flex justify-between items-center text-text-muted">
                        <p>Purchase this product to leave a review.</p>
                        <a href="{{ route('login') }}" class="btn btn-outline text-sm interactive">Login</a>
                    </div>
                @endauth

                <!-- Review List -->
                @if($product->reviews->count() > 0)
                    <div class="space-y-6">
                        @foreach($product->reviews as $review)
                            <div class="bg-surface p-6 rounded-xl border border-gray-800">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-full bg-orange-glow border border-orange flex items-center justify-center text-orange font-bold uppercase overflow-hidden">
                                            @if($review->user->avatar)
                                                <img src="{{ (\Illuminate\Support\Str::startsWith($review->user->avatar, ['http://', 'https://']) ? $review->user->avatar : Storage::url($review->user->avatar)) }}" class="w-full h-full object-cover">
                                            @else
                                                {{ substr($review->user->name, 0, 1) }}
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="font-bold">{{ $review->user->name }}</h4>
                                            <span class="text-xs text-text-muted">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <div class="flex text-[#FFC107]">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="ri-star-{{ $i <= $review->rating ? 'fill' : 'line' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-text-muted leading-relaxed">
                                    {{ $review->comment }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-text-muted italic text-center py-8">No reviews yet. Be the first to review!</p>
                @endif
            </div>

            <!-- Details Content -->
            <div id="content-details" class="hidden animate-fade-in">
                <div class="glass-panel p-8 rounded-2xl grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h4 class="font-heading font-bold text-lg mb-4 text-orange">Product Specifications</h4>
                        <ul class="space-y-4">
                            <li class="flex justify-between border-b border-gray-800 pb-2">
                                <span class="text-text-muted">Category</span>
                                <span class="font-medium">{{ $product->category->name }}</span>
                            </li>
                            <li class="flex justify-between border-b border-gray-800 pb-2">
                                <span class="text-text-muted">SKU</span>
                                <span class="font-medium uppercase">{{ substr(md5($product->id), 0, 8) }}</span>
                            </li>
                            <li class="flex justify-between border-b border-gray-800 pb-2">
                                <span class="text-text-muted">Availability</span>
                                <span class="font-medium {{ $product->stock > 0 ? 'text-green-400' : 'text-red-400' }}">{{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}</span>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-heading font-bold text-lg mb-4 text-orange">Shipping & Returns</h4>
                        <ul class="space-y-4 text-text-muted text-sm">
                            <li class="flex gap-3">
                                <i class="ri-truck-line text-lg text-white"></i>
                                <span>Free standard shipping on orders over $150. Delivery within 3-5 business days.</span>
                            </li>
                            <li class="flex gap-3">
                                <i class="ri-arrow-go-back-line text-lg text-white"></i>
                                <span>Free 30-day returns on all unworn items with original tags attached.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div class="mt-32 border-t border-gray-800 pt-16">
            <h2 class="text-3xl font-heading font-bold mb-10 text-center" data-aos="fade-up">You Might Also Like</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $index => $related)
                    <div data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <x-product-card :product="$related" />
                    </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>

@endsection

@push('styles')
<style>
    /* Hide input number arrows */
    input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
    .animate-fade-in { animation: fadeIn 0.4s ease-out forwards; }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@push('scripts')
<script>
    // Image Gallery functionality
    function changeMainImage(src, btn) {
        // Update main image
        const mainImg = document.getElementById('main-image');
        mainImg.style.opacity = '0';
        setTimeout(() => {
            mainImg.src = src;
            mainImg.style.opacity = '1';
        }, 150);

        // Update active class on thumbnails
        document.querySelectorAll('.thumbnail-btn').forEach(b => {
            b.classList.remove('border-orange', 'opacity-100');
            b.classList.add('border-transparent', 'opacity-60');
        });
        
        btn.classList.remove('border-transparent', 'opacity-60');
        btn.classList.add('border-orange', 'opacity-100');
    }

    // Zoom Lens functionality
    const mainImgNode = document.getElementById('main-image');
    if (mainImgNode) {
        const container = mainImgNode.parentElement;
        const lens = document.getElementById('zoom-lens');

        container.addEventListener('mousemove', function(e) {
            lens.classList.remove('hidden');
            
            const rect = container.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            // Calculate lens position (center cursor)
            let lensX = x - (lens.offsetWidth / 2);
            let lensY = y - (lens.offsetHeight / 2);
            
            // Keep lens within bounds
            if (lensX < 0) lensX = 0;
            if (lensY < 0) lensY = 0;
            if (lensX > rect.width - lens.offsetWidth) lensX = rect.width - lens.offsetWidth;
            if (lensY > rect.height - lens.offsetHeight) lensY = rect.height - lens.offsetHeight;
            
            lens.style.left = lensX + 'px';
            lens.style.top = lensY + 'px';
            
            // Setup background for zoom (using the src of current main image)
            const zoomAmount = 2.5; // Zoom scale factor
            lens.style.backgroundImage = `url('${mainImgNode.src}')`;
            lens.style.backgroundSize = `${rect.width * zoomAmount}px ${rect.height * zoomAmount}px`;
            
            // Calculate background position relative to cursor
            // The percentage of where mouse is inside container
            const pX = x / rect.width;
            const pY = y / rect.height;
            
            // Move background opposite to mouse, scaled.
            const bgX = -(pX * (rect.width * zoomAmount) - (lens.offsetWidth / 2));
            const bgY = -(pY * (rect.height * zoomAmount) - (lens.offsetHeight / 2));
            
            lens.style.backgroundPosition = `${bgX}px ${bgY}px`;
        });

        container.addEventListener('mouseleave', () => {
            lens.classList.add('hidden');
        });
    }

    // Quantity Input Handle
    function updateQty(change) {
        const input = document.getElementById('qty-input');
        let val = parseInt(input.value) + change;
        const max = parseInt(input.getAttribute('max'));
        const min = parseInt(input.getAttribute('min'));
        
        if (val < min) val = min;
        if (val > max) val = max;
        
        input.value = val;
    }

    // Star Rating Interactivity
    const stars = document.querySelectorAll('.star-select');
    const ratingInput = document.getElementById('rating-input');
    
    stars.forEach(star => {
        star.addEventListener('mouseenter', function() {
            const val = parseInt(this.getAttribute('data-val'));
            stars.forEach(s => {
                if (parseInt(s.getAttribute('data-val')) <= val) {
                    s.classList.add('text-[#FFC107]');
                } else {
                    s.classList.remove('text-[#FFC107]');
                }
            });
        });

        star.addEventListener('click', function() {
            const val = parseInt(this.getAttribute('data-val'));
            ratingInput.value = val;
            
            // Lock in the colors
            stars.forEach(s => {
                const sVal = parseInt(s.getAttribute('data-val'));
                if (sVal <= val) {
                    s.classList.add('text-[#FFC107]');
                    s.style.color = '#FFC107'; // Persist selection via inline style
                } else {
                    s.classList.remove('text-[#FFC107]');
                    s.style.color = '';
                }
            });
        });
    });

    document.getElementById('star-rating')?.addEventListener('mouseleave', function() {
        const currentVal = parseInt(ratingInput.value) || 0;
        stars.forEach(s => {
            if (parseInt(s.getAttribute('data-val')) <= currentVal) {
                s.classList.add('text-[#FFC107]');
            } else {
                s.classList.remove('text-[#FFC107]');
            }
        });
    });

    // Custom Add to Cart intercept for the full form
    document.getElementById('add-to-cart-form')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = this.querySelector('button[type="submit"]');
        const originalText = btn.innerHTML;
        
        btn.innerHTML = '<i class="ri-loader-4-line animate-spin text-2xl"></i>';
        btn.disabled = true;

        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());

        try {
            const result = await fetchJson('{{ route("cart.add") }}', {
                method: 'POST',
                body: JSON.stringify(data)
            });
            
            if(result.success) {
                showToast('Added to cart successfully!');
                document.querySelectorAll('.cart-count').forEach(badge => {
                    badge.textContent = result.cart_count;
                    badge.style.transform = 'scale(1.5)';
                    setTimeout(() => badge.style.transform = '', 150);
                });
            }
        } catch(error) {
            // Toast already handled by fetchJson wrapper
        } finally {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    });

    // Tabs
    function switchTab(tab) {
        document.getElementById('content-reviews').classList.add('hidden');
        document.getElementById('content-details').classList.add('hidden');
        
        document.getElementById('tab-reviews').classList.remove('text-orange', 'border-orange');
        document.getElementById('tab-reviews').classList.add('text-text-muted', 'border-transparent');
        
        document.getElementById('tab-details').classList.remove('text-orange', 'border-orange');
        document.getElementById('tab-details').classList.add('text-text-muted', 'border-transparent');

        document.getElementById(`content-${tab}`).classList.remove('hidden');
        document.getElementById(`tab-${tab}`).classList.remove('text-text-muted', 'border-transparent');
        document.getElementById(`tab-${tab}`).classList.add('text-orange', 'border-orange');
    }
</script>
@endpush

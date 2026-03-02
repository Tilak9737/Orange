@props(['product'])

<div class="glass-panel rounded-2xl overflow-hidden group hover:border-orange/40 hover:shadow-[0_20px_40px_rgba(0,0,0,0.4),0_0_20px_rgba(255,107,0,0.1)] transition-all duration-700 relative h-full flex flex-col border border-white/5"
    style="backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);" data-aos="fade-up">

    <!-- Inner Glow Accent -->
    <div
        class="absolute inset-0 bg-gradient-to-tr from-orange/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none">
    </div>

    <!-- Premium Badges -->
    <div class="absolute top-4 left-4 z-10 flex flex-col gap-2">
        @if($product->stock <= 0)
            <span
                class="bg-black/60 backdrop-blur-md text-red-500 text-[9px] uppercase font-black px-3 py-1.5 rounded-full border border-red-500/30 tracking-[0.15em] shadow-lg">
                Sold Out
            </span>
        @elseif($product->featured)
            <span
                class="bg-orange/90 text-white text-[9px] uppercase font-black px-3 py-1.5 rounded-full tracking-[0.15em] shadow-[0_4px_12px_rgba(255,107,0,0.3)]">
                Featured
            </span>
        @endif

        @if($product->sale_price && $product->stock > 0)
            <span
                class="bg-white text-black text-[9px] uppercase font-black px-3 py-1.5 rounded-full tracking-[0.15em] shadow-lg">
                Sale
            </span>
        @endif
    </div>

    <!-- Quick Actions (Premium) -->
    <div
        class="absolute top-4 right-4 z-20 flex flex-col gap-3 translate-x-4 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 transition-all duration-500 delay-75">
        <button
            class="w-10 h-10 rounded-full bg-black/40 backdrop-blur-md border border-white/10 flex items-center justify-center text-white/70 hover:bg-orange hover:border-orange hover:text-white hover:scale-110 transition-all duration-300 interactive add-to-wishlist"
            data-id="{{ $product->id }}">
            <i class="ri-heart-line text-lg"></i>
        </button>
        <button
            class="w-10 h-10 rounded-full bg-black/40 backdrop-blur-md border border-white/10 flex items-center justify-center text-white/70 {{ $product->stock > 0 ? 'hover:bg-orange hover:border-orange hover:text-white hover:scale-110' : 'opacity-30 cursor-not-allowed' }} transition-all duration-300 interactive add-to-cart-quick"
            data-id="{{ $product->id }}" {{ $product->stock <= 0 ? 'disabled' : '' }}>
            <i class="ri-shopping-cart-2-line text-lg"></i>
        </button>
    </div>

    <!-- Image Wrapper -->
    <a href="{{ route('product.show', $product->slug) }}"
        class="block aspect-[4/5] overflow-hidden relative interactive">

        <!-- Stock & Sale Ribbons -->
        @if($product->stock <= 0)
            <div class="ribbon ribbon-red"><span>Sold Out</span></div>
        @elseif($product->stock <= 5)
            <div class="ribbon ribbon-yellow"><span>{{ $product->stock }} Left</span></div>
        @elseif($product->sale_price)
            <div class="ribbon ribbon-green"><span>Sale</span></div>
        @endif

        <!-- Skeleton Overlay -->
        <div class="absolute inset-0 z-0 skeleton" id="skeleton-{{ $product->id }}"></div>

        @if($product->images && count($product->images) > 0)
            <img src="{{ (\Illuminate\Support\Str::startsWith($product->images[0]['path'], ['http://', 'https://']) ? $product->images[0]['path'] : Storage::url($product->images[0]['path'])) }}"
                alt="{{ $product->name }}"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-[1.5s] cubic-bezier(0.16, 1, 0.3, 1) relative z-10"
                onerror="this.onerror=null; this.src='https://placehold.co/400x500/101010/333333?text=Missing+Image'; document.getElementById('skeleton-{{ $product->id }}').style.display = 'none';">
        @else
            <!-- Placeholder -->
            <div class="w-full h-full bg-white/5 flex items-center justify-center group-hover:scale-110 transition-transform duration-[1.5s] relative z-10 text-white/10"
                onload="document.getElementById('skeleton-{{ $product->id }}').style.display = 'none';">
                <i class="ri-image-line text-6xl"></i>
            </div>
            <script>document.getElementById('skeleton-{{ $product->id }}').style.display = 'none';</script>
        @endif

        <!-- Floating Price Tag (Mobile-ish) -->
        <div
            class="absolute bottom-4 left-4 z-20 md:hidden bg-black/60 backdrop-blur-md px-3 py-1.5 rounded-lg border border-white/10">
            <span class="text-white font-bold text-sm">
                ${{ number_format($product->sale_price ?? $product->price, 2) }}
            </span>
        </div>
    </a>

    <!-- Content -->
    <div class="p-6 flex-grow flex flex-col justify-between relative z-10">
        <div>
            <div class="flex justify-between items-center mb-3">
                <div class="flex items-center gap-2">
                    <span
                        class="text-[10px] font-bold text-orange uppercase tracking-[0.15em]">{{ $product->category->name }}</span>
                    @if($product->featured)
                        <span
                            class="bg-orange/20 text-orange text-[8px] uppercase font-black px-2 py-0.5 rounded border border-orange/30 tracking-widest">Featured</span>
                    @endif
                </div>
                <!-- Rating -->
                <div class="flex items-center gap-1.5 bg-white/5 px-2 py-1 rounded-md border border-white/5">
                    <i class="ri-star-fill text-[#FFC107] text-[10px]"></i>
                    <span
                        class="text-[10px] font-bold text-white/80">{{ number_format($product->rating_avg ?? 4.5, 1) }}</span>
                </div>
            </div>

            <a href="{{ route('product.show', $product->slug) }}"
                class="block font-heading font-bold text-lg mb-1 group-hover:text-orange transition-colors line-clamp-2 leading-tight">
                {{ $product->name }}
            </a>
        </div>

        <div class="mt-6 flex items-end justify-between">
            <div class="flex flex-col">
                @if($product->sale_price)
                    <span
                        class="text-[10px] text-white/30 line-through font-bold mb-0.5">${{ number_format($product->price, 2) }}</span>
                    <span class="text-2xl font-black font-heading text-white tracking-tighter">
                        <span
                            class="text-orange text-sm font-bold mr-1">$</span>{{ number_format($product->sale_price, 2) }}
                    </span>
                @else
                    <span class="text-2xl font-black font-heading text-white tracking-tighter">
                        <span class="text-orange text-sm font-bold mr-1">$</span>{{ number_format($product->price, 2) }}
                    </span>
                @endif
            </div>

            <button
                class="group/btn relative w-12 h-12 rounded-xl overflow-hidden transition-all duration-300 {{ $product->stock > 0 ? 'bg-orange/10 text-orange hover:bg-orange hover:text-white' : 'bg-white/5 text-white/20 opacity-50 cursor-not-allowed' }} flex items-center justify-center interactive add-to-cart-quick"
                data-id="{{ $product->id }}" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                <span
                    class="absolute inset-0 bg-orange/20 opacity-0 group-hover/btn:opacity-100 transition-opacity"></span>
                <i class="ri-add-line text-2xl relative z-10"></i>
            </button>
        </div>
    </div>
</div>

<style>
    .aspect-square {
        aspect-ratio: 1 / 1;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .translate-x-12 {
        transform: translateX(3rem);
    }

    .group:hover .group-hover\:-translate-y-2 {
        transform: translateY(-0.5rem);
    }

    .group:hover .group-hover\:translate-x-0 {
        transform: translateX(0);
    }

    .group:hover .group-hover\:opacity-100 {
        opacity: 1;
    }

    .group:hover .group-hover\:scale-110 {
        transform: scale(1.1);
    }

    .duration-300 {
        transition-duration: 300ms;
    }

    .duration-700 {
        transition-duration: 700ms;
    }

    .bg-red-500 {
        background-color: #ef4444;
    }

    .bg-surface-hover {
        background-color: var(--c-surface-hover);
    }

    .text-white {
        color: #ffffff;
    }

    .text-\[10px\] {
        font-size: 10px;
    }

    .text-4xl {
        font-size: 2.25rem;
        line-height: 2.5rem;
    }

    .text-xl {
        font-size: 1.25rem;
        line-height: 1.75rem;
    }

    .text-\[\#FFC107\] {
        color: #FFC107;
    }

    .px-2 {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }

    .py-1 {
        padding-top: 0.25rem;
        padding-bottom: 0.25rem;
    }

    .p-5 {
        padding: 1.25rem;
    }

    .rounded-sm {
        border-radius: 0.125rem;
    }

    .tracking-wider {
        letter-spacing: 0.05em;
    }

    .flex-grow {
        flex-grow: 1;
    }

    .items-start {
        align-items: flex-start;
    }

    .hover\:underline:hover {
        text-decoration: underline;
    }

    .line-through {
        text-decoration: line-through;
    }

    .hover\:shadow-orange:hover {
        box-shadow: var(--shadow-orange);
    }

    /* Ribbon Styles */
    .ribbon {
        position: absolute;
        top: 0;
        left: 0;
        width: 100px;
        height: 100px;
        overflow: hidden;
        z-index: 30;
        pointer-events: none;
    }

    .ribbon span {
        position: absolute;
        display: block;
        width: 150px;
        padding: 10px 0;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.4);
        color: #fff;
        font-size: 10px;
        font-weight: 900;
        text-transform: uppercase;
        text-align: center;
        right: -15px;
        top: 25px;
        transform: rotate(-45deg);
        letter-spacing: 1.5px;
        backdrop-filter: blur(4px);
    }

    .ribbon-red span {
        background: linear-gradient(rgba(239, 68, 68, 0.9), rgba(185, 28, 28, 0.9));
        border-bottom: 2px solid #ef4444;
    }

    .ribbon-yellow span {
        background: linear-gradient(rgba(234, 179, 8, 0.9), rgba(161, 98, 7, 0.9));
        border-bottom: 2px solid #eab308;
        color: #000;
    }

    .ribbon-green span {
        background: linear-gradient(rgba(34, 197, 94, 0.9), rgba(21, 128, 61, 0.9));
        border-bottom: 2px solid #22c55e;
    }
</style>
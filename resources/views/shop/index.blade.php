@extends('layouts.app')

@section('title', 'Orange | Complete Collection')

@section('content')
    <!-- Premium Background Elements -->
    <div class="fixed inset-0 pointer-events-none transition-opacity duration-1000 overflow-hidden" style="z-index: -1;">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-orange/10 blur-[150px] rounded-full animate-blob"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-orange/5 blur-[150px] rounded-full animate-blob animation-delay-4000"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full opacity-[0.03] noise-bg"></div>
    </div>

    <!-- Cinematic Page Header -->
    <div class="relative overflow-hidden pt-32 pb-20 border-b border-white/5">
        <!-- Animated Mesh Gradient Background -->
        <div class="absolute inset-0 z-0">
            <div class="mesh-gradient opacity-20"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl mx-auto text-center" data-aos="fade-down">
                <span class="inline-block px-4 py-1.5 rounded-full bg-orange/10 border border-orange/20 text-orange text-[10px] font-bold tracking-[0.2em] uppercase mb-6">
                    Curated Authority
                </span>
                <h1 class="text-6xl md:text-8xl font-heading font-black mb-8 leading-none tracking-tighter">
                    THE <span class="text-stroke-orange text-transparent">COLLECTION</span>
                </h1>
                <p class="text-text-muted text-lg max-w-2xl mx-auto leading-relaxed">
                    A definitive curation of luxury streetwear. Where heritage precision meets urban rebellion.
                    Filter your heat, define your silhouette.
                </p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-6 py-16">
        <div class="flex flex-col lg:flex-row gap-12">

            <!-- Premium Sidebar Filters -->
            <aside class="w-full lg:w-1/4">
                <div class="glass-panel p-8 rounded-2xl sticky top-32 border-white/5 shadow-2xl overflow-hidden group/sidebar" data-aos="fade-right">
                    <!-- Sidebar Glow -->
                    <div class="absolute -top-24 -right-24 w-48 h-48 bg-orange/5 blur-[60px] rounded-full transition-transform duration-1000 group-hover/sidebar:scale-150"></div>

                    <form action="{{ route('shop') }}" method="GET" id="filter-form" class="relative z-10">
                        <!-- Advanced Search -->
                        <div class="mb-10">
                            <h3 class="text-[10px] font-bold tracking-[0.2em] text-white/40 uppercase mb-4">Search</h3>
                            <div class="relative group/search">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Keywords..." 
                                    class="w-full bg-white/5 border border-white/10 rounded-xl py-4 pl-12 pr-4 text-sm focus:outline-none focus:border-orange/50 focus:bg-white/[0.08] transition-all placeholder:text-white/20">
                                <i class="ri-search-line absolute left-4 top-1/2 -translate-y-1/2 text-white/30 group-focus-within/search:text-orange transition-colors"></i>
                            </div>
                        </div>

                        <!-- Fluid Categories -->
                        <div class="mb-10">
                            <h3 class="text-[10px] font-bold tracking-[0.2em] text-white/40 uppercase mb-6 flex justify-between items-center">
                                Categories
                                <span class="w-12 h-[1px] bg-white/10"></span>
                            </h3>
                            <div class="space-y-2">
                                <label class="cat-pill group {{ !request('category') ? 'active' : '' }}">
                                    <input type="radio" name="category" value="" onchange="this.form.submit()" class="hidden" {{ !request('category') ? 'checked' : '' }}>
                                    <span class="cat-pill-bg"></span>
                                    <span class="relative z-10 flex items-center justify-between">
                                        All Collections
                                        <i class="ri-arrow-right-s-line opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all"></i>
                                    </span>
                                </label>

                                @foreach($categories as $cat)
                                    <label class="cat-pill group {{ request('category') == $cat->slug ? 'active' : '' }}">
                                        <input type="radio" name="category" value="{{ $cat->slug }}"
                                            onchange="this.form.submit()" class="hidden" {{ request('category') == $cat->slug ? 'checked' : '' }}>
                                        <span class="cat-pill-bg"></span>
                                        <span class="relative z-10 flex items-center justify-between">
                                            {{ $cat->name }}
                                            <i class="ri-arrow-right-s-line opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all"></i>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="grid grid-cols-2 gap-4 mt-12">
                            <a href="{{ route('shop') }}" class="btn btn-outline interactive text-sm py-4">Reset</a>
                            <button type="submit" class="btn btn-primary interactive text-sm py-4">Apply</button>
                        </div>
                    </form>
                </div>
            </aside>

            <!-- Refined Product Grid -->
            <div class="w-full lg:w-3/4">
                <!-- Smart Sort Bar -->
                <div class="flex flex-col sm:flex-row justify-between items-center bg-white/5 p-4 rounded-2xl mb-12 gap-4 border border-white/5 backdrop-blur-md"
                    data-aos="fade-in">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-orange animate-pulse"></span>
                        <p class="text-white/50 text-[11px] font-medium tracking-wide">
                            RESULTS: <span class="text-white">{{ $products->total() }}</span> PIECES FOUND
                        </p>
                    </div>

                    <div class="flex items-center gap-6">
                        <form action="{{ route('shop') }}" method="GET" class="flex items-center gap-3">
                            @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                            @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                            
                            <span class="text-[10px] font-bold uppercase tracking-widest text-white/30">Sort:</span>
                            <div class="relative">
                                <select name="sort" onchange="this.form.submit()"
                                    class="bg-transparent border-none text-[11px] font-bold text-white pr-8 focus:ring-0 cursor-pointer appearance-none uppercase tracking-widest">
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price Low</option>
                                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price High</option>
                                </select>
                                <i class="ri-arrow-down-s-line absolute right-0 top-1/2 -translate-y-1/2 pointer-events-none text-orange text-sm"></i>
                            </div>
                        </form>
                    </div>
                </div>

                @if($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8 shop-grid">
                        @foreach($products as $index => $product)
                            <div class="product-item" style="--item-index: {{ $index }}">
                                <x-product-card :product="$product" />
                            </div>
                        @endforeach
                    </div>

                    <!-- Enhanced Pagination -->
                    <div class="mt-20 flex justify-center custom-pagination">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="glass-panel text-center py-32 rounded-3xl" data-aos="zoom-in">
                        <div class="relative w-32 h-32 mx-auto mb-8">
                            <div class="absolute inset-0 bg-orange/20 blur-3xl rounded-full animate-pulse"></div>
                            <div class="relative w-full h-full rounded-full bg-white/5 flex items-center justify-center border border-white/10">
                                <i class="ri-ghost-line text-5xl text-white/20"></i>
                            </div>
                        </div>
                        <h3 class="text-3xl font-heading font-bold mb-3 tracking-tight">SILENCE IN THE ARCHIVE</h3>
                        <p class="text-white/40 max-w-sm mx-auto mb-10 leading-relaxed">We couldn't find any heat matching those parameters. Reach higher or reset the search.</p>
                        <a href="{{ route('shop') }}" class="inline-flex py-4 px-10 rounded-full border border-orange/30 text-orange text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-orange hover:text-white transition-all">Reset All Filters</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Scoped Styles for Shop Page -->
    @push('styles')
    <style>
        .mesh-gradient {
            background-image: 
                radial-gradient(at 0% 0%, hsla(25,100%,50%,0.15) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(40,100%,50%,0.1) 0, transparent 50%),
                radial-gradient(at 50% 100%, hsla(25,100%,50%,0.1) 0, transparent 50%);
            width: 100%;
            height: 100%;
            filter: blur(100px);
            animation: mesh-float 20s ease-in-out infinite alternate;
        }

        @keyframes mesh-float {
            0% { transform: scale(1) translate(0, 0); }
            100% { transform: scale(1.1) translate(2%, 2%); }
        }

        .text-stroke-orange {
            -webkit-text-stroke: 1.5px var(--c-orange);
            text-stroke: 1.5px var(--c-orange);
        }

        .noise-bg {
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3%3Cfilter id='noiseFilter'%3%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3%3C/filter%3%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3%3C/svg%3");
        }

        /* Category Pill Styles */
        .cat-pill {
            display: block;
            position: relative;
            padding: 1rem 1.25rem;
            border-radius: 12px;
            color: rgba(255,255,255,0.4);
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid transparent;
            overflow: hidden;
        }

        .cat-pill-bg {
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(255,107,0,0.1) 0%, transparent 100%);
            opacity: 0;
            transform: translateX(-10%);
            transition: all 0.4s ease;
        }

        .cat-pill:hover {
            color: #fff;
            transform: translateX(5px);
            background: rgba(255,255,255,0.02);
            border-color: rgba(255,255,255,0.05);
        }

        .cat-pill.active {
            color: var(--c-orange);
            background: rgba(255,107,0,0.05);
            border-color: rgba(255,107,0,0.1);
        }

        .cat-pill.active .cat-pill-bg {
            opacity: 1;
            transform: translateX(0);
        }

        /* Sorting Select Hide Background */
        select option {
            background: #111;
            color: #fff;
            padding: 10px;
        }

        /* Grid Item Entrance */
        .product-item {
            opacity: 0;
            transform: translateY(30px);
            animation: shop-item-fade 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            animation-delay: calc(var(--item-index) * 0.08s);
        }

        @keyframes shop-item-fade {
            to { opacity: 1; transform: translateY(0); }
        }

        /* Custom Pagination Fixes */
        .custom-pagination nav {
            display: flex;
            gap: 12px;
        }
        .custom-pagination a, .custom-pagination span[aria-disabled], .custom-pagination span[aria-current] > span {
            width: 50px !important;
            height: 50px !important;
            border-radius: 12px !important;
            border: 1px solid rgba(255,255,255,0.05) !important;
            background: rgba(255,255,255,0.02) !important;
            backdrop-filter: blur(10px);
            font-size: 11px !important;
            font-weight: 800 !important;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .custom-pagination span[aria-current] > span {
            background: var(--c-orange) !important;
            border-color: var(--c-orange) !important;
            color: white !important;
            box-shadow: 0 0 20px rgba(255,107,0,0.3);
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // GSAP 3D Tilt Effect on cards
            const items = document.querySelectorAll('.product-item');
            
            items.forEach(item => {
                const card = item.querySelector('.glass-panel');
                if(!card) return;

                item.addEventListener('mousemove', (e) => {
                    const rect = item.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;
                    
                    const rotateX = (y - centerY) / 20;
                    const rotateY = (centerX - x) / 20;
                    
                    gsap.to(card, {
                        rotateX: rotateX,
                        rotateY: rotateY,
                        duration: 0.5,
                        ease: 'power2.out',
                        transformPerspective: 1000
                    });
                });

                item.addEventListener('mouseleave', () => {
                    gsap.to(card, {
                        rotateX: 0,
                        rotateY: 0,
                        duration: 0.8,
                        ease: 'elastic.out(1, 0.3)'
                    });
                });
            });
        });
    </script>
    @endpush
@endsection

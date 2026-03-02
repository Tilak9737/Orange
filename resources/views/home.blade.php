@extends('layouts.app')

@section('title', 'Orange | Ignite Your Style')

@section('content')
    <!-- Hero Section with Parallax -->
    <section class="relative h-screen flex items-center justify-center overflow-hidden">
        <!-- Parallax Background Elements -->
        <div id="hero-bg" class="absolute inset-0 bg-bg z-0">
            <!-- Abstract Orange Shapes -->
            <div
                class="absolute top-1/4 right-1/4 w-96 h-96 bg-orange rounded-full mix-blend-screen filter blur-[120px] opacity-40 hero-shape">
            </div>
            <div
                class="absolute bottom-1/4 left-1/4 w-[500px] h-[500px] bg-orange-light rounded-full mix-blend-screen filter blur-[150px] opacity-20 hero-shape delay-75">
            </div>
        </div>

        <!-- Floating Particles Container -->
        <div id="particles-js" class="absolute inset-0 z-0 opacity-50"></div>

        <div class="container mx-auto px-6 relative z-10 text-center">
            <h1 class="text-6xl md:text-8xl font-black font-heading tracking-tighter mb-6 relative inline-block">
                <span
                    class="hero-title-word text-transparent bg-clip-text bg-gradient-to-br from-white to-gray-400">IGNITE</span>
                <span
                    class="hero-title-word text-transparent bg-clip-text bg-gradient-to-r from-orange to-orange-light relative">
                    YOUR STYLE
                    <!-- Glow behind the orange text -->
                    <span class="absolute inset-0 bg-orange blur-2xl opacity-40 -z-10 text-orange">YOUR STYLE</span>
                </span>
            </h1>
            <p class="hero-subtitle text-lg md:text-2xl text-text-muted mb-10 max-w-2xl mx-auto font-light">
                Premium collection designed for the bold. Experience the perfect blend of dynamic energy and modern
                aesthetics.
            </p>
            <div class="hero-cta flex flex-col sm:flex-row gap-6 justify-center items-center">
                <a href="{{ route('shop') }}" class="btn btn-primary px-10 py-4 text-lg w-full sm:w-auto">Explore
                    Collection</a>
                <a href="#new-arrivals" class="btn btn-outline px-10 py-4 text-lg w-full sm:w-auto flex items-center gap-2">
                    New Drops <i class="ri-arrow-down-line animate-bounce"></i>
                </a>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div
            class="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-text-muted hero-scroll opacity-0">
            <span class="text-xs uppercase tracking-widest">Scroll</span>
            <div class="w-px h-12 bg-gradient-to-b from-orange to-transparent"></div>
        </div>
    </section>

    <!-- Marquee Brands -->
    <div class="py-8 bg-surface border-y border-gray-800 overflow-hidden relative" data-aos="fade-in">
        <!-- Gradient Masks for seamless scroll -->
        <div class="absolute left-0 top-0 bottom-0 w-24 bg-gradient-to-r from-surface to-transparent z-10"></div>
        <div class="absolute right-0 top-0 bottom-0 w-24 bg-gradient-to-l from-surface to-transparent z-10"></div>

        <div class="flex whitespace-nowrap marquee-container opacity-50">
            <div
                class="marquee-content flex gap-16 items-center px-8 uppercase font-heading font-black text-2xl tracking-widest text-text-muted">
                <span>Supreme</span> <i class="ri-star-s-fill text-orange"></i>
                <span>Off-White</span> <i class="ri-star-s-fill text-orange"></i>
                <span>Balenciaga</span> <i class="ri-star-s-fill text-orange"></i>
                <span>Yeezy</span> <i class="ri-star-s-fill text-orange"></i>
                <span>Fear of God</span> <i class="ri-star-s-fill text-orange"></i>
                <span>Rick Owens</span> <i class="ri-star-s-fill text-orange"></i>
                <!-- Duplicate for infinite scroll -->
                <span>Supreme</span> <i class="ri-star-s-fill text-orange"></i>
                <span>Off-White</span> <i class="ri-star-s-fill text-orange"></i>
                <span>Balenciaga</span> <i class="ri-star-s-fill text-orange"></i>
                <span>Yeezy</span> <i class="ri-star-s-fill text-orange"></i>
                <span>Fear of God</span> <i class="ri-star-s-fill text-orange"></i>
                <span>Rick Owens</span> <i class="ri-star-s-fill text-orange"></i>
            </div>
        </div>
    </div>

    {{-- ══ NEW ARRIVALS — Kinetic Infinite Marquee ══ --}}
    <section id="new-arrivals" class="na-section">

        {{-- Ambient glow --}}
        <div class="na-glow na-glow-left"></div>
        <div class="na-glow na-glow-right"></div>

        {{-- Header --}}
        <div class="na-header container mx-auto px-6" data-aos="fade-up">
            <div>
                <div class="na-eyebrow">
                    <span class="na-eyebrow-dot"></span> Fresh Drops
                </div>
                <h2 class="na-title">New <span class="na-title-accent">Arrivals</span></h2>
            </div>
            <a href="{{ route('shop') }}" class="na-cta-btn">
                View All <i class="ri-arrow-right-up-line"></i>
            </a>
        </div>

        @if($newArrivals->isEmpty())
            {{-- Empty state — no products marked yet --}}
            <div class="na-empty" data-aos="fade-up">
                <div class="na-empty-icon"><i class="ri-fire-line"></i></div>
                <div class="na-empty-title">Something Big is Coming</div>
                <p class="na-empty-sub">Our team is handpicking the hottest new drops. Stay tuned.</p>
                <a href="{{ route('shop') }}" class="na-cta-btn" style="margin-top:24px;">Browse All Products <i
                        class="ri-arrow-right-up-line"></i></a>
            </div>
        @else
            @php
                // Ensure at least 8 cards per half so the marquee always looks full
                $repeatFactor = max(1, (int) ceil(8 / $newArrivals->count()));
                $reversed = $newArrivals->reverse()->values();
            @endphp

            {{-- Marquee row 1 — scrolls left --}}
            <div class="na-track-wrap" id="na-wrap-1">
                <div class="na-track" id="na-track-1">
                    @for($r = 0; $r < $repeatFactor * 2; $r++)
                        @foreach($newArrivals as $product)
                            @include('components.na-card', ['product' => $product])
                        @endforeach
                    @endfor
                </div>
            </div>

            {{-- Marquee row 2 — scrolls right (reversed) --}}
            <div class="na-track-wrap na-track-wrap--reverse" id="na-wrap-2">
                <div class="na-track na-track--rtl" id="na-track-2">
                    @for($r = 0; $r < $repeatFactor * 2; $r++)
                        @foreach($reversed as $product)
                            @include('components.na-card', ['product' => $product])
                        @endforeach
                    @endfor
                </div>
            </div>
        @endif

    </section>

    {{-- ══ SHOP BY CATEGORY — Premium Bento ══ --}}
    <section class="cat-section" id="categories">

        {{-- Ambient top glow --}}
        <div class="cat-bg-glow"></div>

        <div class="container mx-auto px-6 relative z-10">

            {{-- Section header --}}
            <div class="cat-header" data-aos="fade-up">
                <div>
                    <div class="cat-eyebrow"><span class="cat-eyebrow-dot"></span> Curated Collections</div>
                    <h2 class="cat-title">Shop by <span class="cat-title-accent">Category</span></h2>
                </div>
                <a href="{{ route('shop') }}" class="cat-view-all">
                    All Categories <i class="ri-arrow-right-up-line"></i>
                </a>
            </div>

            {{-- Bento grid --}}
            @php
                $catList = $categories->take(3);
                $iconMap = [
                    'outerwear' => 'ri-t-shirt-2-fill',
                    't-shirts' => 'ri-shirt-fill',
                    'accessories' => 'ri-glasses-fill',
                    'hoodies' => 'ri-bear-smile-fill',
                    'shoes' => 'ri-footprint-fill',
                    'bags' => 'ri-handbag-fill',
                ];
            @endphp

            <div class="cat-bento">

                @foreach($catList as $i => $category)
                    @php $catIcon = $iconMap[strtolower($category->slug)] ?? 'ri-price-tag-3-fill'; @endphp

                    <a href="{{ route('shop', ['category' => $category->slug]) }}"
                        class="cat-card {{ $i === 0 ? 'cat-card--hero' : 'cat-card--stack' }}" data-aos="fade-up"
                        data-aos-delay="{{ $i * 120 }}">

                        {{-- Image --}}
                        @if($category->image)
                            <img src="{{ (\Illuminate\Support\Str::startsWith($category->image, ['http://', 'https://']) ? $category->image : Storage::url($category->image)) }}"
                                alt="{{ $category->name }}" class="cat-card-img" loading="lazy">
                        @else
                            <div class="cat-card-img cat-card-img--placeholder">
                                <i class="{{ $catIcon }}"></i>
                            </div>
                        @endif

                        {{-- Gradient overlays --}}
                        <div class="cat-overlay-base"></div>
                        <div class="cat-overlay-hover"></div>

                        {{-- Top-left: category pill --}}
                        <div class="cat-card-pill">
                            <i class="{{ $catIcon }}"></i> {{ $category->name }}
                        </div>

                        {{-- Bottom content --}}
                        <div class="cat-card-bottom">
                            <h3 class="cat-card-name">{{ $category->name }}</h3>
                            <div class="cat-card-cta">
                                <span>Explore Collection</span>
                                <div class="cat-card-arrow"><i class="ri-arrow-right-line"></i></div>
                            </div>
                        </div>

                        {{-- Orange corner glow on hover --}}
                        <div class="cat-corner-glow"></div>
                    </a>
                @endforeach

            </div>
        </div>
    </section>

    {{-- Scoped CSS for category section --}}
    @push('styles')
        <style>
            /* ── Section ─────────────────────────── */
            .cat-section {
                position: relative;
                padding: 100px 0 80px;
                background: var(--c-surface, #0d0d0d);
                overflow: hidden;
            }

            .cat-bg-glow {
                position: absolute;
                top: -200px;
                right: -200px;
                width: 700px;
                height: 700px;
                border-radius: 50%;
                background: radial-gradient(ellipse, rgba(255, 107, 0, 0.1) 0%, transparent 70%);
                pointer-events: none;
            }

            /* ── Header ──────────────────────────── */
            .cat-header {
                display: flex;
                justify-content: space-between;
                align-items: flex-end;
                margin-bottom: 48px;
            }

            .cat-eyebrow {
                display: flex;
                align-items: center;
                gap: 8px;
                font-size: 0.7rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 0.2em;
                color: #FF6B00;
                margin-bottom: 10px;
            }

            .cat-eyebrow-dot {
                width: 6px;
                height: 6px;
                background: #FF6B00;
                border-radius: 50%;
                animation: dot-pulse 1.6s ease-in-out infinite;
            }

            .cat-title {
                font-family: 'Syne', sans-serif;
                font-size: clamp(2rem, 4vw, 3.2rem);
                font-weight: 800;
                color: #fff;
                line-height: 1.05;
            }

            .cat-title-accent {
                -webkit-text-stroke: 2px #FF6B00;
                color: transparent;
            }

            .cat-view-all {
                display: inline-flex;
                align-items: center;
                gap: 7px;
                padding: 10px 22px;
                border: 1px solid rgba(255, 107, 0, 0.35);
                border-radius: 50px;
                color: #FF6B00;
                font-size: 0.8rem;
                font-weight: 700;
                letter-spacing: 0.04em;
                text-decoration: none;
                background: rgba(255, 107, 0, 0.04);
                transition: all 0.3s ease;
            }

            .cat-view-all:hover {
                background: rgba(255, 107, 0, 0.12);
                border-color: #FF6B00;
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(255, 107, 0, 0.2);
            }

            /* ── Bento Grid ──────────────────────── */
            .cat-bento {
                display: grid;
                grid-template-columns: 1.5fr 1fr;
                grid-template-rows: auto;
                gap: 16px;
            }

            @media (max-width: 768px) {
                .cat-bento {
                    grid-template-columns: 1fr;
                }

                .cat-card--hero {
                    grid-row: auto;
                }
            }

            /* ── Cards ───────────────────────────── */
            .cat-card {
                position: relative;
                border-radius: 20px;
                overflow: hidden;
                display: block;
                text-decoration: none;
                cursor: pointer;
                border: 1px solid rgba(255, 255, 255, 0.06);
            }

            .cat-card--hero {
                grid-row: 1 / 3;
                height: 580px;
            }

            .cat-card--stack {
                height: 275px;
            }

            /* Image */
            .cat-card-img {
                position: absolute;
                inset: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.7s cubic-bezier(0.25, 1, 0.5, 1), filter 0.5s ease;
                will-change: transform;
            }

            .cat-card:hover .cat-card-img {
                transform: scale(1.07);
                filter: brightness(0.85);
            }

            .cat-card-img--placeholder {
                background: #1a1a1a;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 4rem;
                color: #333;
            }

            /* Overlays */
            .cat-overlay-base {
                position: absolute;
                inset: 0;
                background: linear-gradient(to top, rgba(0, 0, 0, 0.88) 0%, rgba(0, 0, 0, 0.2) 50%, transparent 100%);
                z-index: 1;
                transition: opacity 0.4s ease;
            }

            .cat-overlay-hover {
                position: absolute;
                inset: 0;
                background: linear-gradient(135deg, rgba(255, 107, 0, 0.12) 0%, transparent 60%);
                z-index: 2;
                opacity: 0;
                transition: opacity 0.4s ease;
            }

            .cat-card:hover .cat-overlay-hover {
                opacity: 1;
            }

            /* Pill top-left */
            .cat-card-pill {
                position: absolute;
                top: 18px;
                left: 18px;
                z-index: 10;
                display: inline-flex;
                align-items: center;
                gap: 6px;
                background: rgba(0, 0, 0, 0.55);
                border: 1px solid rgba(255, 255, 255, 0.12);
                backdrop-filter: blur(10px);
                color: rgba(255, 255, 255, 0.85);
                font-size: 0.72rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.1em;
                padding: 5px 12px;
                border-radius: 50px;
                transition: background 0.3s ease, border-color 0.3s ease, color 0.3s ease;
            }

            .cat-card:hover .cat-card-pill {
                background: rgba(255, 107, 0, 0.2);
                border-color: rgba(255, 107, 0, 0.5);
                color: #FF6B00;
            }

            /* Bottom content */
            .cat-card-bottom {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                padding: 24px;
                z-index: 10;
            }

            .cat-card-name {
                font-family: 'Syne', sans-serif;
                font-size: 1.5rem;
                font-weight: 800;
                color: #fff;
                margin-bottom: 12px;
                transition: color 0.3s ease;
            }

            .cat-card--stack .cat-card-name {
                font-size: 1.25rem;
                margin-bottom: 8px;
            }

            .cat-card:hover .cat-card-name {
                color: #FF6B00;
            }

            .cat-card-cta {
                display: flex;
                align-items: center;
                gap: 12px;
                opacity: 0;
                transform: translateY(10px);
                transition: opacity 0.35s ease, transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            }

            .cat-card:hover .cat-card-cta {
                opacity: 1;
                transform: translateY(0);
            }

            .cat-card-cta span {
                color: rgba(255, 255, 255, 0.8);
                font-size: 0.8125rem;
                font-weight: 600;
            }

            .cat-card-arrow {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                background: #FF6B00;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #fff;
                font-size: 1rem;
                transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            }

            .cat-card:hover .cat-card-arrow {
                transform: rotate(-45deg) scale(1.1);
            }

            /* Corner glow */
            .cat-corner-glow {
                position: absolute;
                bottom: -40px;
                right: -40px;
                width: 150px;
                height: 150px;
                border-radius: 50%;
                background: rgba(255, 107, 0, 0.25);
                filter: blur(40px);
                z-index: 0;
                opacity: 0;
                transition: opacity 0.5s ease;
            }

            .cat-card:hover .cat-corner-glow {
                opacity: 1;
            }
        </style>
    @endpush


    <!-- Featured Products (Bento Grid) -->
    <section class="py-24 relative">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-orange text-sm font-bold tracking-widest uppercase mb-2 block">Hype</span>
                <h2 class="text-4xl md:text-5xl font-heading font-bold">Featured Heat</h2>
            </div>

            @if($featuredProducts->count() >= 4)
                <div class="grid grid-cols-1 md:grid-cols-4 grid-rows-2 gap-6 h-[800px]">
                    <!-- Large Item -->
                    <div class="md:col-span-2 md:row-span-2 relative h-full rounded-xl overflow-hidden group interactive"
                        data-aos="fade-up" data-aos-easing="ease-out-back">
                        <x-product-card :product="$featuredProducts[0]" />
                    </div>

                    <!-- Standard Items -->
                    @for($i = 1; $i < 4; $i++)
                        <div class="md:col-span-{{ $i == 1 ? '2' : '1' }} relative h-full rounded-xl overflow-hidden"
                            data-aos="fade-up" data-aos-delay="{{ $i * 100 }}" data-aos-easing="ease-out-back">
                            <x-product-card :product="$featuredProducts[$i]" />
                        </div>
                    @endfor
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($featuredProducts as $index => $product)
                        <div data-aos="fade-up" data-aos-delay="{{ $index * 100 }}" data-aos-easing="ease-out-back">
                            <x-product-card :product="$product" />
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- CTA / Banner -->
    <section id="about" class="py-24 relative overflow-hidden bg-orange">
        <!-- Dynamic background effect -->
        <div
            class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiMwMDAwMDAiIGZpbGwtb3BhY2l0eT0iMC4wNSI+PHBhdGggZD0iTTM2IDM0djIwaDEydjhoMTR2LTg0SDB2MjhoMzRoNkwzNiAzNHptLTIwaC0yNHYtMjRINTRWMzBoLTVWMmgtMjRWMTZINzVWNDBINlYxNkg0M3YyNEgxbDIwLTIwaC0yNHoiLz48L2c+PC9nPjwvc3ZnPg==')] opacity-20 mix-blend-overlay">
        </div>

        <div class="container mx-auto px-6 relative z-10 text-center" data-aos="zoom-in">
            <h2 class="text-4xl md:text-6xl font-heading font-black text-bg mb-6">JOIN THE MOVEMENT</h2>
            <p class="text-xl text-bg/80 mb-10 max-w-2xl mx-auto font-medium">Create an account to unlock exclusive drops,
                member-only discounts, and faster checkout.</p>
            <a href="{{ route('register') }}"
                class="btn bg-bg text-orange hover:bg-surface hover:text-white px-12 py-5 text-lg shadow-2xl interactive">Get
                Started</a>
        </div>
    </section>

@endsection

@push('styles')
    <style>
        /* Marquee Animation */
        .marquee-container {
            width: 100vw;
            max-width: 100%;
        }

        .marquee-content {
            animation: marquee 20s linear infinite;
            width: max-content;
        }

        @keyframes marquee {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }
    </style>
    <!-- Include Particles.js specifically for the hero background -->
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize Particles
            particlesJS("particles-js", {
                "particles": {
                    "number": { "value": 60, "density": { "enable": true, "value_area": 800 } },
                    "color": { "value": "#FF6B00" },
                    "shape": { "type": "circle" },
                    "opacity": { "value": 0.5, "random": true },
                    "size": { "value": 3, "random": true },
                    "line_linked": { "enable": true, "distance": 150, "color": "#FF6B00", "opacity": 0.2, "width": 1 },
                    "move": { "enable": true, "speed": 1.5, "direction": "none", "random": true, "straight": false, "out_mode": "out", "bounce": false }
                },
                "interactivity": {
                    "detect_on": "canvas",
                    "events": { "onhover": { "enable": true, "mode": "grab" }, "onclick": { "enable": true, "mode": "push" }, "resize": true },
                    "modes": { "grab": { "distance": 140, "line_linked": { "opacity": 1 } }, "push": { "particles_nb": 2 } }
                },
                "retina_detect": true
            });

            // GSAP Animations
            gsap.registerPlugin(ScrollTrigger);

            // Hero Parallax Elements
            const tl = gsap.timeline();

            tl.from(".hero-title-word", {
                y: 100,
                opacity: 0,
                duration: 1,
                stagger: 0.2,
                ease: "power4.out",
                delay: 0.2
            })
                .from(".hero-subtitle", {
                    y: 30,
                    opacity: 0,
                    duration: 1,
                    ease: "power3.out"
                }, "-=0.5")
                .from(".hero-cta", {
                    y: 20,
                    opacity: 0,
                    duration: 0.8,
                    ease: "power3.out"
                }, "-=0.6")
                .to(".hero-scroll", {
                    opacity: 1,
                    y: -10,
                    duration: 1,
                    repeat: -1,
                    yoyo: true,
                    ease: "sine.inOut"
                }, "-=0.5");

            // Parallax scroll effect on hero shapes
            gsap.to(".hero-shape", {
                y: 200,
                ease: "none",
                scrollTrigger: {
                    trigger: "section.h-screen",
                    start: "top top",
                    end: "bottom top",
                    scrub: 1
                }
            });


        });
    </script>

    {{-- ── New Arrivals: Marquee + 3D Tilt ─────────── --}}
    <style>
        /* Section */
        .na-section {
            position: relative;
            padding: 96px 0 80px;
            overflow: hidden;
        }

        /* Ambient glows */
        .na-glow {
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            pointer-events: none;
            filter: blur(110px);
            opacity: 0.12;
        }

        .na-glow-left {
            background: #FF6B00;
            top: -80px;
            left: -120px;
        }

        .na-glow-right {
            background: #FF6B00;
            bottom: -80px;
            right: -120px;
        }

        /* Header */
        .na-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 52px;
        }

        /* Empty state */
        .na-empty {
            text-align: center;
            padding: 60px 24px 80px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .na-empty-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(255, 107, 0, 0.08);
            border: 1px solid rgba(255, 107, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            color: #FF6B00;
            margin-bottom: 20px;
            animation: dot-pulse 2.5s ease-in-out infinite;
        }

        .na-empty-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.6rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 10px;
        }

        .na-empty-sub {
            font-size: 0.9rem;
            color: #777;
            max-width: 360px;
        }

        .na-eyebrow {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: #FF6B00;
            margin-bottom: 10px;
        }

        .na-eyebrow-dot {
            width: 6px;
            height: 6px;
            background: #FF6B00;
            border-radius: 50%;
            animation: dot-pulse 1.6s ease-in-out infinite;
        }

        @keyframes dot-pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.8);
                opacity: 0.5;
            }
        }

        .na-title {
            font-family: 'Syne', sans-serif;
            font-size: clamp(2.2rem, 5vw, 3.8rem);
            font-weight: 800;
            color: #fff;
            line-height: 1;
        }

        .na-title-accent {
            -webkit-text-stroke: 2px #FF6B00;
            color: transparent;
        }

        .na-cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 24px;
            border: 1px solid rgba(255, 107, 0, 0.4);
            border-radius: 50px;
            color: #FF6B00;
            font-size: 0.8125rem;
            font-weight: 700;
            text-decoration: none;
            letter-spacing: 0.04em;
            transition: all 0.3s ease;
            background: rgba(255, 107, 0, 0.04);
        }

        .na-cta-btn:hover {
            background: rgba(255, 107, 0, 0.12);
            border-color: #FF6B00;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 0, 0.2);
        }

        /* Marquee track wrapper */
        .na-track-wrap {
            overflow: hidden;
            cursor: grab;
            -webkit-mask-image: linear-gradient(to right, transparent 0%, black 8%, black 92%, transparent 100%);
            mask-image: linear-gradient(to right, transparent 0%, black 8%, black 92%, transparent 100%);
            margin-bottom: 20px;
        }

        .na-track-wrap:active {
            cursor: grabbing;
        }

        .na-track-wrap--reverse {
            margin-top: 4px;
        }

        /* Marquee track */
        .na-track {
            display: flex;
            gap: 20px;
            width: max-content;
            animation: na-scroll-ltr 28s linear infinite;
            will-change: transform;
        }

        .na-track--rtl {
            animation: na-scroll-rtl 32s linear infinite;
        }

        @keyframes na-scroll-ltr {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        @keyframes na-scroll-rtl {
            0% {
                transform: translateX(-50%);
            }

            100% {
                transform: translateX(0);
            }
        }

        /* Pause on wrap hover */
        .na-track-wrap:hover .na-track {
            animation-play-state: paused;
        }

        /* Individual card */
        .na-card {
            flex-shrink: 0;
            width: 300px;
            perspective: 900px;
        }

        .na-card-link {
            display: block;
            text-decoration: none;
            border-radius: 18px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.07);
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            transform-style: preserve-3d;
            will-change: transform;
            /* 3D tilt applied by JS via style --rotX/--rotY */
            transform: perspective(800px) rotateX(var(--rotX, 0deg)) rotateY(var(--rotY, 0deg));
        }

        .na-card:hover .na-card-link {
            border-color: rgba(255, 107, 0, 0.4);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.4), 0 0 20px rgba(255, 107, 0, 0.12);
        }

        .na-card-img-wrap {
            position: relative;
            height: 360px;
            overflow: hidden;
        }

        .na-card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1);
            display: block;
        }

        .na-card:hover .na-card-img {
            transform: scale(1.08);
        }

        .na-card-img-placeholder {
            width: 100%;
            height: 100%;
            background: #1a1a1a;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
            font-size: 3rem;
        }

        /* Overlay */
        .na-card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 0%, transparent 55%);
            display: flex;
            align-items: flex-end;
            justify-content: center;
            padding-bottom: 16px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .na-card:hover .na-card-overlay {
            opacity: 1;
        }

        .na-card-overlay-text {
            color: #fff;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            background: rgba(255, 107, 0, 0.85);
            padding: 5px 14px;
            border-radius: 50px;
        }

        /* New badge */
        .na-card-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: #FF6B00;
            color: #fff;
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            padding: 3px 10px;
            border-radius: 50px;
        }

        /* Body */
        .na-card-body {
            padding: 14px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .na-card-name {
            font-size: 0.8rem;
            font-weight: 600;
            color: #ccc;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 60%;
            transition: color 0.2s;
        }

        .na-card:hover .na-card-name {
            color: #fff;
        }

        .na-card-price {
            font-family: 'Syne', sans-serif;
            font-size: 0.875rem;
            font-weight: 700;
            color: #FF6B00;
        }
    </style>

    <script>
        // ── 3D card tilt on mousemove ──────────────────
        document.querySelectorAll('.na-card').forEach(card => {
            const link = card.querySelector('.na-card-link');

            card.addEventListener('mousemove', e => {
                const rect = card.getBoundingClientRect();
                const cx = rect.left + rect.width / 2;
                const cy = rect.top + rect.height / 2;
                const dx = (e.clientX - cx) / (rect.width / 2);   // -1..1
                const dy = (e.clientY - cy) / (rect.height / 2);   // -1..1

                const maxTilt = 12; // degrees
                link.style.setProperty('--rotX', `${-dy * maxTilt}deg`);
                link.style.setProperty('--rotY', `${dx * maxTilt}deg`);
                link.style.transform = `perspective(800px) rotateX(${-dy * maxTilt}deg) rotateY(${dx * maxTilt}deg) scale3d(1.04,1.04,1.04)`;
            });

            card.addEventListener('mouseleave', () => {
                link.style.transition = 'transform 0.6s cubic-bezier(0.25,1,0.5,1)';
                link.style.transform = 'perspective(800px) rotateX(0deg) rotateY(0deg) scale3d(1,1,1)';
                setTimeout(() => link.style.transition = '', 600);
            });
        });
    </script>
@endpush
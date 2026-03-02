@extends('layouts.app')

@section('title', 'Orange | Our Story')

@section('content')
    <!-- Hero Section -->
    <section class="relative min-h-[70vh] flex items-center justify-center overflow-hidden pt-20">
        <!-- Animated Background Shapes -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <div
                class="absolute top-1/4 -left-20 w-96 h-96 bg-orange rounded-full mix-blend-screen filter blur-[120px] opacity-20 animate-pulse">
            </div>
            <div
                class="absolute bottom-1/4 -right-20 w-[500px] h-[500px] bg-orange-light rounded-full mix-blend-screen filter blur-[150px] opacity-10 animate-pulse delay-700">
            </div>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <span class="text-orange text-sm font-bold tracking-[0.3em] uppercase mb-4 block" data-aos="fade-up">Our
                    Identity</span>
                <h1 class="text-6xl md:text-8xl font-black font-heading tracking-tighter mb-8" data-aos="fade-up"
                    data-aos-delay="100">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-500">WE ARE</span>
                    <span class="text-orange relative">
                        ORANGE
                        <span class="absolute -bottom-2 left-0 w-full h-2 bg-orange/30 blur-sm"></span>
                    </span>
                </h1>
                <p class="text-xl md:text-2xl text-text-muted leading-relaxed" data-aos="fade-up" data-aos-delay="200">
                    Redefining luxury through vibrant energy and high-end craftsmanship. We don't just follow trends; we
                    ignite them.
                </p>
            </div>
        </div>
    </section>

    <!-- Our Values / Philosophy -->
    <section class="py-24 relative bg-surface">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Box 1 -->
                <div class="about-box group" data-aos="fade-up" data-aos-delay="100">
                    <div
                        class="w-16 h-16 rounded-2xl bg-orange/10 flex items-center justify-center text-orange mb-8 group-hover:scale-110 transition-transform">
                        <i class="ri-flashlight-line text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-heading font-bold mb-4 italic">The Spark</h3>
                    <p class="text-text-muted leading-relaxed">
                        Every piece begins with a spark of rebellion. We challenge the mundane with saturated colors and
                        bold silhouettes designed for those who stand out.
                    </p>
                </div>

                <!-- Box 2 -->
                <div class="about-box group mt-0 md:mt-12" data-aos="fade-up" data-aos-delay="200">
                    <div
                        class="w-16 h-16 rounded-2xl bg-orange/10 flex items-center justify-center text-orange mb-8 group-hover:scale-110 transition-transform">
                        <i class="ri-shield-user-line text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-heading font-bold mb-4 italic">Premium Soul</h3>
                    <p class="text-text-muted leading-relaxed">
                        Our materials are sourced from the finest mills. We believe that true luxury is felt in the weight
                        of the fabric and the precision of the stitch.
                    </p>
                </div>

                <!-- Box 3 -->
                <div class="about-box group mt-0 md:mt-24" data-aos="fade-up" data-aos-delay="300">
                    <div
                        class="w-16 h-16 rounded-2xl bg-orange/10 flex items-center justify-center text-orange mb-8 group-hover:scale-110 transition-transform">
                        <i class="ri-global-line text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-heading font-bold mb-4 italic">Global Heat</h3>
                    <p class="text-text-muted leading-relaxed">
                        Born from urban energy, inspired by global culture. Orange is a movement that transcends borders,
                        uniting a new generation of style icons.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Visual Split Section -->
    <section class="py-24 overflow-hidden">
        <div class="container mx-auto px-6">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="w-full lg:w-1/2 relative" data-aos="fade-right">
                    <!-- Decor Image Stack -->
                    <div
                        class="relative z-10 rounded-2xl overflow-hidden shadow-2xl skew-x-1 hover:skew-x-0 transition-transform duration-700">
                        <img src="https://images.unsplash.com/photo-1552374196-1ab2a1c593e8?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80"
                            alt="Style Session" class="w-full h-[600px] object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-bg via-transparent to-transparent opacity-60">
                        </div>
                    </div>
                    <!-- Absolute Floatings -->
                    <div
                        class="absolute -top-10 -right-10 w-48 h-48 border border-orange/30 rounded-full animate-spin-slow">
                    </div>
                    <div class="absolute -bottom-10 -left-10 glass-panel p-6 rounded-2xl border border-gray-800 z-20"
                        data-aos="zoom-in" data-aos-delay="400">
                        <div class="text-4xl font-heading font-black text-orange mb-1">100%</div>
                        <div class="text-xs uppercase tracking-widest font-bold">Original Design</div>
                    </div>
                </div>

                <div class="w-full lg:w-1/2" data-aos="fade-left">
                    <h2 class="text-4xl md:text-6xl font-heading font-black mb-8 leading-tight">DESIGNED FOR THE <span
                            class="italic text-orange">DARING</span>.</h2>
                    <div class="space-y-6 text-lg text-text-muted">
                        <p>
                            At Orange, we believe your wardrobe should be an extension of your ambition. We don't play it
                            safe. We lean into the saturation, the contrast, and the sharp lines that define modern luxury.
                        </p>
                        <p>
                            Founded in 2024, Orange emerged as a response to the "minimalist" fatigue. We brought back the
                            heat, the glow, and the premium feel that makes you look twice.
                        </p>
                        <div class="pt-6">
                            <a href="{{ route('shop') }}"
                                class="btn btn-primary interactive px-10 py-4 text-lg inline-flex items-center gap-3">
                                Explore The Drop <i class="ri-fire-fill"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-20 relative bg-surface overflow-hidden">
        <!-- Geometric Pattern -->
        <div
            class="absolute inset-0 opacity-5 pointer-events-none bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]">
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div data-aos="fade-up" data-aos-delay="100">
                    <div class="text-5xl md:text-7xl font-heading font-black text-orange mb-2">50k+</div>
                    <div class="text-xs uppercase tracking-widest text-text-muted">Members</div>
                </div>
                <div data-aos="fade-up" data-aos-delay="200">
                    <div class="text-5xl md:text-7xl font-heading font-black text-orange mb-2">12</div>
                    <div class="text-xs uppercase tracking-widest text-text-muted">Collabs</div>
                </div>
                <div data-aos="fade-up" data-aos-delay="300">
                    <div class="text-5xl md:text-7xl font-heading font-black text-orange mb-2">200+</div>
                    <div class="text-xs uppercase tracking-widest text-text-muted">Drops</div>
                </div>
                <div data-aos="fade-up" data-aos-delay="400">
                    <div class="text-5xl md:text-7xl font-heading font-black text-orange mb-2">24/7</div>
                    <div class="text-xs uppercase tracking-widest text-text-muted">Support</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Social Proof / Join -->
    <section class="py-24 text-center relative">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-heading font-bold mb-12" data-aos="fade-up">AS SEEN ON <span
                    class="text-orange underline decoration-orange/30 underline-offset-8">STREET ICONS.</span></h2>

            <div class="flex flex-wrap justify-center gap-8 md:gap-20 opacity-30 grayscale hover:grayscale-0 transition-all duration-700"
                data-aos="fade-up" data-aos-delay="200">
                <i class="ri-vogue-line text-6xl"></i>
                <i class="ri-nike-line text-6xl"></i>
                <i class="ri-adidas-line text-6xl"></i>
                <i class="ri-gucci-line text-6xl"></i>
            </div>
        </div>
    </section>

@endsection

@push('styles')
    <style>
        @keyframes spin-slow {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .animate-spin-slow {
            animation: spin-slow 12s linear infinite;
        }

        .shadow-orange {
            box-shadow: 0 10px 30px -10px rgba(255, 107, 0, 0.5);
        }

        /* Philosophy boxes — orange glass theme */
        .about-box {
            padding: 40px;
            border-radius: 24px;
            border: 1px solid rgba(255, 107, 0, 0.2);
            background: rgba(44, 33, 26, 0.03);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 0 0 0 rgba(255, 107, 0, 0);
            transition: border-color 0.35s ease, box-shadow 0.35s ease, background 0.35s ease, transform 0.35s ease;
        }

        .about-box:hover {
            border-color: rgba(255, 107, 0, 0.55);
            background: rgba(57, 42, 32, 0.06);
            box-shadow: 0 0 28px rgba(255, 106, 0, 0.12), inset 0 1px 0 rgba(255, 255, 255, 0.05);
            transform: translateY(-4px);
        }
    </style>
@endpush
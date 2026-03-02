<header class="fixed w-full z-50 transition-all duration-300 glass-panel" id="main-header">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        <!-- Logo -->
        <a href="{{ route('home') }}"
            class="text-2xl font-bold font-heading text-orange interactive flex items-center gap-2">
            <i class="ri-fire-fill text-orange"></i>
            Orange
        </a>

        <!-- Desktop Nav -->
        <nav id="main-nav" style="
            display: none;
            position: relative;
            align-items: center;
            gap: 4px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 50px;
            padding: 5px;
        ">
            <!-- Glowing pill indicator (slides under hovered/active link) -->
            <span id="nav-indicator" style="
                position: absolute;
                top: 5px; bottom: 5px; left: 5px;
                border-radius: 40px;
                background: rgba(255, 107, 0, 0.15);
                border: 1px solid rgba(255, 107, 0, 0.3);
                box-shadow: 0 0 14px rgba(255, 107, 0, 0.18), inset 0 1px 0 rgba(255,255,255,0.05);
                transition: left 0.38s cubic-bezier(0.34, 1.56, 0.64, 1), width 0.38s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.2s ease;
                opacity: 0;
                pointer-events: none;
                backdrop-filter: blur(8px);
            "></span>

            <a href="{{ route('home') }}"
                class="nav-pill{{ request()->routeIs('home') ? ' nav-pill-active' : '' }}">Home</a>
            <a href="{{ route('shop') }}"
                class="nav-pill{{ request()->routeIs('shop') ? ' nav-pill-active' : '' }}">Shop</a>
            <a href="{{ route('about') }}"
                class="nav-pill{{ request()->routeIs('about') ? ' nav-pill-active' : '' }}">About</a>
            <a href="{{ route('contact') }}"
                class="nav-pill{{ request()->routeIs('contact') ? ' nav-pill-active' : '' }}">Contact</a>
        </nav>

        <!-- Use absolute CSS instead of Tailwind because this project is meant to be hostable without build step and use native CSS -->
        <div class="header-right flex items-center gap-6">
            <!-- Search -->
            <form action="{{ route('shop') }}" method="GET" class="relative group flex items-center">
                <input type="text" name="search" placeholder="Search products..."
                    class="bg-surface border border-gray-800 rounded-full py-1 text-sm focus:outline-none focus:border-orange w-0 px-0 group-hover:w-48 group-hover:px-4 transition-all duration-300 opacity-0 group-hover:opacity-100 absolute right-8">
                <button type="submit"
                    class="text-xl hover:text-orange transition-colors interactive relative z-10 bg-transparent border-none">
                    <i class="ri-search-line"></i>
                </button>
            </form>

            <!-- Cart Badge -->
            <a href="{{ route('cart.index') }}"
                class="relative text-xl hover:text-orange transition-colors interactive">
                <i class="ri-shopping-cart-2-line"></i>
                @auth
                    <span
                        class="absolute -top-2 -right-2 bg-orange text-white text-[10px] font-bold h-4 w-4 rounded-full flex items-center justify-center cart-count">
                        {{ \App\Models\Cart::where('user_id', Auth::id())->first()?->items()->sum('quantity') ?? 0 }}
                    </span>
                @else
                    <span
                        class="absolute -top-2 -right-2 bg-orange text-white text-[10px] font-bold h-4 w-4 rounded-full flex items-center justify-center cart-count">
                        {{ \App\Models\Cart::where('session_id', Session::getId())->first()?->items()->sum('quantity') ?? 0 }}
                    </span>
                @endauth
            </a>

            <!-- User/Auth -->
            @auth
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false"
                        class="flex items-center gap-2 text-sm font-medium hover:text-orange transition-colors interactive focus:outline-none">
                        @if(Auth::user()->avatar)
                            <img src="{{ (\Illuminate\Support\Str::startsWith(Auth::user()->avatar, ['http://', 'https://']) ? Auth::user()->avatar : Storage::url(Auth::user()->avatar)) }}"
                                alt="Avatar"
                                class="w-8 h-8 rounded-lg object-cover border border-orange/30 shadow-sm group-hover:border-orange transition-all">
                        @else
                            <div
                                class="w-8 h-8 rounded-lg bg-orange-glow flex items-center justify-center text-orange border border-orange/30 group-hover:border-orange transition-all font-bold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        @endif
                        <i class="ri-arrow-down-s-line transition-transform duration-300"
                            :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    <!-- Dropdown -->
                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                        class="absolute right-0 mt-3 w-56 crystalline-dropdown z-50 overflow-hidden" style="display: none;">

                        <div class="px-4 py-3 border-b border-white/5 bg-white/5">
                            <p class="text-[10px] text-text-muted uppercase tracking-widest mb-1 font-bold">Signed in as</p>
                            <p class="text-xs font-bold text-white truncate">{{ Auth::user()->email }}</p>
                        </div>

                        <div class="py-2">
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="dropdown-item-premium">
                                    <i class="ri-dashboard-fill"></i> Management
                                </a>
                            @endif
                            <a href="{{ route('profile.edit') }}" class="dropdown-item-premium">
                                <i class="ri-user-settings-fill"></i> Profile settings
                            </a>
                            <a href="{{ route('orders.index') }}" class="dropdown-item-premium">
                                <i class="ri-file-list-3-fill"></i> Order History
                            </a>
                            <a href="{{ route('wishlist.index') }}" class="dropdown-item-premium">
                                <i class="ri-heart-fill"></i> Your Wishlist
                            </a>
                        </div>

                        <div class="dropdown-divider"></div>

                        <div class="pb-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full dropdown-item-premium logout">
                                    <i class="ri-logout-box-r-fill"></i> Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline text-sm py-2 px-4 interactive">Login</a>
            @endauth
        </div>
    </div>
</header>

<style>
    /* Nav pills — premium pill-style nav */
    #main-nav {
        display: none;
        /* shown via JS on md+ */
        position: relative;
        align-items: center;
        gap: 4px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.07);
        border-radius: 50px;
        padding: 5px;
    }

    @media (min-width: 768px) {
        #main-nav {
            display: flex !important;
        }
    }

    .nav-pill {
        position: relative;
        z-index: 1;
        display: inline-block;
        padding: 7px 18px;
        font-size: 0.8125rem;
        font-weight: 500;
        color: #888;
        text-decoration: none;
        border-radius: 40px;
        transition: color 0.22s ease;
        white-space: nowrap;
        letter-spacing: 0.01em;
    }

    .nav-pill:hover {
        color: #fff;
    }

    .nav-pill-active {
        color: #FF6B00 !important;
        font-weight: 600;
    }

    /* Crystalline dropdown — must come after Tailwind CDN to win */
    .crystalline-dropdown {
        background: rgba(12, 12, 12, 0.97) !important;
        backdrop-filter: blur(28px);
        -webkit-backdrop-filter: blur(28px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 14px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.65), inset 0 1px 0 rgba(255, 255, 255, 0.05);
        padding: 6px;
        overflow: hidden;
    }

    .crystalline-dropdown a,
    .crystalline-dropdown button {
        display: flex !important;
        align-items: center;
        gap: 10px;
        padding: 9px 14px;
        font-size: 0.8125rem;
        font-weight: 500;
        color: #A1A1AA;
        text-decoration: none;
        background: transparent;
        border: none;
        cursor: pointer;
        text-align: left;
        width: 100%;
        border-radius: 8px;
        margin: 1px 0;
        transition: background 0.18s ease, color 0.18s ease, transform 0.18s ease;
        font-family: 'Outfit', sans-serif;
        line-height: 1.4;
        box-sizing: border-box;
    }

    .crystalline-dropdown a i,
    .crystalline-dropdown button i {
        font-size: 1rem;
        width: 16px;
        text-align: center;
        flex-shrink: 0;
    }

    .crystalline-dropdown a:hover,
    .crystalline-dropdown button:hover {
        background: rgba(255, 107, 0, 0.1) !important;
        color: #FF6B00 !important;
        transform: translateX(3px);
    }

    .crystalline-dropdown button.logout:hover {
        background: rgba(239, 68, 68, 0.1) !important;
        color: #ef4444 !important;
    }

    .dropdown-divider {
        height: 1px;
        background: rgba(255, 255, 255, 0.06);
        margin: 4px 10px;
    }
</style>

<script>
    // ── Three-Stage Morphing Navbar ────────────────────────
    (function () {
        const header = document.getElementById('main-header');
        const logo = header.querySelector('a[href*="home"]');

        let lastY = 0;
        let state = 'full'; // 'full', 'capsule', 'mini'
        let hovered = false;
        let collapseTimer = null;

        /* ── Inject Refined Three-Stage CSS ── */
        const s = document.createElement('style');
        s.textContent = `
            #main-header {
                transition:
                    top           0.6s cubic-bezier(0.16, 1, 0.3, 1),
                    left          0.6s cubic-bezier(0.16, 1, 0.3, 1),
                    width         0.6s cubic-bezier(0.16, 1, 0.3, 1),
                    max-width     0.6s cubic-bezier(0.16, 1, 0.3, 1),
                    border-radius 0.6s cubic-bezier(0.16, 1, 0.3, 1),
                    padding       0.45s cubic-bezier(0.16, 1, 0.3, 1),
                    background    0.35s ease,
                    border-color  0.35s ease,
                    transform     0.6s cubic-bezier(0.16, 1, 0.3, 1),
                    box-shadow    0.45s ease;
                will-change: width, left, top, transform, border-radius;
            }

            /* ── STATE 1: Full ── */
            #main-header.nav-full {
                top: 0 !important;
                left: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                transform: none !important;
                border-radius: 0 !important;
                padding: 14px 0 !important;
                background: rgba(6, 6, 6, 0.88) !important;
                border-bottom: 1px solid rgba(255,107,0,0.1) !important;
                box-shadow: 0 4px 30px rgba(0,0,0,0.4) !important;
                backdrop-filter: blur(24px) !important;
                -webkit-backdrop-filter: blur(24px) !important;
            }

            /* ── STATE 2: Centered Capsule ── */
            #main-header.nav-capsule {
                top: 16px !important;
                left: 50% !important;
                transform: translateX(-50%) !important;
                width: max-content !important;
                max-width: 520px !important;
                min-width: 320px !important;
                border-radius: 999px !important;
                padding: 10px 10px !important; /* Balanced padding for inner elements */
                background: rgba(10,10,10,0.94) !important;
                border: 1px solid rgba(255,107,0,0.28) !important;
                box-shadow: 0 10px 40px rgba(0,0,0,0.6), 0 0 20px rgba(255,107,0,0.1) !important;
                backdrop-filter: blur(30px) !important;
                -webkit-backdrop-filter: blur(30px) !important;
            }

            /* ── STATE 3: Left Mini-Pill (Logo only) ── */
            #main-header.nav-mini {
                top: 16px !important;
                left: 32px !important;
                transform: none !important;
                width: 60px !important;
                height: 60px !important;
                padding: 0 !important;
                border-radius: 50% !important;
                background: rgba(10,10,10,0.96) !important;
                border: 2px solid #FF6B00 !important;
                box-shadow: 0 10px 40px rgba(0,0,0,0.6), 0 0 25px rgba(255,107,0,0.25) !important;
                display: flex !important;
                align-items: center;
                justify-content: center;
                backdrop-filter: blur(30px) !important;
                -webkit-backdrop-filter: blur(30px) !important;
            }

            /* Visibility Logic per State */
            #main-header.nav-mini #main-nav,
            #main-header.nav-mini .header-right {
                opacity: 0 !important;
                pointer-events: none !important;
                max-width: 0 !important;
                margin: 0 !important;
                overflow: hidden;
                visibility: hidden;
            }

            #main-header.nav-capsule #logo-link,
            #main-header.nav-capsule .header-right {
                opacity: 0 !important;
                pointer-events: none !important;
                max-width: 0 !important;
                margin: 0 !important;
                overflow: hidden;
                visibility: hidden;
            }

            /* Logo sizing in mini state */
            #main-header.nav-mini #logo-link {
                margin: 0 !important;
                padding: 0 !important;
                font-size: 0 !important; 
                display: flex !important;
                justify-content: center;
                align-items: center;
            }
            #main-header.nav-mini #logo-link i {
                font-size: 1.8rem !important;
                margin: 0 !important;
            }

            /* Animations */
            @keyframes mini-glow {
                0%, 100% { box-shadow: 0 10px 40px rgba(0,0,0,0.6), 0 0 15px rgba(255,107,0,0.2); }
                50%       { box-shadow: 0 10px 40px rgba(0,0,0,0.6), 0 0 35px rgba(255,107,0,0.45); }
            }
            #main-header.nav-mini { animation: mini-glow 3.5s ease-in-out infinite; }

            /* Grid transition */
            #main-header .container {
                transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
                max-width: 100% !important; /* Ensure capsule doesn't stretch to max-width */
            }

            #main-header.nav-capsule .container {
                justify-content: center !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            
            #main-header.nav-full .container {
                justify-content: space-between !important;
                padding-left: 2rem !important;
                padding-right: 2rem !important;
            }

            /* Transitions for nested elements */
            #logo-link, #main-nav, .header-right {
                transition: opacity 0.3s ease, max-width 0.5s ease, margin 0.5s ease, visibility 0.3s ease;
            }
        `;
        document.head.appendChild(s);

        if (logo) logo.id = 'logo-link';

        function updateState(newState) {
            if (state === newState) return;
            header.classList.remove('nav-full', 'nav-capsule', 'nav-mini');
            header.classList.add(`nav-${newState}`);
            state = newState;
        }

        window.addEventListener('scroll', () => {
            const y = window.scrollY;
            const scrollDiff = Math.abs(y - lastY);
            const goingDown = y > lastY;

            // Minimal jitter protection
            if (scrollDiff < 5 && y > 10) return;

            lastY = y;

            if (hovered) return;

            if (y < 80) {
                updateState('full');
            } else if (!goingDown) {
                // Expanded on SCROLL UP for accessibility (premium pattern)
                updateState('full');
            } else if (y >= 400) {
                updateState('mini');
            } else if (y >= 100) {
                updateState('capsule');
            }
        }, { passive: true });

        header.addEventListener('mouseenter', () => {
            hovered = true;
            updateState('full');
        });

        header.addEventListener('mouseleave', () => {
            hovered = false;
            const y = window.scrollY;
            if (y >= 400) updateState('mini');
            else if (y >= 100) updateState('capsule');
            else updateState('full');
        });
    })();

    // ── Premium Magic Pill Indicator ─────────────────
    (function () {
        const nav = document.getElementById('main-nav');
        const indicator = document.getElementById('nav-indicator');
        if (!nav || !indicator) return;

        const links = Array.from(nav.querySelectorAll('a.nav-pill'));
        const activeLink = nav.querySelector('a.nav-pill-active') || links[0];

        function moveTo(el, animate) {
            if (!animate) {
                indicator.style.transition = 'none';
            } else {
                indicator.style.transition = 'left 0.38s cubic-bezier(0.34,1.56,0.64,1), width 0.38s cubic-bezier(0.34,1.56,0.64,1), opacity 0.25s ease, box-shadow 0.25s ease';
            }

            indicator.style.left = el.offsetLeft + 'px';
            indicator.style.width = el.offsetWidth + 'px';
            indicator.style.opacity = '1';
        }

        // Snap to active on load (no animation)
        if (activeLink) {
            requestAnimationFrame(() => {
                moveTo(activeLink, false);
                // re-enable animation next frame
                requestAnimationFrame(() => {
                    indicator.style.transition = 'left 0.38s cubic-bezier(0.34,1.56,0.64,1), width 0.38s cubic-bezier(0.34,1.56,0.64,1), opacity 0.25s ease, box-shadow 0.25s ease';
                });
            });
        }

        // Hover: slide pill to hovered link
        links.forEach(link => {
            link.addEventListener('mouseenter', () => {
                // Boost glow on active vs normal hover
                const isActive = link.classList.contains('nav-pill-active');
                indicator.style.background = isActive
                    ? 'rgba(255, 107, 0, 0.2)'
                    : 'rgba(255, 107, 0, 0.1)';
                indicator.style.boxShadow = isActive
                    ? '0 0 20px rgba(255, 107, 0, 0.35), inset 0 1px 0 rgba(255,255,255,0.08)'
                    : '0 0 10px rgba(255, 107, 0, 0.15), inset 0 1px 0 rgba(255,255,255,0.04)';
                indicator.style.borderColor = 'rgba(255, 107, 0, 0.4)';
                moveTo(link, true);
            });
        });

        // Mouse leave nav: snap back to active link
        nav.addEventListener('mouseleave', () => {
            if (activeLink) {
                indicator.style.background = 'rgba(255, 107, 0, 0.15)';
                indicator.style.boxShadow = '0 0 14px rgba(255, 107, 0, 0.18), inset 0 1px 0 rgba(255,255,255,0.05)';
                indicator.style.borderColor = 'rgba(255, 107, 0, 0.3)';
                moveTo(activeLink, true);
            } else {
                indicator.style.opacity = '0';
            }
        });
    })();
</script>
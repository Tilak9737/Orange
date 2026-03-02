<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Orange Admin | @yield('title', 'Dashboard')</title>

    <!-- Global CSS System (Reused for consistent branding) -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        orange: 'var(--c-orange)',
                        'orange-light': 'var(--c-orange-light)',
                        'orange-glow': 'var(--c-orange-glow)',
                        bg: 'var(--c-bg)',
                        surface: 'var(--c-surface)',
                        'surface-hover': 'var(--c-surface-hover)',
                        'text-muted': 'var(--c-text-muted)',
                    },
                    fontFamily: {
                        heading: ['Syne', 'sans-serif'],
                        body: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <!-- AOS Animations -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Outfit:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* ── Admin Layout Fix ─────────────────────── */
        body.admin-body {
            background: #050505 !important;
        }

        /* Sidebar — override Tailwind 'fixed' duplication cleanly */
        .admin-sidebar {
            position: fixed !important;
            top: 0;
            left: 0;
            width: 280px;
            height: 100vh;
            background: #141414;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            flex-direction: column;
            z-index: 50;
            overflow-y: auto;
        }

        /* Main area — sits to the right of the sidebar */
        .admin-main {
            margin-left: 280px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Topbar — sticky inside the main column */
        .admin-topbar {
            height: 68px;
            background: rgba(18, 18, 18, 0.96);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 40;
            flex-shrink: 0;
        }

        /* Sidebar user avatar */
        .avatar-crystalline {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(255, 107, 0, 0.12);
            border: 1px solid rgba(255, 107, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.875rem;
            color: #FF6B00;
            transition: all 0.3s ease;
            cursor: pointer;
            flex-shrink: 0;
        }

        .avatar-crystalline:hover {
            transform: scale(1.06);
            border-color: #FF6B00;
            box-shadow: 0 0 14px rgba(255, 107, 0, 0.2);
        }

        /* Nav items */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: 8px;
            color: #888;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
            border-left: 2px solid transparent;
            margin-bottom: 2px;
        }

        .nav-item:hover {
            background: #1a1a1a;
            color: #fff;
            border-left-color: rgba(255, 107, 0, 0.4);
        }

        .nav-item.active {
            background: linear-gradient(90deg, rgba(255, 107, 0, 0.12), transparent);
            color: #FF6B00;
            border-left-color: #FF6B00;
            font-weight: 600;
        }

        /* Mobile overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 45;
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(4px);
        }

        .sidebar-open .sidebar-overlay {
            display: block;
        }

        @media (max-width: 1024px) {
            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .admin-main {
                margin-left: 0;
            }

            .sidebar-open .admin-sidebar {
                transform: translateX(0);
            }
        }

        /* ── Topbar Dropdown ──────────────────────── */
        .crystalline-dropdown {
            background: rgba(12, 12, 12, 0.97);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6), inset 0 1px 0 rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            overflow: hidden;
        }

        .dropdown-item-premium {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 9px 14px;
            font-size: 0.8125rem;
            font-weight: 500;
            color: #A1A1AA;
            text-decoration: none;
            background: transparent;
            border: none;
            cursor: pointer;
            text-align: left;
            transition: background 0.18s ease, color 0.18s ease, transform 0.18s ease;
            border-radius: 8px;
            margin: 1px 4px;
            width: calc(100% - 8px);
        }

        .dropdown-item-premium i {
            font-size: 1rem;
            width: 18px;
            text-align: center;
            flex-shrink: 0;
        }

        .dropdown-item-premium:hover {
            background: rgba(255, 107, 0, 0.1);
            color: #FF6B00;
            transform: translateX(3px);
        }

        .dropdown-item-premium.logout:hover {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .dropdown-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.06);
            margin: 4px 10px;
        }
    </style>

    @stack('styles')
</head>

<body class="antialiased admin-body">

    <!-- Mobile Sidebar Overlay -->
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside class="admin-sidebar fixed top-0 left-0 h-full bg-surface border-r border-gray-800 flex flex-col">
        <!-- Logo -->
        <div class="h-20 flex items-center px-8 border-b border-gray-800">
            <a href="{{ route('admin.dashboard') }}"
                class="text-2xl font-bold font-heading text-orange flex items-center gap-2">
                <i class="ri-fire-fill text-orange"></i> Orange
            </a>
            <span
                class="ml-2 px-2 py-0.5 rounded text-[10px] font-bold bg-gray-800 text-text-muted uppercase tracking-widest">Admin</span>
        </div>

        <!-- Navigation -->
        <div class="flex-grow py-6 px-4 overflow-y-auto custom-scrollbar">
            <div class="space-y-1 mb-8">
                <div class="text-xs font-bold text-gray-500 uppercase tracking-widest px-4 mb-3">Overview</div>

                <a href="{{ route('admin.dashboard') }}"
                    class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="ri-dashboard-3-line text-lg"></i> Dashboard
                </a>
                <a href="{{ route('home') }}" target="_blank" class="nav-item">
                    <i class="ri-store-2-line text-lg"></i> View Store <i
                        class="ri-external-link-line ml-auto text-sm"></i>
                </a>
            </div>

            <div class="space-y-1">
                <div class="text-xs font-bold text-gray-500 uppercase tracking-widest px-4 mb-3">Management</div>

                <a href="{{ route('admin.orders.index') }}"
                    class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="ri-shopping-bag-3-line text-lg"></i> Orders
                    <!-- Demo Badge -->
                    <span class="ml-auto bg-orange text-white text-[10px] px-2 py-0.5 rounded-full font-bold">New</span>
                </a>
                <a href="{{ route('admin.products.index') }}"
                    class="nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="ri-price-tag-3-line text-lg"></i> Products
                </a>
                <a href="{{ route('admin.categories.index') }}"
                    class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="ri-layout-grid-fill text-lg"></i> Categories
                </a>
                <a href="{{ route('admin.coupons.index') }}"
                    class="nav-item {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                    <i class="ri-coupon-2-line text-lg"></i> Coupons
                </a>
                <a href="{{ route('admin.wishlists.index') }}"
                    class="nav-item {{ request()->routeIs('admin.wishlists.*') ? 'active' : '' }}">
                    <i class="ri-heart-3-line text-lg"></i> Wishlists
                </a>
            </div>
        </div>

        <!-- User Sidebar Info (Static) -->
        <div class="p-6 border-t border-gray-800 bg-surface/50">
            <div class="flex items-center gap-3">
                <div
                    class="w-10 h-10 rounded-xl bg-orange-glow text-orange flex items-center justify-center font-bold border border-orange/20">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="flex-grow overflow-hidden">
                    <div class="text-sm font-bold truncate text-white">{{ Auth::user()->name }}</div>
                    <div class="text-[10px] text-orange uppercase tracking-widest font-black">Administrator</div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="admin-main">
        <!-- Topbar -->
        <header class="admin-topbar">
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar()"
                    class="lg:hidden text-2xl text-text-muted hover:text-orange transition-colors">
                    <i class="ri-menu-line"></i>
                </button>
                <h1 class="text-xl font-heading font-bold text-white">@yield('title')</h1>
            </div>

            <div class="flex items-center gap-5">
                <!-- Notifications -->
                <div class="relative cursor-pointer group" onclick="showToast('No new notifications yet', 'info')">
                    <i
                        class="ri-notification-3-line text-xl text-text-muted group-hover:text-orange transition-colors duration-200"></i>
                    <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                </div>

                <!-- Divider -->
                <div class="w-px h-6 bg-gray-700"></div>

                <!-- Profile Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false"
                        class="flex items-center gap-3 group focus:outline-none">
                        <div class="avatar-crystalline">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="hidden md:block text-left">
                            <div
                                class="text-sm font-bold text-white group-hover:text-orange transition-colors leading-tight">
                                {{ Auth::user()->name }}
                            </div>
                            <div class="text-[10px] text-text-muted uppercase tracking-widest">Administrator</div>
                        </div>
                        <i class="ri-arrow-down-s-line text-text-muted group-hover:text-orange transition-all duration-300 text-lg"
                            :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                        class="absolute right-0 mt-3 w-56 crystalline-dropdown z-50 overflow-hidden"
                        style="display: none;">

                        <!-- Signed-in label -->
                        <div class="px-4 py-3 border-b border-white/5 bg-white/5">
                            <p class="text-[10px] text-text-muted uppercase tracking-widest mb-1 font-bold">Signed in as
                            </p>
                            <p class="text-xs font-bold text-white truncate">{{ Auth::user()->email }}</p>
                        </div>

                        <!-- Menu items -->
                        <div class="py-2">
                            <a href="{{ route('home') }}" target="_blank" class="dropdown-item-premium">
                                <i class="ri-store-2-fill"></i> Visit Store
                            </a>
                            <a href="{{ route('profile.edit') }}" class="dropdown-item-premium">
                                <i class="ri-user-settings-fill"></i> Profile Settings
                            </a>
                        </div>

                        <div class="dropdown-divider"></div>

                        <!-- Logout -->
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
            </div>
        </header>

        <!-- Dynamic Content -->
        <div class="flex-grow p-6 md:p-8">
            <!-- Toast Container -->
            @include('components.toast')

            @yield('content')
        </div>
    </main>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Init AOS
        AOS.init({ duration: 700, easing: 'ease-out-cubic', once: true });

        function toggleSidebar() {
            document.body.classList.toggle('sidebar-open');
        }

        // File upload preview helper
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const preview = document.getElementById(previewId);
                    preview.src = e.target.result;
                    preview.parentElement.classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    @stack('scripts')
</body>

</html>
@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="space-y-6">

        <!-- Welcome Header -->
        <div class="flex justify-between items-end bg-surface p-6 rounded-2xl border border-gray-800" data-aos="fade-down">
            <div>
                <h2 class="text-2xl font-heading font-bold mb-1">Welcome back, {{ explode(' ', Auth::user()->name)[0] }}!
                </h2>
                <p class="text-text-muted text-sm">Here's what's happening with your store today.</p>
            </div>
            <div class="text-right">
                <span class="text-xs text-text-muted uppercase tracking-widest font-bold">Today</span>
                <div class="text-lg font-bold text-orange">{{ now()->format('M d, Y') }}</div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">

            <!-- Total Revenue -->
            <div class="crystalline-card p-6 rounded-[2rem] group cursor-default glow-orange-crystalline h-full flex flex-col justify-between"
                data-aos="fade-up" data-aos-delay="0">
                <div class="grain-overlay"></div>
                <div class="corner-accent top-left"></div>
                <div class="corner-accent bottom-right"></div>
                <div class="flex justify-between items-start mb-6 relative z-10">
                    <div
                        class="w-14 h-14 rounded-2xl bg-orange-glow text-orange flex items-center justify-center text-2xl group-hover:scale-110 group-hover:rotate-[15deg] transition-all duration-700">
                        <i class="ri-money-dollar-circle-fill"></i>
                    </div>
                    <div class="text-right">
                        <span class="text-[9px] font-black tracking-widest text-emerald-400 bg-emerald-400/10 px-2.5 py-1 rounded-lg border border-emerald-400/20 shadow-sm">+12.5%</span>
                    </div>
                </div>
                <div class="relative z-10">
                    <p class="text-[10px] text-text-muted font-black uppercase tracking-[0.2em] mb-2 opacity-50 group-hover:opacity-100 group-hover:text-orange transition-all duration-500">Total Revenue</p>
                    <h3 class="text-3xl font-heading font-black text-white group-hover:tracking-wider transition-all duration-500 leading-none">${{ number_format($totalRevenue, 2) }}</h3>
                </div>
            </div>

            <!-- Total Orders -->
            <div class="crystalline-card p-6 rounded-[2rem] group cursor-default glow-blue-crystalline h-full flex flex-col justify-between"
                data-aos="fade-up" data-aos-delay="100">
                <div class="grain-overlay"></div>
                <div class="corner-accent top-left"></div>
                <div class="corner-accent bottom-right"></div>
                <div class="flex justify-between items-start mb-6 relative z-10">
                    <div
                        class="w-14 h-14 rounded-2xl bg-blue-500/10 text-blue-500 flex items-center justify-center text-2xl group-hover:scale-110 group-hover:rotate-[15deg] transition-all duration-700">
                        <i class="ri-shopping-bag-3-fill"></i>
                    </div>
                    <div class="text-right">
                        <span class="text-[9px] font-black tracking-widest text-emerald-400 bg-emerald-400/10 px-2.5 py-1 rounded-lg border border-emerald-400/20 shadow-sm">+4.2%</span>
                    </div>
                </div>
                <div class="relative z-10">
                    <p class="text-[10px] text-text-muted font-black uppercase tracking-[0.2em] mb-2 opacity-50 group-hover:opacity-100 group-hover:text-blue-500 transition-all duration-500">Total Orders</p>
                    <h3 class="text-3xl font-heading font-black text-white group-hover:tracking-wider transition-all duration-500 leading-none">{{ number_format($totalOrders) }}</h3>
                </div>
            </div>

            <!-- Total Users -->
            <div class="crystalline-card p-6 rounded-[2rem] group cursor-default glow-purple-crystalline h-full flex flex-col justify-between"
                data-aos="fade-up" data-aos-delay="200">
                <div class="grain-overlay"></div>
                <div class="corner-accent top-left"></div>
                <div class="corner-accent bottom-right"></div>
                <div class="flex justify-between items-start mb-6 relative z-10">
                    <div
                        class="w-14 h-14 rounded-2xl bg-purple-500/10 text-purple-400 flex items-center justify-center text-2xl group-hover:scale-110 group-hover:rotate-[15deg] transition-all duration-700">
                        <i class="ri-user-smile-fill"></i>
                    </div>
                    <div class="text-right">
                        <span class="text-[9px] font-black tracking-widest text-red-400 bg-red-400/10 px-2.5 py-1 rounded-lg border border-red-400/20 shadow-sm">-1.5%</span>
                    </div>
                </div>
                <div class="relative z-10">
                    <p class="text-[10px] text-text-muted font-black uppercase tracking-[0.2em] mb-2 opacity-50 group-hover:opacity-100 group-hover:text-purple-400 transition-all duration-500">Active Customers</p>
                    <h3 class="text-3xl font-heading font-black text-white group-hover:tracking-wider transition-all duration-500 leading-none">{{ number_format($totalUsers) }}</h3>
                </div>
            </div>

            <!-- Total Products -->
            <div class="crystalline-card p-6 rounded-[2rem] group cursor-default glow-pink-crystalline h-full flex flex-col justify-between"
                data-aos="fade-up" data-aos-delay="300">
                <div class="grain-overlay"></div>
                <div class="corner-accent top-left"></div>
                <div class="corner-accent bottom-right"></div>
                <div class="flex justify-between items-start mb-6 relative z-10">
                    <div
                        class="w-14 h-14 rounded-2xl bg-pink-500/10 text-pink-500 flex items-center justify-center text-2xl group-hover:scale-110 group-hover:rotate-[15deg] transition-all duration-700">
                        <i class="ri-price-tag-3-fill"></i>
                    </div>
                </div>
                <div class="relative z-10">
                    <p class="text-[10px] text-text-muted font-black uppercase tracking-[0.2em] mb-2 opacity-50 group-hover:opacity-100 group-hover:text-pink-500 transition-all duration-500">Total Products</p>
                    <h3 class="text-3xl font-heading font-black text-white group-hover:tracking-wider transition-all duration-500 leading-none">{{ number_format($totalProducts) }}</h3>
                </div>
            </div>

            <!-- Total Wishlist -->
            <div class="crystalline-card p-6 rounded-[2rem] group cursor-default glow-emerald-crystalline h-full flex flex-col justify-between"
                data-aos="fade-up" data-aos-delay="400">
                <div class="grain-overlay"></div>
                <div class="corner-accent top-left"></div>
                <div class="corner-accent bottom-right"></div>
                <div class="flex justify-between items-start mb-6 relative z-10">
                    <div
                        class="w-14 h-14 rounded-2xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-2xl group-hover:scale-110 group-hover:rotate-[15deg] transition-all duration-700">
                        <i class="ri-heart-fill"></i>
                    </div>
                </div>
                <div class="relative z-10">
                    <p class="text-[10px] text-text-muted font-black uppercase tracking-[0.2em] mb-2 opacity-50 group-hover:opacity-100 group-hover:text-emerald-400 transition-all duration-500">Wishlisted Items</p>
                    <h3 class="text-3xl font-heading font-black text-white group-hover:tracking-wider transition-all duration-500 leading-none">{{ number_format($totalWishlist) }}</h3>
                </div>
            </div>

        </div>

        <!-- Charts & Recent Orders -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Revenue Chart -->
            <div class="lg:col-span-2 glass-panel p-6 rounded-2xl border border-gray-800" data-aos="fade-right">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-heading font-bold text-lg">Revenue Overview (Last 7 Days)</h3>
                    <button class="text-text-muted hover:text-white transition-colors"><i
                            class="ri-more-2-fill text-xl"></i></button>
                </div>
                <div class="h-72 w-full relative">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="glass-panel p-6 rounded-2xl border border-gray-800 flex flex-col" data-aos="fade-left">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-heading font-bold text-lg">Recent Orders</h3>
                    <a href="{{ route('admin.orders.index') }}" class="text-sm text-orange hover:underline">View All</a>
                </div>

                <div class="space-y-4 flex-grow overflow-y-auto custom-scrollbar pr-2">
                    @if($recentOrders->count() > 0)
                        @foreach($recentOrders as $order)
                            <div class="flex items-center justify-between p-3 rounded-xl bg-surface-hover border border-gray-800">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-surface flex items-center justify-center text-text-muted border border-gray-700">
                                        <i class="ri-shopping-basket-line"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold">#{{ substr(md5($order->id), 0, 6) }}</div>
                                        <div class="text-xs text-text-muted">{{ $order->user->name }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-white">${{ number_format($order->total, 2) }}</div>
                                    <div class="text-[10px] font-bold uppercase tracking-wider
                                                                                    @if($order->status == 'pending') text-yellow-500
                                                                                    @elseif($order->status == 'processing') text-blue-500
                                                                                    @elseif($order->status == 'shipped') text-purple-400
                                                                                    @elseif($order->status == 'delivered') text-green-400
                                                                                    @else text-red-500 @endif">
                                        {{ $order->status }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="flex flex-col items-center justify-center h-full text-text-muted">
                            <i class="ri-inbox-line text-4xl mb-2"></i>
                            <p class="text-sm">No recent orders found.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('revenueChart').getContext('2d');

        // Setup gradient for chart area
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(255, 107, 0, 0.5)');
        gradient.addColorStop(1, 'rgba(255, 107, 0, 0.0)');

        // Extract PHP variables to JS
        const labels = {!! json_encode($chartLabels ?? []) !!};
        const data = {!! json_encode($chartData ?? []) !!};

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Revenue ($)',
                    data: data,
                    borderColor: '#FF6B00',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#141414',
                    pointBorderColor: '#FF6B00',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4 // Smooth curves
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1A1A1A',
                        titleColor: '#F0F0F0',
                        bodyColor: '#FF6B00',
                        borderColor: '#333',
                        borderWidth: 1,
                        padding: 10,
                        displayColors: false,
                        callbacks: {
                            label: function (context) {
                                let label = context.dataset.label || '';
                                if (label) { label += ': '; }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(255, 255, 255, 0.05)', drawBorder: false },
                        ticks: { color: '#999999', callback: function (value) { return '$' + value; } }
                    },
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { color: '#999999' }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
            }
        });
    });
</script>
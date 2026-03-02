@extends('layouts.admin')

@section('title', 'Manage Orders')

@section('content')
    <div class="space-y-6">

        <!-- Top Actions -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <form action="{{ route('admin.orders.index') }}" method="GET"
                class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                <div class="relative w-full sm:w-64">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search order or customer..."
                        class="w-full bg-surface border border-gray-800 rounded-lg py-2 pl-10 pr-4 text-sm focus:outline-none focus:border-orange transition-colors">
                    <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-text-muted"></i>
                </div>

                <select name="status" onchange="this.form.submit()"
                    class="bg-surface border border-gray-800 rounded-lg py-2 px-4 text-sm focus:outline-none focus:border-orange transition-colors min-w-[140px]">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>

                @if(request()->anyFilled(['search', 'status']))
                    <a href="{{ route('admin.orders.index') }}"
                        class="btn btn-outline py-2 px-4 text-xs flex items-center justify-center">
                        <i class="ri-refresh-line mr-1"></i> Clear
                    </a>
                @endif
            </form>

            <div class="flex gap-2 w-full sm:w-auto">
                {{-- Global Export could be implemented but for now we focus on individual and better UI --}}
                <div class="text-xs text-text-muted italic">Filter and search to find specific heat orders</div>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="glass-panel rounded-2xl border border-gray-800 overflow-hidden" data-aos="fade-up">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead
                        class="bg-surface border-b border-gray-800 text-text-muted uppercase tracking-wider text-[10px] font-bold">
                        <tr>
                            <th class="px-6 py-4">Order ID</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Customer</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Total</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @forelse($orders as $order)
                            <tr class="hover:bg-surface-hover/50 transition-colors">
                                <td class="px-6 py-4 font-bold font-mono">
                                    #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-6 py-4 text-text-muted">
                                    {{ $order->created_at->format('M d, Y h:i A') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-orange-glow border border-orange flex items-center justify-center text-orange font-bold text-xs uppercase">
                                            {{ substr($order->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-bold">{{ $order->user->name }}</div>
                                            <div class="text-xs text-text-muted">{{ $order->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider
                                                                        @if($order->status == 'pending') bg-yellow-500/10 text-yellow-500 border border-yellow-500/20
                                                                        @elseif($order->status == 'processing') bg-blue-500/10 text-blue-500 border border-blue-500/20
                                                                        @elseif($order->status == 'shipped') bg-purple-500/10 text-purple-400 border border-purple-500/20
                                                                        @elseif($order->status == 'delivered') bg-green-500/10 text-green-400 border border-green-500/20
                                                                        @else bg-red-500/10 text-red-500 border border-red-500/20 @endif">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-bold">
                                    ${{ number_format($order->total, 2) }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.orders.export', $order->id) }}"
                                            class="btn btn-outline p-1.5 text-xs hover:border-orange hover:text-orange transition-colors"
                                            title="Export PDF">
                                            <i class="ri-download-2-line"></i>
                                        </a>
                                        <a href="{{ route('admin.orders.show', $order->id) }}"
                                            class="btn btn-outline py-1.5 px-3 text-xs hover:border-orange hover:text-orange transition-colors">
                                            View Details
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-text-muted">
                                    <div
                                        class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-surface border border-gray-800 mb-4 text-2xl">
                                        <i class="ri-shopping-bag-3-line"></i>
                                    </div>
                                    <p>No orders found matching your criteria.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($orders->count() > 0)
                <div class="p-4 border-t border-gray-800 bg-surface/50 custom-pagination">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
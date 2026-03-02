@extends('layouts.admin')

@section('title', 'Manage Coupons')

@section('content')
    <div class="space-y-6">

        <!-- Top Actions -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <form action="{{ route('admin.coupons.index') }}" method="GET" class="relative w-full sm:w-96">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by code..."
                    class="w-full bg-surface border border-gray-800 rounded-lg py-2 pl-10 pr-4 text-sm focus:outline-none focus:border-orange transition-colors">
                <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-text-muted"></i>
            </form>
            <button onclick="document.dispatchEvent(new CustomEvent('open-coupon-modal'))"
                class="btn btn-primary text-sm interactive whitespace-nowrap">
                <i class="ri-add-line mr-2"></i> Create Coupon
            </button>
        </div>

        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500/50 text-red-500 px-4 py-3 rounded-xl relative" role="alert">
                <strong class="font-bold">Oops!</strong>
                <span class="block sm:inline">Please check the form below for errors.</span>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-sm mt-1">- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Coupons Table -->
        <div class="glass-panel rounded-2xl border border-gray-800 overflow-hidden" data-aos="fade-up">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead
                        class="bg-surface border-b border-gray-800 text-text-muted uppercase tracking-wider text-[10px] font-bold">
                        <tr>
                            <th class="px-6 py-4">Code</th>
                            <th class="px-6 py-4">Discount</th>
                            <th class="px-6 py-4">Min. Order</th>
                            <th class="px-6 py-4">Status / Uses Left</th>
                            <th class="px-6 py-4">Created By</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @forelse($coupons as $coupon)
                            <tr class="hover:bg-surface-hover/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div
                                        class="font-mono font-bold text-orange tracking-wider bg-orange-glow/10 px-2 py-1 rounded inline-block border border-orange/20">
                                        {{ $coupon->code }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-bold">
                                    @if($coupon->type == 'percent')
                                        {{ $coupon->value }}% OFF
                                    @else
                                        ${{ number_format($coupon->value, 2) }} OFF
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-text-muted">
                                    {{ $coupon->min_order ? '$' . number_format($coupon->min_order, 2) : 'None' }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($coupon->uses_left == 0)
                                        <span
                                            class="text-red-500 bg-red-500/10 px-2 py-1 rounded uppercase tracking-wider font-bold text-[10px]">Depleted</span>
                                    @else
                                        <span class="text-emerald-400 bg-emerald-400/10 px-2 py-1 rounded font-bold text-xs">
                                            {{ $coupon->uses_left === null ? 'Unlimited' : $coupon->uses_left . ' left' }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-xs text-text-muted">
                                    {{ $coupon->user->name ?? 'System' }}<br>
                                    {{ $coupon->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this coupon?');"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-8 h-8 rounded-full bg-surface-hover border border-gray-700 flex items-center justify-center text-text-muted hover:text-red-500 hover:border-red-500 transition-colors"
                                            title="Delete">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-text-muted">
                                    <div
                                        class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-surface border border-gray-800 mb-4 text-2xl">
                                        <i class="ri-coupon-3-line"></i>
                                    </div>
                                    <p>No coupons have been created yet.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($coupons->hasPages())
                <div class="p-4 border-t border-gray-800 bg-surface/50 custom-pagination">
                    {{ $coupons->links() }}
                </div>
            @endif
        </div>

    </div>

    <!-- Create Modal -->
    <div id="coupon-modal" class="fixed inset-0 z-50 hidden opacity-0 transition-opacity duration-300">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" onclick="closeCouponModal()"></div>

        <!-- Modal Content -->
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div
                class="bg-bg border border-gray-800 rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden transform scale-95 transition-transform duration-300 modal-content relative">

                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-orange to-pink-500"></div>

                <div class="p-6 md:p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-heading font-bold">Create Coupon</h2>
                        <button onclick="closeCouponModal()"
                            class="text-text-muted hover:text-white text-2xl transition-colors">
                            <i class="ri-close-line"></i>
                        </button>
                    </div>

                    <form action="{{ route('admin.coupons.store') }}" method="POST">
                        @csrf

                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-medium mb-2 text-text-muted">Coupon Code*</label>
                                <div class="flex gap-2">
                                    <input type="text" name="code" id="coupon-code" required
                                        class="form-control font-mono uppercase" placeholder="e.g. SUMMER24">
                                    <button type="button" onclick="generateCode()" class="btn btn-outline px-3"
                                        title="Generate Random">
                                        <i class="ri-refresh-line"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-2 text-text-muted">Type*</label>
                                    <select name="type" required class="form-control bg-surface text-white">
                                        <option value="percent">Percentage (%)</option>
                                        <option value="flat">Flat Amount ($)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-2 text-text-muted">Value*</label>
                                    <input type="number" step="0.01" name="value" required class="form-control"
                                        placeholder="0">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-2 text-text-muted">Min. Order Amount
                                        ($)</label>
                                    <input type="number" step="0.01" name="min_order" class="form-control"
                                        placeholder="Leave empty for none">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-2 text-text-muted">Total Uses</label>
                                    <input type="number" name="uses_left" class="form-control"
                                        placeholder="Leave empty for unlimited">
                                </div>
                            </div>

                            <div class="pt-6 flex justify-end gap-3">
                                <button type="button" onclick="closeCouponModal()"
                                    class="btn btn-outline interactive">Cancel</button>
                                <button type="submit" class="btn btn-primary interactive shadow-orange">Create
                                    Coupon</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')

@endpush

@push('scripts')
    <script>
        const modal = document.getElementById('coupon-modal');
        const modalContent = modal.querySelector('.modal-content');

        document.addEventListener('open-coupon-modal', () => {
            modal.classList.remove('hidden');
            void modal.offsetWidth;
            modal.classList.remove('opacity-0');
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
        });

        function closeCouponModal() {
            modal.classList.add('opacity-0');
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        function generateCode() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let code = '';
            for (let i = 0; i < 8; i++) {
                code += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            document.getElementById('coupon-code').value = code;
        }
    </script>
@endpush
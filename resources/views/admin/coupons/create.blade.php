@extends('layouts.admin')

@section('title', isset($coupon) ? 'Edit Coupon' : 'Add New Coupon')

@section('content')
    <div class="max-w-4xl">

        <div class="flex items-center gap-4 mb-6" data-aos="fade-right">
            <a href="{{ route('admin.coupons.index') }}"
                class="w-10 h-10 rounded-full bg-surface border border-gray-800 flex items-center justify-center text-text-muted hover:text-white transition-colors interactive">
                <i class="ri-arrow-left-line"></i>
            </a>
            <h2 class="text-2xl font-heading font-bold">{{ isset($coupon) ? 'Edit Coupon' : 'Create New Coupon' }}</h2>
        </div>

        <form action="{{ isset($coupon) ? route('admin.coupons.update', $coupon) : route('admin.coupons.store') }}"
            method="POST" class="space-y-6" data-aos="fade-up">
            @csrf
            @if(isset($coupon)) @method('PUT') @endif

            <div class="glass-panel p-8 rounded-2xl border border-gray-800">
                <h3 class="text-lg font-heading font-bold mb-6 border-b border-gray-800 pb-4">Coupon Details</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-2 text-text-muted">Coupon Code*</label>
                        <input type="text" name="code" value="{{ old('code', $coupon->code ?? '') }}" required
                            class="form-control uppercase" placeholder="e.g. SUMMER20">
                        @error('code') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2 text-text-muted">Discount Type*</label>
                        <select name="type" required class="form-control bg-surface text-white">
                            <option value="percent" {{ (old('type', $coupon->type ?? '') == 'percent') ? 'selected' : '' }}>Percentage (%)</option>
                            <option value="flat" {{ (old('type', $coupon->type ?? '') == 'flat') ? 'selected' : '' }}>Flat Amount ($)</option>
                        </select>
                        @error('type') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2 text-text-muted">Discount Value*</label>
                        <input type="number" step="0.01" name="value" value="{{ old('value', $coupon->value ?? '') }}" required
                            class="form-control" placeholder="0.00">
                        @error('value') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2 text-text-muted">Minimum Order Amount*</label>
                        <input type="number" step="0.01" name="min_order" value="{{ old('min_order', $coupon->min_order ?? '0') }}" required
                            class="form-control" placeholder="0.00">
                        @error('min_order') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium mb-2 text-text-muted">Uses Left*</label>
                        <input type="number" name="uses_left" value="{{ old('uses_left', $coupon->uses_left ?? '100') }}" required
                            class="form-control" placeholder="100">
                        @error('uses_left') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="flex gap-4 pt-4">
                <a href="{{ route('admin.coupons.index') }}"
                    class="btn btn-outline interactive flex-1 text-center justify-center">Cancel</a>
                <button type="submit"
                    class="btn btn-primary interactive shadow-orange flex-1">{{ isset($coupon) ? 'Update Coupon' : 'Create Coupon' }}</button>
            </div>

        </form>
    </div>
@endsection

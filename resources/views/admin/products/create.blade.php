@extends('layouts.admin')

@section('title', isset($product) ? 'Edit Product' : 'Add New Product')

@section('content')
    <div class="max-w-4xl">

        <div class="flex items-center gap-4 mb-6" data-aos="fade-right">
            <a href="{{ route('admin.products.index') }}"
                class="w-10 h-10 rounded-full bg-surface border border-gray-800 flex items-center justify-center text-text-muted hover:text-white transition-colors interactive">
                <i class="ri-arrow-left-line"></i>
            </a>
            <h2 class="text-2xl font-heading font-bold">{{ isset($product) ? 'Edit Product' : 'Create New Product' }}</h2>
        </div>

        <form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}"
            method="POST" enctype="multipart/form-data" class="space-y-6" data-aos="fade-up">
            @csrf
            @if(isset($product)) @method('PUT') @endif

            <div class="glass-panel p-8 rounded-2xl border border-gray-800">
                <h3 class="text-lg font-heading font-bold mb-6 border-b border-gray-800 pb-4">Basic Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium mb-2 text-text-muted">Product Name*</label>
                        <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required
                            class="form-control" placeholder="e.g. Orange Fade Oversized Hoodie">
                        @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium mb-2 text-text-muted">Category*</label>
                        <select name="category_id" required class="form-control bg-surface text-white">
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id ?? '') == $category->id) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium mb-2 text-text-muted">Description</label>
                        <textarea name="description" rows="5" class="form-control resize-none"
                            placeholder="Product details, materials, fit...">{{ old('description', $product->description ?? '') }}</textarea>
                        @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Pricing & Inventory -->
                <div class="glass-panel p-8 rounded-2xl border border-gray-800">
                    <h3 class="text-lg font-heading font-bold mb-6 border-b border-gray-800 pb-4">Pricing & Inventory</h3>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium mb-2 text-text-muted">Regular Price ($)*</label>
                            <input type="number" step="0.01" name="price" value="{{ old('price', $product->price ?? '') }}"
                                required class="form-control" placeholder="0.00">
                            @error('price') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2 text-text-muted">Sale Price ($)</label>
                            <input type="number" step="0.01" name="sale_price"
                                value="{{ old('sale_price', $product->sale_price ?? '') }}" class="form-control"
                                placeholder="0.00 (Optional)">
                            @error('sale_price') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2 text-text-muted">Stock Quantity*</label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" required
                                class="form-control" placeholder="0">
                            @error('stock') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Media & Visibility -->
                <div class="glass-panel p-8 rounded-2xl border border-gray-800">
                    <h3 class="text-lg font-heading font-bold mb-6 border-b border-gray-800 pb-4">Media & Visibility</h3>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium mb-2 text-text-muted">Product Image
                                {{ isset($product) ? '(Upload to add new)' : '* (Required)' }}</label>

                            <div
                                class="relative w-full h-48 border-2 border-dashed border-gray-700 rounded-xl bg-surface-hover hover:border-orange hover:bg-orange-glow/10 transition-colors flex items-center justify-center cursor-pointer overflow-hidden group">

                                <input type="file" name="image" id="imageInput" accept="image/*"
                                    class="absolute inset-0 opacity-0 cursor-pointer z-10"
                                    onchange="previewImage(this, 'imgPreview')" {{ !isset($product) ? 'required' : '' }}>

                                <div class="text-center text-text-muted group-hover:text-orange transition-colors {{ (isset($product) && !empty($product->images) && count($product->images) > 0) ? 'hidden' : '' }}"
                                    id="uploadPlaceholder">
                                    <i class="ri-upload-cloud-2-line text-4xl mb-2"></i>
                                    <p class="text-sm">Click to upload image</p>
                                    <p class="text-xs mt-1 opacity-70">JPEG, PNG, WEBP up to 2MB</p>
                                </div>

                                <img id="imgPreview"
                                    src="{{ (isset($product) && !empty($product->images) && count($product->images) > 0) ? (\Illuminate\Support\Str::startsWith($product->images[0]['path'], ['http://', 'https://']) ? $product->images[0]['path'] : Storage::url($product->images[0]['path'])) : '' }}"
                                    class="absolute inset-0 w-full h-full object-cover {{ (isset($product) && !empty($product->images) && count($product->images) > 0) ? '' : 'hidden' }}">
                            </div>
                            @error('image') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="pt-4 border-t border-gray-800">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" name="featured" value="1" class="hidden" {{ old('featured', $product->featured ?? false) ? 'checked' : '' }} onchange="updateToggle(this)">
                                <div
                                    class="w-12 h-6 bg-surface border border-gray-600 rounded-full relative transition-colors toggle-bg {{ old('featured', $product->featured ?? false) ? '!bg-orange !border-orange' : '' }}">
                                    <div
                                        class="w-4 h-4 rounded-full bg-text-muted absolute top-1 left-1 transition-all toggle-dot {{ old('featured', $product->featured ?? false) ? 'translate-x-6 !bg-white' : '' }}">
                                    </div>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-white block">Featured Product</span>
                                    <span class="text-xs text-text-muted">Display prominently on the home page</span>
                                </div>
                            </label>
                        </div>

                        <div class="pt-4 border-t border-gray-800">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" name="is_new_arrival" value="1" class="hidden" {{ old('is_new_arrival', $product->is_new_arrival ?? false) ? 'checked' : '' }}
                                    onchange="updateToggle(this)">
                                <div
                                    class="w-12 h-6 bg-surface border border-gray-600 rounded-full relative transition-colors toggle-bg {{ old('is_new_arrival', $product->is_new_arrival ?? false) ? '!bg-orange !border-orange' : '' }}">
                                    <div
                                        class="w-4 h-4 rounded-full bg-text-muted absolute top-1 left-1 transition-all toggle-dot {{ old('is_new_arrival', $product->is_new_arrival ?? false) ? 'translate-x-6 !bg-white' : '' }}">
                                    </div>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-white block">New Arrival <span
                                            class="text-[10px] text-orange font-bold uppercase ml-1">🔥
                                            Marquee</span></span>
                                    <span class="text-xs text-text-muted">Show in the home page New Arrivals marquee</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 pt-4">
                <a href="{{ route('admin.products.index') }}"
                    class="btn btn-outline interactive flex-1 text-center justify-center">Cancel</a>
                <button type="submit"
                    class="btn btn-primary interactive shadow-orange flex-1">{{ isset($product) ? 'Update Product' : 'Create Product' }}</button>
            </div>

        </form>
    </div>
@endsection

@push('styles')
    <style>
        .toggle-dot {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
@endpush

@push('scripts')
    <script>
        function updateToggle(checkbox) {
            const bg = checkbox.nextElementSibling;
            const dot = bg.querySelector('.toggle-dot');

            if (checkbox.checked) {
                bg.classList.add('!bg-orange', '!border-orange');
                dot.classList.add('translate-x-6', '!bg-white');
            } else {
                bg.classList.remove('!bg-orange', '!border-orange');
                dot.classList.remove('translate-x-6', '!bg-white');
            }
        }

        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            const placeholder = document.getElementById('uploadPlaceholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if (placeholder) placeholder.classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
@extends('layouts.admin')

@section('title', isset($category) ? 'Edit Category' : 'Add New Category')

@section('content')
    <div class="max-w-4xl">

        <div class="flex items-center gap-4 mb-6" data-aos="fade-right">
            <a href="{{ route('admin.categories.index') }}"
                class="w-10 h-10 rounded-full bg-surface border border-gray-800 flex items-center justify-center text-text-muted hover:text-white transition-colors interactive">
                <i class="ri-arrow-left-line"></i>
            </a>
            <h2 class="text-2xl font-heading font-bold">{{ isset($category) ? 'Edit Category' : 'Create New Category' }}</h2>
        </div>

        <form action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
            method="POST" class="space-y-6" data-aos="fade-up">
            @csrf
            @if(isset($category)) @method('PUT') @endif

            <div class="glass-panel p-8 rounded-2xl border border-gray-800">
                <h3 class="text-lg font-heading font-bold mb-6 border-b border-gray-800 pb-4">Category Details</h3>

                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-2 text-text-muted">Category Name*</label>
                        <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" required
                            class="form-control" placeholder="e.g. Graphic Tees">
                        @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2 text-text-muted">Description</label>
                        <textarea name="description" rows="4" class="form-control resize-none"
                            placeholder="Brief description of the category...">{{ old('description', $category->description ?? '') }}</textarea>
                        @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="flex gap-4 pt-4">
                <a href="{{ route('admin.categories.index') }}"
                    class="btn btn-outline interactive flex-1 text-center justify-center">Cancel</a>
                <button type="submit"
                    class="btn btn-primary interactive shadow-orange flex-1">{{ isset($category) ? 'Update Category' : 'Create Category' }}</button>
            </div>

        </form>
    </div>
@endsection

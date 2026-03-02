@extends('layouts.admin')

@section('title', 'Manage Categories')

@section('content')
    <div class="space-y-6">

        <!-- Top Actions -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <form action="{{ route('admin.categories.index') }}" method="GET" class="relative w-full sm:w-96">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search categories..."
                    class="w-full bg-surface border border-gray-800 rounded-lg py-2 pl-10 pr-4 text-sm focus:outline-none focus:border-orange transition-colors">
                <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-text-muted"></i>
            </form>
            <button onclick="document.dispatchEvent(new CustomEvent('open-category-modal'))"
                class="btn btn-primary text-sm interactive whitespace-nowrap">
                <i class="ri-add-line mr-2"></i> Add Category
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

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" data-aos="fade-up">
            @forelse($categories as $category)
                <div
                    class="glass-panel p-6 rounded-2xl border border-gray-800 hover:border-orange/50 transition-all group relative overflow-hidden">
                    <!-- Decorative gradient orb -->
                    <div
                        class="absolute -top-10 -right-10 w-32 h-32 bg-orange-glow blur-3xl opacity-0 group-hover:opacity-20 transition-opacity">
                    </div>

                    <div
                        class="w-16 h-16 rounded-xl bg-surface border border-gray-800 flex items-center justify-center text-3xl mb-4 text-text-muted group-hover:text-orange transition-colors">
                        @if($category->image)
                            <img src="{{ (\Illuminate\Support\Str::startsWith($category->image, ['http://', 'https://']) ? $category->image : Storage::url($category->image)) }}" class="w-full h-full object-cover rounded-xl p-1">
                        @else
                            <i class="ri-layout-masonry-line"></i>
                        @endif
                    </div>

                    <h3 class="font-heading font-bold text-xl mb-1 group-hover:text-orange transition-colors">
                        {{ $category->name }}</h3>
                    <p class="text-sm text-text-muted mb-6 h-10 truncate whitespace-normal"
                        style="-webkit-line-clamp: 2; display: -webkit-box; -webkit-box-orient: vertical; white-space: normal;">
                        {{ $category->description ?? 'No description provided.' }}
                    </p>

                    <div class="flex items-center justify-between border-t border-gray-800 pt-4 mt-auto">
                        <span class="text-xs font-bold text-text-muted bg-surface-hover px-2 py-1 rounded">
                            {{ $category->products_count ?? $category->products()->count() }} Products
                        </span>

                        <div class="flex gap-2">
                            <button onclick='editCategory(@json($category))'
                                class="w-8 h-8 rounded-full bg-surface-hover flex items-center justify-center text-text-muted hover:text-orange transition-colors">
                                <i class="ri-edit-line"></i>
                            </button>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                onsubmit="return confirm('Are you sure? Deleting a category will orphan its products.');"
                                class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-8 h-8 rounded-full bg-surface-hover flex items-center justify-center text-text-muted hover:text-red-500 hover:bg-red-500/10 transition-colors">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <div
                        class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-surface border border-gray-800 mb-6 text-4xl text-orange">
                        <i class="ri-layout-grid-fill"></i>
                    </div>
                    <h3 class="text-2xl font-heading font-bold mb-2">No Categories Yet</h3>
                    <p class="text-text-muted mb-6">Create categories to organize your products efficiently.</p>
                    <button onclick="document.dispatchEvent(new CustomEvent('open-category-modal'))"
                        class="btn btn-primary interactive">Create First Category</button>
                </div>
            @endforelse
        </div>

    </div>

    <!-- Create/Edit Modal (Simplified UI Approach) -->
    <div id="category-modal" class="fixed inset-0 z-50 hidden opacity-0 transition-opacity duration-300">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" onclick="closeCategoryModal()"></div>

        <!-- Modal Content -->
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <!-- Scale inner content on active -->
            <div
                class="bg-bg border border-gray-800 rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden transform scale-95 transition-transform duration-300 modal-content relative">

                <!-- Orange top accent -->
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-orange to-yellow-500"></div>

                <div class="p-6 md:p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-heading font-bold" id="modal-title">Create Category</h2>
                        <button onclick="closeCategoryModal()"
                            class="text-text-muted hover:text-white text-2xl transition-colors">
                            <i class="ri-close-line"></i>
                        </button>
                    </div>

                    <form id="category-form" action="{{ route('admin.categories.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" id="form-method" value="POST">

                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-medium mb-2 text-text-muted">Category Name*</label>
                                <input type="text" name="name" id="cat-name" required class="form-control"
                                    placeholder="e.g. Outerwear">
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2 text-text-muted">Description</label>
                                <textarea name="description" id="cat-desc" rows="3" class="form-control resize-none"
                                    placeholder="Short description of this category"></textarea>
                            </div>

                            <!-- Simplify Image Upload for Modal -->
                            <div>
                                <label class="block text-sm font-medium mb-2 text-text-muted">Category Icon/Image
                                    (Optional)</label>
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 rounded-xl bg-surface-hover border border-dashed border-gray-600 flex items-center justify-center overflow-hidden"
                                        id="current-img-container">
                                        <i class="ri-image-add-line text-2xl text-text-muted" id="img-icon"></i>
                                        <img src="" id="current-img" class="w-full h-full object-cover hidden">
                                    </div>
                                    <div class="flex-grow">
                                        <input type="file" name="image" id="cat-image" accept="image/*"
                                            class="w-full text-sm text-text-muted file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-surface file:text-white hover:file:bg-surface-hover transition-colors"
                                            onchange="previewCatImage(this)">
                                    </div>
                                </div>
                            </div>

                            <div class="pt-6 flex justify-end gap-3">
                                <button type="button" onclick="closeCategoryModal()"
                                    class="btn btn-outline interactive">Cancel</button>
                                <button type="submit" class="btn btn-primary interactive shadow-orange"
                                    id="submit-btn-text">Create Category</button>
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
        const modal = document.getElementById('category-modal');
        const modalContent = modal.querySelector('.modal-content');
        const form = document.getElementById('category-form');

        document.addEventListener('open-category-modal', () => {
            // Reset form for create
            form.action = "{{ route('admin.categories.store') }}";
            document.getElementById('form-method').value = 'POST';
            document.getElementById('modal-title').innerText = 'Create Category';
            document.getElementById('submit-btn-text').innerText = 'Create Category';

            form.reset();
            document.getElementById('img-icon').classList.remove('hidden');
            document.getElementById('current-img').classList.add('hidden');
            document.getElementById('current-img').src = '';

            openModal();
        });

        function editCategory(category) {
            // Setup form for edit
            form.action = `/admin/categories/${category.id}`;
            document.getElementById('form-method').value = 'PUT';
            document.getElementById('modal-title').innerText = 'Edit Category';
            document.getElementById('submit-btn-text').innerText = 'Update Category';

            document.getElementById('cat-name').value = category.name;
            document.getElementById('cat-desc').value = category.description || '';

            if (category.image) {
                document.getElementById('img-icon').classList.add('hidden');
                document.getElementById('current-img').classList.remove('hidden');
                document.getElementById('current-img').src = '/storage/' + category.image;
            } else {
                document.getElementById('img-icon').classList.remove('hidden');
                document.getElementById('current-img').classList.add('hidden');
                document.getElementById('current-img').src = '';
            }

            openModal();
        }

        function openModal() {
            modal.classList.remove('hidden');
            // Trigger reflow to ensure transition works
            void modal.offsetWidth;
            modal.classList.remove('opacity-0');
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
        }

        function closeCategoryModal() {
            modal.classList.add('opacity-0');
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300); // Matches transition duration
        }

        function previewCatImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.getElementById('current-img');
                    const icon = document.getElementById('img-icon');
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                    icon.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
<div id="toast-container" class="fixed bottom-5 right-5 z-[9999] flex flex-col gap-3 pointer-events-none">
    <!-- Toasts will be injected here -->
</div>

<!-- Initial Session Toasts -->
@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            showToast('{{ session('success') }}', 'success');
        });
    </script>
@endif

@if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            showToast('{{ session('error') }}', 'error');
        });
    </script>
@endif

<script>
    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');

        const toast = document.createElement('div');
        toast.className = `glass-panel px-6 py-4 rounded-md shadow-lg flex items-center gap-3 transform translate-x-full opacity-0 transition-all duration-300 pointer-events-auto`;

        // Dynamic border color based on type
        if (type === 'success') {
            toast.style.borderLeft = '4px solid #10B981'; // Green
        } else if (type === 'error') {
            toast.style.borderLeft = '4px solid #EF4444'; // Red
        } else if (type === 'warning') {
            toast.style.borderLeft = '4px solid #F59E0B'; // Yellow
        } else {
            toast.style.borderLeft = '4px solid var(--c-orange)'; // Orange info
        }

        const iconClass = type === 'success' ? 'ri-checkbox-circle-fill text-[#10B981]' :
            type === 'error' ? 'ri-error-warning-fill text-[#EF4444]' :
                'ri-information-fill text-orange';

        toast.innerHTML = `
            <i class="${iconClass} text-xl"></i>
            <p class="text-sm font-medium text-text">${message}</p>
        `;

        container.appendChild(toast);

        // Trigger reflow & animate in
        void toast.offsetWidth;
        toast.classList.remove('translate-x-full', 'opacity-0');

        // Auto remove
        setTimeout(() => {
            toast.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => {
                if (container.contains(toast)) {
                    container.removeChild(toast);
                }
            }, 300);
        }, 4000);
    }

    // Global AJAX setup for CSRF
    document.addEventListener('DOMContentLoaded', () => {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        window.fetchJson = async (url, options = {}) => {
            const defaultHeaders = {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            };

            options.headers = { ...defaultHeaders, ...options.headers };

            try {
                const response = await fetch(url, options);
                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'An error occurred');
                }

                return data;
            } catch (error) {
                console.error('Fetch error:', error);
                showToast(error.message, 'error');
                throw error;
            }
        };

        // Global Add to Cart functionality
        document.querySelectorAll('.add-to-cart-quick').forEach(button => {
            button.addEventListener('click', async (e) => {
                e.preventDefault();
                const btn = e.currentTarget;
                const id = btn.getAttribute('data-id');

                // Pulse animation
                btn.style.transform = 'scale(0.9)';
                setTimeout(() => btn.style.transform = '', 150);

                try {
                    const data = await fetchJson('{{ route("cart.add") }}', {
                        method: 'POST',
                        body: JSON.stringify({ product_id: id, quantity: 1 })
                    });

                    if (data.success) {
                        showToast('Added to cart successfully!');
                        // Update cart badges
                        document.querySelectorAll('.cart-count').forEach(badge => {
                            badge.textContent = data.cart_count;
                            // Badge pop animation
                            badge.style.transform = 'scale(1.5)';
                            setTimeout(() => {
                                badge.style.transform = '';
                                badge.style.transition = 'transform 0.3s ease';
                            }, 150);
                        });
                    }
                } catch (error) {
                    showToast('Failed to add to cart: ' + error.message, 'error');
                }
            });
        });

        // Global Add to Wishlist functionality
        document.querySelectorAll('.add-to-wishlist').forEach(button => {
            button.addEventListener('click', async (e) => {
                e.preventDefault();
                const btn = e.currentTarget;
                const id = btn.getAttribute('data-id');
                const icon = btn.querySelector('i');

                // Pulse animation
                btn.style.transform = 'scale(0.9)';
                setTimeout(() => btn.style.transform = '', 150);

                try {
                    const data = await fetchJson('{{ route("wishlist.toggle") }}', {
                        method: 'POST',
                        body: JSON.stringify({ product_id: id })
                    });

                    if (data.success) {
                        if (data.status === 'added') {
                            icon.classList.remove('ri-heart-line');
                            icon.classList.add('ri-heart-fill');
                            btn.style.color = 'var(--c-orange)';
                            showToast('Added to wishlist!');
                        } else {
                            icon.classList.remove('ri-heart-fill');
                            icon.classList.add('ri-heart-line');
                            btn.style.color = '';
                            showToast('Removed from wishlist');
                        }
                    }
                } catch (error) {
                    showToast('Please login to use wishlist', 'error');
                }
            });
        });
    });
</script>

<style>
    .bottom-5 {
        bottom: 1.25rem;
    }

    .right-5 {
        right: 1.25rem;
    }

    .z-\[9999\] {
        z-index: 9999;
    }

    .translate-x-full {
        transform: translateX(100%);
    }

    .shadow-lg {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5), 0 4px 6px -2px rgba(0, 0, 0, 0.3);
    }

    .text-\[\#10B981\] {
        color: #10B981;
    }

    .text-\[\#EF4444\] {
        color: #EF4444;
    }

    .text-text {
        color: var(--c-text);
    }

    .pointer-events-auto {
        pointer-events: auto;
    }
</style>
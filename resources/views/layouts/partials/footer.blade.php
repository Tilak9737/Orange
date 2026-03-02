<footer id="footer" class="bg-surface border-t border-gray-800 py-12 mt-20 relative overflow-hidden">
    <!-- Decorative Glow -->
    <div
        class="absolute top-0 left-1/2 -translate-x-1/2 w-3/4 h-1 bg-gradient-to-r from-transparent via-orange to-transparent opacity-50">
    </div>
    <div
        class="absolute -top-32 left-1/2 -translate-x-1/2 w-[500px] h-[300px] bg-orange-glow blur-[100px] rounded-full pointer-events-none opacity-20">
    </div>

    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 text-center md:text-left">

            <!-- Brand -->
            <div class="col-span-1 md:col-span-1">
                <a href="{{ route('home') }}"
                    class="text-3xl font-bold font-heading text-orange interactive inline-flex items-center gap-2 mb-6">
                    <i class="ri-fire-fill text-orange"></i>
                    Orange
                </a>
                <p class="text-text-muted text-sm mb-6">
                    Ignite your style with our premium, vibrant collection. Where high-end fashion meets dynamic energy.
                </p>
                <div class="flex items-center justify-center md:justify-start gap-4">
                    <a href="https://instagram.com" target="_blank"
                        class="w-10 h-10 rounded-full border border-gray-800 flex items-center justify-center hover:border-orange hover:text-orange transition-colors interactive">
                        <i class="ri-instagram-line"></i>
                    </a>
                    <a href="https://twitter.com" target="_blank"
                        class="w-10 h-10 rounded-full border border-gray-800 flex items-center justify-center hover:border-orange hover:text-orange transition-colors interactive">
                        <i class="ri-twitter-x-line"></i>
                    </a>
                    <a href="https://facebook.com" target="_blank"
                        class="w-10 h-10 rounded-full border border-gray-800 flex items-center justify-center hover:border-orange hover:text-orange transition-colors interactive">
                        <i class="ri-facebook-fill"></i>
                    </a>
                </div>
            </div>

            <!-- Shop -->
            <div class="col-span-1">
                <h4 class="font-heading font-semibold text-lg mb-6">Shop</h4>
                <ul class="space-y-4">
                    <li><a href="{{ route('shop') }}"
                            class="text-text-muted hover:text-orange transition-colors text-sm interactive">All
                            Products</a></li>
                    <li><a href="{{ route('home') }}#new-arrivals"
                            class="text-text-muted hover:text-orange transition-colors text-sm interactive">New
                            Arrivals</a></li>
                    <li><a href="{{ route('shop') }}?sort=latest"
                            class="text-text-muted hover:text-orange transition-colors text-sm interactive">Featured</a>
                    </li>
                    <li><a href="{{ route('shop') }}"
                            class="text-text-muted hover:text-orange transition-colors text-sm interactive">Collections</a>
                    </li>
                </ul>
            </div>

            <!-- Support -->
            <div class="col-span-1">
                <h4 class="font-heading font-semibold text-lg mb-6">Support</h4>
                <ul class="space-y-4">
                    <li><a href="{{ route('contact') }}"
                            class="text-text-muted hover:text-orange transition-colors text-sm interactive">Contact
                            Us</a></li>
                    <li><a href="{{ route('about') }}"
                            class="text-text-muted hover:text-orange transition-colors text-sm interactive">FAQ</a></li>
                    <li><a href="{{ route('about') }}"
                            class="text-text-muted hover:text-orange transition-colors text-sm interactive">Shipping</a>
                    </li>
                    <li><a href="{{ route('about') }}"
                            class="text-text-muted hover:text-orange transition-colors text-sm interactive">Returns</a>
                    </li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="col-span-1">
                <h4 class="font-heading font-semibold text-lg mb-6">Newsletter</h4>
                <p class="text-text-muted text-sm mb-4">Subscribe for 10% off your first order and exclusive access to
                    new drops.</p>
                <form class="flex flex-col gap-3">
                    <input type="email" placeholder="Your email address" class="form-control bg-bg text-sm">
                    <button type="button" class="btn btn-primary interactive w-full text-sm">Subscribe</button>
                </form>
            </div>

        </div>

        <div
            class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-text-muted">
            <p>&copy; {{ date('Y') }} Orange E-Commerce. All rights reserved.</p>
            <div class="flex gap-6">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors interactive">Privacy Policy</a>
                <a href="{{ route('home') }}" class="hover:text-white transition-colors interactive">Terms of
                    Service</a>
            </div>
        </div>
    </div>
</footer>
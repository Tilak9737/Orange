@extends('layouts.app')

@section('title', 'Orange | Secure Checkout')

@section('content')
<div class="pt-32 pb-24 min-h-screen bg-bg">
    <div class="container mx-auto px-6 max-w-6xl">
        
        <div class="mb-10 text-center" data-aos="fade-down">
            <h1 class="text-3xl md:text-5xl font-heading font-black mb-4">Secure Checkout</h1>
            <div class="flex items-center justify-center gap-4 text-sm text-text-muted font-medium">
                <span class="text-orange"><i class="ri-shopping-cart-line mr-1"></i> Cart</span>
                <i class="ri-arrow-right-s-line"></i>
                <span class="text-white"><i class="ri-secure-payment-line mr-1"></i> Checkout</span>
                <i class="ri-arrow-right-s-line"></i>
                <span><i class="ri-check-double-line mr-1"></i> Complete</span>
            </div>
        </div>

        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form" class="flex flex-col lg:flex-row gap-12">
            @csrf
            
            <!-- Form Sections -->
            <div class="w-full lg:w-2/3 space-y-8" data-aos="fade-right">
                
                <!-- Contact Info -->
                <div class="glass-panel p-8 rounded-2xl relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full bg-orange"></div>
                    <h2 class="text-2xl font-heading font-bold mb-6 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-orange-glow text-orange flex items-center justify-center text-sm">1</div>
                        Contact Information
                    </h2>
                    
                    @guest
                        <div class="mb-6 p-4 bg-surface-hover border border-gray-800 rounded-xl text-sm flex justify-between items-center">
                            <span>Already have an account?</span>
                            <a href="{{ route('login') }}" class="text-orange hover:underline font-bold interactive">Log in</a>
                        </div>
                    @endguest

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-2 text-text-muted">Email Address</label>
                            <input type="email" name="email" value="{{ Auth::user()->email ?? old('email') }}" required class="form-control" {{ Auth::check() ? 'readonly' : '' }}>
                            @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2 text-text-muted">First Name</label>
                            <input type="text" name="first_name" required class="form-control">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2 text-text-muted">Last Name</label>
                            <input type="text" name="last_name" required class="form-control">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-2 text-text-muted">Phone (Optional)</label>
                            <input type="tel" name="phone" class="form-control">
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="glass-panel p-8 rounded-2xl relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full bg-orange"></div>
                    <h2 class="text-2xl font-heading font-bold mb-6 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-orange-glow text-orange flex items-center justify-center text-sm">2</div>
                        Shipping Address
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-2 text-text-muted">Street Address</label>
                            <input type="text" name="address" required class="form-control">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2 text-text-muted">City</label>
                            <input type="text" name="city" required class="form-control">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2 text-text-muted">State/Province</label>
                            <input type="text" name="state" required class="form-control">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2 text-text-muted">ZIP/Postal Code</label>
                            <input type="text" name="zip" required class="form-control">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2 text-text-muted">Country</label>
                            <select name="country" required class="form-control bg-surface text-white">
                                <option value="US">United States</option>
                                <option value="CA">Canada</option>
                                <option value="GB">United Kingdom</option>
                                <option value="AU">Australia</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Payment Method (Demo) -->
                <div class="glass-panel p-8 rounded-2xl relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full bg-orange"></div>
                    <h2 class="text-2xl font-heading font-bold mb-6 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-orange-glow text-orange flex items-center justify-center text-sm">3</div>
                        Payment Concept
                    </h2>
                    
                    <div class="p-6 border border-orange bg-orange-glow/10 rounded-xl relative overflow-hidden mb-4">
                        <div class="flex items-center gap-4 mb-4">
                            <i class="ri-bank-card-line text-3xl text-orange"></i>
                            <div>
                                <h4 class="font-bold">Test Environment</h4>
                                <p class="text-xs text-text-muted">No real payment will be processed. This is a demonstration flow.</p>
                            </div>
                        </div>
                        <input type="hidden" name="payment_method" value="demo_card">
                    </div>
                </div>

            </div>

            <!-- Order Summary -->
            <div class="w-full lg:w-1/3" data-aos="fade-left">
                <div class="glass-panel p-8 rounded-2xl sticky top-24 border border-gray-800 shadow-2xl">
                    <h2 class="text-2xl font-heading font-bold mb-6 pb-4 border-b border-gray-800">Order Summary</h2>
                    
                    <!-- Items snippet -->
                    <div class="space-y-4 mb-6 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($cart->items as $item)
                        <div class="flex gap-4 items-center">
                            <div class="w-16 h-16 rounded-lg bg-surface flex-shrink-0 relative overflow-hidden">
                                @if(!empty($item->product->images) && count($item->product->images) > 0)
                                    <img src="{{ (\Illuminate\Support\Str::startsWith($item->product->images[0]['path'], ['http://', 'https://']) ? $item->product->images[0]['path'] : Storage::url($item->product->images[0]['path'])) }}" class="w-full h-full object-cover">
                                @else
                                    <i class="ri-image-line text-2xl text-text-muted flex items-center justify-center w-full h-full"></i>
                                @endif
                                <span class="absolute -top-2 -right-2 w-5 h-5 bg-orange text-white text-[10px] rounded-full flex items-center justify-center font-bold z-10">{{ $item->quantity }}</span>
                            </div>
                            <div class="flex-grow">
                                <h4 class="text-sm font-bold line-clamp-1">{{ $item->product->name }}</h4>
                                <span class="text-xs text-text-muted">Qty: {{ $item->quantity }}</span>
                            </div>
                            <div class="font-bold text-sm">
                                ${{ number_format(($item->product->sale_price ?? $item->product->price) * $item->quantity, 2) }}
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="space-y-4 mb-6 pb-6 border-b border-gray-800">
                        <div class="flex justify-between text-text-muted">
                            <span>Subtotal</span>
                            <span class="font-medium text-white">${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-text-muted">
                            <span>Shipping</span>
                            <span class="font-medium text-white">$0.00</span>
                        </div>
                        <div class="flex justify-between text-text-muted">
                            <span>Taxes (Estimated)</span>
                            <span class="font-medium text-white">$0.00</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-end mb-8">
                        <span class="text-lg font-medium">Total</span>
                        <div class="text-right">
                            <span class="text-xs text-text-muted block">USD</span>
                            <span class="text-3xl font-black font-heading text-orange">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <button type="submit" id="submit-btn" class="btn btn-primary w-full text-lg py-4 shadow-orange interactive relative overflow-hidden group">
                        <span class="relative z-10 font-bold group-hover:tracking-wider transition-all">Pay via Demo</span>
                    </button>
                    
                    <div class="mt-4 text-center">
                        <p class="text-[10px] text-text-muted">By clicking complete, you agree to our Terms of Service. This is a demo transaction, no funds will be captured.</p>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: var(--c-surface); }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: var(--c-orange); border-radius: 4px; }
</style>
@endpush

@push('scripts')
<script>
    document.getElementById('checkout-form').addEventListener('submit', function() {
        const btn = document.getElementById('submit-btn');
        btn.innerHTML = '<i class="ri-loader-4-line animate-spin text-2xl"></i> Processing...';
        btn.disabled = true;
        btn.classList.add('opacity-80', 'cursor-not-allowed');
    });
</script>
@endpush

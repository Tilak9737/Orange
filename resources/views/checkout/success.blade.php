@extends('layouts.app')

@section('title', 'Orange | Order Confirmed')

@section('content')
    <div class="pt-32 pb-24 min-h-[80vh] flex items-center justify-center relative overflow-hidden bg-bg">

        <!-- Confetti Container -->
        <div id="confetti-container" class="absolute inset-0 pointer-events-none z-0"></div>

        <div class="container mx-auto px-6 max-w-2xl relative z-10">
            <div class="glass-panel p-10 md:p-16 rounded-3xl text-center shadow-orange relative overflow-hidden"
                data-aos="zoom-in">

                <!-- Radiating Background effect -->
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-20">
                    <div
                        class="w-full aspect-square border-2 border-orange/30 rounded-full animate-[ping_3s_ease-out_infinite]">
                    </div>
                    <div
                        class="absolute w-3/4 aspect-square border-2 border-orange/20 rounded-full animate-[ping_3s_ease-out_infinite_1s]">
                    </div>
                </div>

                <!-- Success Icon -->
                <div
                    class="w-24 h-24 mx-auto bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center text-white mb-8 relative z-10 scale-0 animate-[popIn_0.5s_cubic-bezier(0.175,0.885,0.32,1.275)_forwards_0.5s]">
                    <i class="ri-check-line text-5xl"></i>
                </div>

                <h1 class="text-4xl md:text-5xl font-heading font-black mb-4 relative z-10">Order Confirmed!</h1>

                <p class="text-text-muted mb-8 text-lg relative z-10">
                    Thank you for your purchase. Your order <strong class="text-white">#{{ $order->id }}</strong> has been
                    received and is being processed.
                </p>

                <div class="bg-surface-hover rounded-xl p-6 mb-8 text-left border border-gray-800 relative z-10">
                    <div class="flex justify-between border-b border-gray-800 pb-4 mb-4">
                        <span class="text-text-muted">Status</span>
                        <span class="text-orange font-bold uppercase text-sm tracking-widest"><i
                                class="ri-loader-2-line animate-spin inline-block mr-1 text-xs"></i> Processing</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-800 pb-4 mb-4">
                        <span class="text-text-muted">Total Paid</span>
                        <span class="font-bold text-white text-xl">${{ number_format($order->total, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-text-muted">Items</span>
                        <span class="font-bold text-white">{{ $order->items->sum('quantity') }}</span>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 justify-center relative z-10">
                    <a href="{{ route('orders.index') }}" class="btn btn-outline interactive">Track Order</a>
                    <a href="{{ route('shop') }}" class="btn btn-primary interactive">Continue Shopping</a>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .rounded-3xl {
            border-radius: 1.5rem;
        }

        .aspect-square {
            aspect-ratio: 1 / 1;
        }

        .animate-\[ping_3s_ease-out_infinite\] {
            animation: ping 3s ease-out infinite;
        }

        .animate-\[ping_3s_ease-out_infinite_1s\] {
            animation: ping 3s ease-out infinite 1s;
        }

        @keyframes ping {
            0% {
                transform: scale(0.5);
                opacity: 1;
            }

            100% {
                transform: scale(2);
                opacity: 0;
            }
        }

        .scale-0 {
            transform: scale(0);
        }

        .animate-\[popIn_0\.5s_cubic-bezier\(0\.175\,0\.885\,0\.32\,1\.275\)_forwards_0\.5s\] {
            animation: popIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards 0.5s;
        }

        @keyframes popIn {
            0% {
                transform: scale(0);
            }

            100% {
                transform: scale(1);
            }
        }

        .from-green-400 {
            --tw-gradient-from: #4ade80;
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(74, 222, 128, 0));
        }

        .to-green-600 {
            --tw-gradient-to: #16a34a;
        }

        .text-5xl {
            font-size: 3rem;
            line-height: 1;
        }

        .p-10 {
            padding: 2.5rem;
        }

        @media (min-width: 768px) {
            .md\:p-16 {
                padding: 4rem;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Fire confetti after a short delay to match the checkmark animation
            setTimeout(() => {
                const duration = 3000;
                const end = Date.now() + duration;

                (function frame() {
                    confetti({
                        particleCount: 5,
                        angle: 60,
                        spread: 55,
                        origin: { x: 0 },
                        colors: ['#FF6B00', '#FF9A3C', '#ffffff'] // Orange theme colors
                    });
                    confetti({
                        particleCount: 5,
                        angle: 120,
                        spread: 55,
                        origin: { x: 1 },
                        colors: ['#FF6B00', '#FF9A3C', '#ffffff']
                    });

                    if (Date.now() < end) {
                        requestAnimationFrame(frame);
                    }
                }());
            }, 800);
        });
    </script>
@endpush
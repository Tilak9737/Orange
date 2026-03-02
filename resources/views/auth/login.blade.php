@extends('layouts.app')

@section('title', 'Orange | Login')

@section('content')
    <div class="min-h-screen pt-32 pb-24 flex items-center justify-center bg-bg relative overflow-hidden">

        <!-- Background Elements -->
        <div class="absolute inset-0 pointer-events-none z-0">
            <div
                class="absolute top-1/4 -left-32 w-96 h-96 bg-orange rounded-full mix-blend-screen filter blur-[120px] opacity-20 animate-pulse">
            </div>
            <div
                class="absolute bottom-1/4 -right-32 w-96 h-96 bg-orange rounded-full mix-blend-screen filter blur-[120px] opacity-10">
            </div>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-md mx-auto" data-aos="zoom-in">

                <div class="text-center mb-10">
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-surface border border-gray-800 text-orange text-3xl mb-6 shadow-orange">
                        <i class="ri-fire-fill"></i>
                    </a>
                    <h1 class="text-3xl font-heading font-black mb-2">Welcome Back</h1>
                    <p class="text-text-muted">Enter your details to access your account.</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}"
                    class="glass-panel p-8 rounded-3xl shadow-2xl border border-gray-800">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium mb-2 text-text-muted">Email Address</label>
                        <div class="relative">
                            <i class="ri-mail-line absolute left-4 top-1/2 -translate-y-1/2 text-text-muted"></i>
                            <input id="email" class="form-control pl-12 block w-full" type="email" name="email"
                                :value="old('email')" required autofocus autocomplete="username"
                                placeholder="you@example.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <label for="password" class="block text-sm font-medium text-text-muted">Password</label>
                            @if (Route::has('password.request'))
                                <a class="text-xs text-orange hover:underline font-bold" href="{{ route('password.request') }}">
                                    Forgot Password?
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <i class="ri-lock-password-line absolute left-4 top-1/2 -translate-y-1/2 text-text-muted"></i>
                            <input id="password" class="form-control pl-12 pr-12 block w-full" type="password"
                                name="password" required autocomplete="current-password" placeholder="••••••••">
                            <button type="button" onclick="togglePassword('password', this)"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-text-muted hover:text-white transition-colors">
                                <i class="ri-eye-off-line text-lg"></i>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="block mb-8">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                            <input id="remember_me" type="checkbox" class="hidden peer" name="remember">
                            <div
                                class="w-5 h-5 rounded border border-gray-600 bg-surface peer-checked:bg-orange peer-checked:border-orange flex items-center justify-center transition-colors">
                                <i class="ri-check-line text-white text-xs opacity-0 peer-checked:opacity-100"></i>
                            </div>
                            <span class="ml-3 text-sm text-text-muted group-hover:text-white transition-colors">Remember
                                me</span>
                        </label>
                    </div>

                    <div class="flex flex-col gap-4">
                        <button type="submit"
                            class="btn btn-primary w-full py-4 text-lg shadow-orange interactive group relative overflow-hidden">
                            <span class="relative z-10 font-bold group-hover:tracking-wider transition-all">Sign In</span>
                        </button>

                        <p class="text-center text-sm text-text-muted mt-4">
                            Don't have an account?
                            <a href="{{ route('register') }}"
                                class="text-white hover:text-orange font-bold transition-colors interactive">Sign up for
                                free</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection



@push('scripts')
    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('ri-eye-off-line');
                icon.classList.add('ri-eye-line', 'text-orange');
            } else {
                input.type = 'password';
                icon.classList.remove('ri-eye-line', 'text-orange');
                icon.classList.add('ri-eye-off-line');
            }
        }
    </script>
@endpush
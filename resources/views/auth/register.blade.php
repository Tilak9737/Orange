@extends('layouts.app')

@section('title', 'Orange | Register')

@section('content')
    <div class="min-h-screen pt-32 pb-24 flex items-center justify-center bg-bg relative overflow-hidden">

        <!-- Background Elements -->
        <div class="absolute inset-0 pointer-events-none z-0">
            <div
                class="absolute top-1/4 -right-32 w-96 h-96 bg-orange rounded-full mix-blend-screen filter blur-[120px] opacity-20 animate-pulse">
            </div>
            <div
                class="absolute bottom-1/4 -left-32 w-96 h-96 bg-orange rounded-full mix-blend-screen filter blur-[120px] opacity-10">
            </div>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-md mx-auto" data-aos="zoom-in">

                <div class="text-center mb-10">
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-surface border border-gray-800 text-orange text-3xl mb-6 shadow-orange">
                        <i class="ri-user-add-line"></i>
                    </a>
                    <h1 class="text-3xl font-heading font-black mb-2">Create Account</h1>
                    <p class="text-text-muted">Join us to shop the latest orange collections.</p>
                </div>

                <form method="POST" action="{{ route('register') }}"
                    class="glass-panel p-8 rounded-3xl shadow-2xl border border-gray-800">
                    @csrf

                    <!-- Name -->
                    <div class="mb-5">
                        <label for="name" class="block text-sm font-medium mb-1 text-text-muted">Full Name</label>
                        <div class="relative">
                            <i class="ri-user-line absolute left-4 top-1/2 -translate-y-1/2 text-text-muted"></i>
                            <input id="name" class="form-control pl-12 block w-full" type="text" name="name"
                                :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe">
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mb-5">
                        <label for="email" class="block text-sm font-medium mb-1 text-text-muted">Email Address</label>
                        <div class="relative">
                            <i class="ri-mail-line absolute left-4 top-1/2 -translate-y-1/2 text-text-muted"></i>
                            <input id="email" class="form-control pl-12 block w-full" type="email" name="email"
                                :value="old('email')" required autocomplete="username" placeholder="you@example.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-5">
                        <label for="password" class="block text-sm font-medium mb-1 text-text-muted">Password</label>
                        <div class="relative">
                            <i class="ri-lock-password-line absolute left-4 top-1/2 -translate-y-1/2 text-text-muted"></i>
                            <input id="password" class="form-control pl-12 pr-12 block w-full" type="password"
                                name="password" required autocomplete="new-password" placeholder="••••••••">
                            <button type="button" onclick="togglePassword('password', this)"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-text-muted hover:text-white transition-colors">
                                <i class="ri-eye-off-line text-lg"></i>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-8">
                        <label for="password_confirmation" class="block text-sm font-medium mb-1 text-text-muted">Confirm
                            Password</label>
                        <div class="relative">
                            <i class="ri-lock-password-fill absolute left-4 top-1/2 -translate-y-1/2 text-text-muted"></i>
                            <input id="password_confirmation" class="form-control pl-12 pr-12 block w-full" type="password"
                                name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
                            <button type="button" onclick="togglePassword('password_confirmation', this)"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-text-muted hover:text-white transition-colors">
                                <i class="ri-eye-off-line text-lg"></i>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex flex-col gap-4">
                        <button type="submit"
                            class="btn btn-primary w-full py-4 text-lg shadow-orange interactive group relative overflow-hidden">
                            <span class="relative z-10 font-bold group-hover:tracking-wider transition-all">Create
                                Account</span>
                        </button>

                        <p class="text-center text-sm text-text-muted mt-2">
                            Already have an account?
                            <a href="{{ route('login') }}"
                                class="text-white hover:text-orange font-bold transition-colors interactive">Sign in
                                here</a>
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
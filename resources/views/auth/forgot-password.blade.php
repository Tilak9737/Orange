@extends('layouts.app')

@section('title', 'Orange | Reset Password')

@section('content')
    <div class="min-h-screen pt-32 pb-24 flex items-center justify-center bg-bg relative overflow-hidden">

        <!-- Background Elements -->
        <div class="absolute inset-0 pointer-events-none z-0">
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-orange rounded-full mix-blend-screen filter blur-[150px] opacity-10">
            </div>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-md mx-auto" data-aos="zoom-in">

                <div class="text-center mb-10">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-surface border border-gray-800 text-orange text-3xl mb-6 shadow-orange">
                        <i class="ri-key-2-line"></i>
                    </div>
                    <h1 class="text-3xl font-heading font-black mb-2">Forgot Password?</h1>
                    <p class="text-text-muted text-sm px-4">No problem. Just let us know your email address and we will
                        email you a password reset link that will allow you to choose a new one.</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status
                    class="mb-6 p-4 bg-emerald-400/10 text-emerald-400 border border-emerald-400/20 rounded-xl text-center text-sm font-bold"
                    :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}"
                    class="glass-panel p-8 rounded-3xl shadow-2xl border border-gray-800">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-8">
                        <label for="email" class="block text-sm font-medium mb-2 text-text-muted">Email Address</label>
                        <div class="relative">
                            <i class="ri-mail-line absolute left-4 top-1/2 -translate-y-1/2 text-text-muted"></i>
                            <input id="email" class="form-control pl-12 block w-full" type="email" name="email"
                                :value="old('email')" required autofocus placeholder="you@example.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="flex flex-col gap-4">
                        <button type="submit"
                            class="btn btn-primary w-full py-4 text-lg shadow-orange interactive group relative overflow-hidden">
                            <span class="relative z-10 font-bold group-hover:tracking-wider transition-all">Send Reset
                                Link</span>
                        </button>

                        <a href="{{ route('login') }}" class="btn btn-outline interactive text-center w-full">Back to
                            Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
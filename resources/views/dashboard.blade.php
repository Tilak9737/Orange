@extends('layouts.app')

@section('title', 'Orange | Dashboard')

@section('content')
    <div class="pt-32 pb-24 px-6 max-w-7xl mx-auto">
        <h2 class="text-3xl font-heading font-bold text-white mb-8">
            {{ __('Dashboard') }}
        </h2>

        <div class="glass-panel p-8 border border-gray-800 rounded-2xl">
            <div class="text-white text-lg">
                {{ __("You're logged in!") }}

                <div class="mt-6 flex gap-4">
                    <a href="{{ route('orders.index') }}" class="btn btn-outline interactive">View My Orders</a>
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary interactive">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
@endsection
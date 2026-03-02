@extends('layouts.app')

@section('title', 'Orange | My Profile')

@section('content')
    <div class="pt-32 pb-24 px-6 max-w-7xl mx-auto space-y-6">
        <h2 class="text-3xl font-heading font-bold text-white mb-8">
            {{ __('My Profile') }}
        </h2>

        <div class="glass-panel p-4 sm:p-8 border border-gray-800 rounded-2xl">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="glass-panel p-4 sm:p-8 border border-gray-800 rounded-2xl">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="glass-panel p-4 sm:p-8 border border-gray-800 rounded-2xl">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection
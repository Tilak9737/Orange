<section class="space-y-6">
    <header>
        <h2 class="text-xl font-heading font-bold text-red-500">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-text-muted">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button type="button" class="btn border border-red-500 text-red-500 hover:bg-red-500 hover:text-white interactive"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">{{ __('Delete Account') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}"
            class="p-8 bg-surface border border-gray-800 rounded-2xl">
            @csrf
            @method('delete')

            <h2 class="text-xl font-heading font-bold text-white">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-text-muted">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">{{ __('Password') }}</label>

                <input id="password" name="password" type="password" class="form-control"
                    placeholder="{{ __('Password') }}" />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-red-500" />
            </div>

            <div class="mt-6 flex justify-end gap-4">
                <button type="button" class="btn btn-outline interactive" x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </button>

                <button type="submit"
                    class="btn border border-red-500 bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white interactive">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
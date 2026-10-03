<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto space-y-6 sm:px-6 lg:px-8">
            <section class="p-6 bg-white shadow sm:rounded-lg">
                <header>
                    <h3 class="text-lg font-medium text-gray-900">{{ __('Profile Information') }}</h3>
                    <p class="mt-1 text-sm text-gray-600">{{ __('Update your name and email address.') }}</p>
                </header>

                <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('patch')

                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                        @if (session('status') === 'profile-updated')
                            <p class="text-sm text-gray-600">{{ __('Saved.') }}</p>
                        @endif
                    </div>
                </form>
            </section>

            <section class="p-6 bg-white shadow sm:rounded-lg">
                <header>
                    <h3 class="text-lg font-medium text-gray-900">{{ __('Update Password') }}</h3>
                </header>

                <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('put')
                    <div>
                        <x-input-label for="current_password" :value="__('Current Password')" />
                        <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
                        <x-input-error class="mt-2" :messages="$errors->updatePassword->get('current_password')" />
                    </div>
                    <div>
                        <x-input-label for="password" :value="__('New Password')" />
                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                        <x-input-error class="mt-2" :messages="$errors->updatePassword->get('password')" />
                    </div>
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                    </div>
                    <x-primary-button>{{ __('Save Password') }}</x-primary-button>
                </form>
            </section>

            <section class="p-6 bg-white shadow sm:rounded-lg">
                <header>
                    <h3 class="text-lg font-medium text-red-700">{{ __('Delete Account') }}</h3>
                    <p class="mt-1 text-sm text-gray-600">{{ __('This action cannot be undone.') }}</p>
                </header>

                <form method="post" action="{{ route('profile.destroy') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('delete')
                    <div>
                        <x-input-label for="delete_password" :value="__('Current Password')" />
                        <x-text-input id="delete_password" name="password" type="password" class="mt-1 block w-full" required autocomplete="current-password" />
                        <x-input-error class="mt-2" :messages="$errors->userDeletion->get('password')" />
                    </div>
                    <x-danger-button>{{ __('Delete Account') }}</x-danger-button>
                </form>
            </section>
        </div>
    </div>
</x-app-layout>

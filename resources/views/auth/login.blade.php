<x-guest-layout>

<div class="min-h-screen flex flex-col lg:flex-row">

    {{-- LEFT PANEL --}}
    <div class="lg:w-1/2 w-full bg-blue-900 text-white flex flex-col items-center justify-center p-10">

        <img src="{{ asset('storage/images/ieee_pusb.jpg') }}"
             alt="IEEE PUSB"
             class="w-32 sm:w-40 md:w-48 lg:w-56 xl:w-64 mb-8">

        <h1 class="text-3xl md:text-4xl font-bold text-center">
            IEEE PUSB Student Branch
        </h1>

        <p class="mt-5 text-center max-w-md text-gray-200 text-base md:text-lg">
            Welcome to the IEEE PUSB Administration Panel.
        </p>

    </div>

    {{-- RIGHT PANEL --}}
    <div class="lg:w-1/2 w-full flex items-center justify-center bg-gray-100 py-10 px-5">

        <div class="w-full max-w-lg bg-white rounded-2xl shadow-2xl p-6 sm:p-8 md:p-10">

            <div class="text-center mb-8">

                <h2 class="text-3xl font-bold">
                    Welcome Back
                </h2>

                <p class="text-gray-500 mt-2">
                    Login to continue
                </p>

            </div>

            <x-auth-session-status
                class="mb-4"
                :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div>
                    <x-input-label
                        for="email"
                        :value="__('Email')" />

                    <x-text-input
                        id="email"
                        class="block mt-1 w-full"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username" />

                    <x-input-error
                        :messages="$errors->get('email')"
                        class="mt-2" />
                </div>

                {{-- Password --}}
                <div class="mt-5">

                    <x-input-label
                        for="password"
                        :value="__('Password')" />

                    <x-text-input
                        id="password"
                        class="block mt-1 w-full"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password" />

                    <x-input-error
                        :messages="$errors->get('password')"
                        class="mt-2" />

                </div>

                {{-- Remember --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mt-5 gap-3">

                    <label class="inline-flex items-center">

                        <input
                            id="remember_me"
                            type="checkbox"
                            class="rounded border-gray-300"
                            name="remember">

                        <span class="ml-2 text-sm">
                            Remember me
                        </span>

                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-sm text-blue-600 hover:underline">
                            Forgot Password?
                        </a>
                    @endif

                </div>

                <div class="mt-8">

                    <x-primary-button class="w-full justify-center py-3 text-base">
                        Log in
                    </x-primary-button>

                </div>

            </form>

        </div>

    </div>

</div>

</x-guest-layout>
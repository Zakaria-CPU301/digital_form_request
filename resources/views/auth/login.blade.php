<x-guest-layout>
    <div 
        class="min-h-screen flex items-center justify-center bg-cover bg-center"
        style="background-image: url('{{ asset('img/bg.webp') }}');"
    >
        <div class="bg-white rounded-3xl p-8 max-w-md w-[900px] shadow-lg text-center">
            <!-- Logo -->
            <img 
                src="{{ asset('img/logo.png') }}" 
                alt="Logo" 
                class="mx-auto mb-4 w-[150px] invert-0 brightness-0 saturate-100 hue-rotate-[200deg]" 
                style="width: 150px;"
            />

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="text-left mb-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input 
                        id="email" 
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        required 
                        autofocus 
                        autocorrect="off"
                        class="block mt-1 w-full rounded-lg bg-gray-200 px-4 py-2" 
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="text-left mb-6">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input 
                        id="password" 
                        type="password" 
                        name="password" 
                        required
                        class="block mt-1 w-full rounded-lg bg-gray-200 px-4 py-2"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mb-6 text-left">
                    <label for="remember_me" class="inline-flex items-center">
                        <input 
                            id="remember_me" 
                            type="checkbox" 
                            name="remember"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" 
                        >
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end">
                    @if (Route::has('password.request'))
                        <a 
                            href="{{ route('password.request') }}"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-primary-button class="ms-3 px-6 py-2 bg-indigo-900 hover:bg-indigo-800">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

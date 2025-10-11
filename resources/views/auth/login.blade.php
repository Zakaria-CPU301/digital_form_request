<x-guest-layout>
    <div
        class="min-h-screen flex items-center justify-center bg-cover bg-center"
        style="background-image: url('{{ asset('img/bg.webp') }}');"
    >
        @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
        @endif
        <div
            class="bg-white rounded-3xl p-8 max-w-md w-[900px] shadow-lg text-center"
        >
            <!-- Logo -->
            <img
                src="{{ asset('img/sangnila_blue.webp') }}"
                alt="Logo"
                class="mx-auto mb-4 w-[150px]"
                style="width: 150px"
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
                    <x-input-error
                        :messages="$errors->get('email')"
                        class="mt-2"
                    />
                </div>

                <!-- Password (replace your current password block with this) -->
                <div class="text-left mb-6">
                    <x-input-label for="password" :value="__('Password')" />
                    <div class="relative">
                        <!-- ensure pr-12 so the icon doesn't overlap the text -->
                        <x-text-input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            class="block mt-1 w-full rounded-lg bg-gray-200 px-4 py-2 pr-12"
                        />
                        <!-- toggle button (absolute inside the input container) -->
                        <button
                            type="button"
                            id="togglePassword"
                            aria-label="Show password"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-600 hover:text-gray-800 focus:outline-none"
                        >
                            <!-- eye SVG initial (will be swapped by JS when clicked) -->
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z"
                                />
                            </svg>
                        </button>
                    </div>
                    <x-input-error
                        :messages="$errors->get('password')"
                        class="mt-2"
                    />
                </div>

                <!-- Remember Me -->
                <div class="block mb-6 text-left">
                    <label for="remember_me" class="inline-flex items-center">
                        <input
                            id="remember_me"
                            type="checkbox"
                            name="remember"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        />
                        <span class="ms-2 text-sm text-gray-600"
                            >{{ __('Remember me') }}</span
                        >
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

                    <x-primary-button
                        class="ms-3 px-6 py-2 bg-indigo-900 hover:bg-indigo-800"
                    >
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>

            <!-- Put this script AFTER the form (before closing body) or in a js file included after DOM loads -->
            <script>
                (function () {
                    function initPasswordToggle() {
                        const toggle =
                            document.getElementById("togglePassword");
                        const input = document.getElementById("password");
                        if (!toggle || !input) return;

                        const eyeSVG =
                            '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z"/></svg>';
                        const eyeOffSVG =
                            '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18"/><path stroke-linecap="round" stroke-linejoin="round" d="M10.477 10.477A3 3 0 0113.523 13.523"/><path stroke-linecap="round" stroke-linejoin="round" d="M6.88 6.88C8.155 6.47 9.571 6.29 11 6.29c4.477 0 8.268 2.943 9.542 7-0.34 1.082-0.9 2.07-1.642 2.923M3.17 8.53A9.953 9.953 0 002.458 12c1.274 4.057 5.065 7 9.542 7 1.429 0 2.845-.18 4.121-.59"/></svg>';

                        toggle.innerHTML = eyeSVG;

                        toggle.addEventListener("click", function (e) {
                            e.preventDefault();
                            const isHidden = input.type === "password";
                            input.type = isHidden ? "text" : "password";
                            toggle.innerHTML = isHidden ? eyeOffSVG : eyeSVG;
                            toggle.setAttribute(
                                "aria-label",
                                isHidden ? "Hide password" : "Show password"
                            );
                            input.focus({ preventScroll: true });
                        });

                        const observer = new MutationObserver(() => {
                            if (input.type === "password")
                                toggle.innerHTML = eyeSVG;
                            else toggle.innerHTML = eyeOffSVG;
                        });
                        observer.observe(input, {
                            attributes: true,
                            attributeFilter: ["type"],
                        });
                    }

                    if (document.readyState === "loading") {
                        document.addEventListener(
                            "DOMContentLoaded",
                            initPasswordToggle
                        );
                    } else {
                        initPasswordToggle();
                    }
                })();
            </script>
        </div>
    </div>
</x-guest-layout>

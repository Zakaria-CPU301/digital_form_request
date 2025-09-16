<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Logout') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Click the button below to log out of your account securely.') }}
        </p>
    </header>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <x-danger-button>
            {{ __('Logout') }}
        </x-danger-button>
    </form>
</section>

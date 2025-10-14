<div class="flex bg-white w-full h-[60px] sticky z-50 top-0 justify-between items-center">
    <div class="flex items-center space-x-4">
        <img 
        src="{{ asset('img/logo.png') }}" 
        alt="Logo" 
        class="h-[50px] ml-3 invert-0 brightness-0 saturate-100 hue-rotate-[200deg]" 
        />
        <div class="bg-[#042E66] w-[3px] h-12"></div>
        <h1 class="text-xl text-[#042E66] uppercase">Digital Leave & Overwork Form</h1>
    </div>
    <div class="flex items-center mr-4">
        <x-dropdown>
            <x-slot name="trigger">
                <button class="p-2 rounded-md hover:bg-gray-100 focus:outline-none">
                    <svg width="33" height="20" viewBox="0 0 33 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="33" height="6" rx="2" fill="#042E66"/>
                        <rect y="10" width="33" height="6" rx="2" fill="#042E66"/>
                        <rect y="20" width="33" height="6" rx="2" fill="#042E66"/>
                    </svg>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link href="{{ route('profile.edit') }}">
                    <i class="bi bi-person"></i> {{ __('Profile') }}
                </x-dropdown-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link class="text-red-500" onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="bi bi-box-arrow-right"></i> {{ __('Logout') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</div>
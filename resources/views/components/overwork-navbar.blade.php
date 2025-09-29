<div
    class="bg-[#1EB8CD] px-8 ml-72 transition-all duration-300 ease-in-out flex justify-between items-center"
    :class="sidebarOpen ? 'ml-0' : 'ml-[-0px]'"
>
    <!-- Left: My Overwork Title -->
    <h1 class="text-white text-2xl font-bold">
        {{ auth()->user()->name . ("'s") . (' Overwork')}}
    </h1>

    <!-- Right: Navigation Menu -->
    <div class="flex">
        <a href="{{ route('overwork.data') }}"
           class="px-5 py-5 font-semibold text-white {{ request()->routeIs('overwork.data') ? 'bg-[#0E7490]' : 'hover:bg-gradient-to-r hover:from-[#1EB8CD] hover:to-[#1EB8CD]/10' }} transition">
            Submitted
        </a>
        <a href="{{ route('overwork.accepted') }}"
           class="px-5 py-5 font-semibold text-white {{ request()->routeIs('overwork.accepted') ? 'bg-[#0E7490]' : 'hover:bg-gradient-to-r hover:from-[#1EB8CD] hover:to-[#1EB8CD]/10' }} transition">
            Accepted
        </a>
        <a href="{{ route('overwork.pending') }}"
           class="px-5 py-5 font-semibold text-white {{ request()->routeIs('overwork.pending') ? 'bg-[#0E7490]' : 'hover:bg-gradient-to-r hover:from-[#1EB8CD] hover:to-[#1EB8CD]/10' }} transition">
            Pending
        </a>
        <a href="{{ route('overwork.draft') }}"
           class="px-5 py-5 font-semibold text-white {{ request()->routeIs('overwork.draft') ? 'bg-[#0E7490]' : 'hover:bg-gradient-to-r hover:from-[#1EB8CD] hover:to-[#1EB8CD]/10' }} transition">
            Draft
        </a>
    </div>
</div>

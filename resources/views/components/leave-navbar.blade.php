<div
    class="bg-[#1EB8CD] px-8    ml-72   transition-all duration-300 ease-in-out flex justify-between items-center"
    :class="sidebarOpen ? 'ml-0' : 'ml-[-0px]'"
>
    <!-- Left: My Leave Title -->
    <h1 class="text-white text-2xl font-bold">
        {{ auth()->user()->name . ("'s") . (' Leave')}}
    </h1>

    <!-- Right: Navigation Menu -->
    <div class="flex">
        <a href="{{ route('leave.data') }}"
           class="px-5 py-5 font-semibold text-white {{ request()->routeIs('leave.data') ? 'bg-[#0E7490]' : 'hover:bg-gradient-to-r hover:from-[#1EB8CD] hover:to-[#1EB8CD]/10' }} transition">
            Submitted
        </a>
        <a href="{{ route('leave.accepted') }}"
           class="px-5 py-5 font-semibold text-white {{ request()->routeIs('leave.accepted') ? 'bg-[#0E7490]' : 'hover:bg-gradient-to-r hover:from-[#1EB8CD] hover:to-[#1EB8CD]/10' }} transition">
            Accepted
        </a>
        <a href="{{ route('leave.pending') }}"
           class="px-5 py-5 font-semibold text-white {{ request()->routeIs('leave.pending') ? 'bg-[#0E7490]' : 'hover:bg-gradient-to-r hover:from-[#1EB8CD] hover:to-[#1EB8CD]/10' }} transition">
            Pending
        </a>
        <a href="{{ route('leave.rejected') }}"
            class="px-5 py-5 font-semibold text-white {{ request()->routeIs('leave.rejected') ? 'bg-[#0E7490]' : 'hover:bg-gradient-to-r hover:from-[#1EB8CD] hover:to-[#1EB8CD]/10' }} transition">
            Rejected
        </a>    
        @if (auth()->user()->role === 'user')
            <a href="{{ route('leave.draft') }}"
            class="px-5 py-5 font-semibold text-white {{ request()->routeIs('leave.draft') ? 'bg-[#0E7490]' : 'hover:bg-gradient-to-r hover:from-[#1EB8CD] hover:to-[#1EB8CD]/10' }} transition">
                Draft
            </a>
        @endif
    </div>
</div>

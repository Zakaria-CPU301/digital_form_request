<div
    class="bg-[#1EB8CD] px-8 py-5     ml-72   transition-all duration-300 ease-in-out flex justify-between items-center"
    :class="sidebarOpen ? 'ml-0' : 'ml-[-0px]'"
>
    <!-- Left: My Leave Title -->
    <h1 class="text-white text-2xl font-bold">
        {{ auth()->user()->name . ("'s") . (' Leave')}}
    </h1>

    <!-- Right: Navigation Menu -->
    <div class="flex gap-5">
        <a href="{{ route('leave.accepted') }}"
           class="px-5 rounded-md font-semibold text-white hover:bg-gradient-to-r hover:from-[#1EB8CD] hover:to-[#1EB8CD]/10 transition">
            Accepted
        </a>
        <a href="{{ route('leave.pending') }}"
           class="px-5 rounded-md font-semibold text-white hover:bg-gradient-to-r hover:from-[#1EB8CD] hover:to-[#1EB8CD]/10 transition">
            Pending
        </a>
        <a href="{{ route('leave.draft') }}"
           class="px-5 rounded-md font-semibold text-white hover:bg-gradient-to-r hover:from-[#1EB8CD] hover:to-[#1EB8CD]/10 transition">
            Draft
        </a>
    </div>
</div>

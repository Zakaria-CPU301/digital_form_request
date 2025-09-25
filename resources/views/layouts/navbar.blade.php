<div 
    class="bg-gradient-to-r from-[#1EB8CD] to-[#E7EDF5] px-8 py-5 ml-72 transition-all duration-300 ease-in-out flex items-center"
    :class="sidebarOpen ? 'ml-0' : 'ml-[-0px]'"
>
    <!-- Left: Greeting -->
    <h1 class="text-white text-2xl font-bold">
        {{ __('Hi ') . auth()->user()->name }}!
    </h1>
</div>

<div
    class="bg-[#1EB8CD] px-8 py-4 ml-72 transition-all duration-300 ease-in-out flex justify-between items-center"
    :class="sidebarOpen ? 'ml-0' : 'ml-[-0px]'"
>
    <h1 class="text-white text-2xl font-bold">
        {{ __(' Leave') }}
    </h1>

    <div class="flex space-x-2">
        @php
            $navLinks = [
                ['label' => 'Submitted', 'route' => 'leave.submitted'],
                ['label' => 'Approved', 'route' => 'leave.approved'],
                ['label' => 'Pending', 'route' => 'leave.review'],
                ['label' => 'Rejected', 'route' => 'leave.rejected'],
            ];

            if (auth()->user()->role === 'user') {
                $navLinks[] = ['label' => 'Draft', 'route' => 'leave.draft'];
            }
        @endphp

        @foreach ($navLinks as $link)
            <a href="{{ route($link['route']) }}"
               class="px-4 py-2 font-medium rounded-full transition duration-300 backdrop-blur-sm
                   {{ request()->routeIs($link['route'])
                        ? 'bg-white text-[#1EB8CD] shadow-sm shadow-gray-300'
                        : 'text-white hover:bg-white/10 hover:shadow-md' }}
               ">
                {{ $link['label'] }}
            </a>
        @endforeach
    </div>
</div>

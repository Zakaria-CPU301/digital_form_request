<div
    class="bg-[#1EB8CD] px-8 py-4 ml-72 transition-all duration-300 ease-in-out flex justify-between items-center"
    :class="sidebarOpen ? 'ml-0' : 'ml-[-0px]'"
>
    <h1 class="text-white text-2xl font-bold">
        {{ __(' Leave') }}
    </h1>

    <div class="flex space-x-2">
        @php
            $type = request()->segment(1);
            $navStatus = [
                'all' => 'all',
                'review' => 'review',
                'approved' => 'approved',
                'rejected' => 'rejected',
            ];
            if (auth()->user()->role === 'user') {
                $navStatus += [
                    'draft' => 'draft',
                ];
            }
        @endphp
        <form action="{{route($type . '.show')}}" method="get">
            <input type="hidden" class="buttonSubmit" name="status" value="{{request('status', 'all')}}">
            <input type="hidden" id="monthHidden" name="month" value="{{request('month') ?? 'all'}}">
            <input type="hidden" id="searchHidden" name="search" value="{{request('search') ?? ''}}">
            @foreach ($navStatus as $status)
                <button type="button" value="{{$status}}" class="status-btn px-4 py-2 font-medium rounded-full transition duration-300 backdrop-blur-sm
                {{ request('status', 'all') === $status
                        ? 'bg-white text-[#1EB8CD] shadow-sm shadow-gray-300'
                        : 'text-white hover:bg-white/10 hover:shadow-md' }}
                ">
                    {{ ucfirst($status) }}
                </button>
            @endforeach
        </form>
    </div>
</div>

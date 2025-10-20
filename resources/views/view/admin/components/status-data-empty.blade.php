<div class="flex flex-col items-center">
    @php
        $statusData = request('status', 'review');
    @endphp
    @if ($statusData === 'approved')
        <svg class="w-12 h-12 text-green-500 mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    @elseif ($statusData === 'rejected')
        <svg class="w-12 h-12 text-red-500 mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 9l-6 6m0-6l6 6m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    @elseif ($statusData === 'review')
        <svg class="w-12 h-12 text-yellow-400 mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    @else
        <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 10h6M9 14h4" />
        </svg>
    @endif

    <p class="capitalize text-gray-500">No {{$statusData != 'all' ? $statusData : ''}} data found</p>
</div>
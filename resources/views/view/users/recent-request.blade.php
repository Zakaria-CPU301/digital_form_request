@extends('layouts.tables')

@section('content')

<div class="container-draft bg-[#F0F3F8] p-6 rounded-lg w-full max-w-6xl shadow-lg">
    @php
        $activeToggle = request('type', 'all');
    @endphp
    <h2 class="text-2xl font-bold text-[#012967] mb-4">Recent Request</h2>

    <div id="filter" class="flex items-center mb-6">
        {{-- Tabs --}}
        <form id="type" action="{{route('recent', ['type' => $activeToggle])}}" method="get">
            @include('components.filter-data-toggle')
        </form>

        {{-- Search --}}
        <div class="ml-auto">
            <input 
                type="search" 
                id="search" 
                name="search" 
                placeholder="Search..." 
                class="border border-gray-300 rounded-full px-4 py-1 focus:outline-none focus:ring-2 focus:ring-cyan-400" 
            />
        </div>
    </div>

    <!-- Recent Table -->
    <table class="min-w-full text-left justify-center border-b border-gray-300 mr-10">
        <thead class="bg-transparent text-[#1e293b] border-b border-gray-300">
            <tr>
                <th class="py-3 px-6 font-semibold">No</th>
                <th class="py-3 px-6 font-semibold">Date</th>
                <th class="py-3 px-6 font-semibold">Type</th>
                <th class="py-3 px-6 font-semibold">Reason</th>
                <th class="py-3 px-6 font-semibold">Data Detail</th>
                <th class="py-3 px-6 font-semibold">Status</th>
                <th class="py-3 px-6 font-semibold text-center">Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach($data as $r)
            <tr class="{{ $loop->odd ? 'bg-white' : 'bg-[#f1f5f9]' }} border-b border-gray-300">
                <td class="py-4 px-6">
                    {{ $r->date ?? $loop->iteration }}
                </td>
                <td class="py-4 px-6">
                    {{ $r->date ?? $r->created_at->format('d - m - Y') }}
                </td>
                <td class="py-4 px-6 font-semibold">
                    {{ $r->type }}
                </td>
                <td class="py-4 px-6" title="{{ $r->reason ?? $r->task_description }}">
                    {{ Str::limit($r->reason ?? $r->task_description, 35) }}
                </td>
                <td class="py-4 px-6 font-semibold">
                    {{ $r->data_detail ?? '3 Data' }}
                </td>
                <td class="py-4 px-6">
                    @php
                        $statusClass = match($r->request_status) {
                            'Approved' => 'bg-cyan-400 text-white rounded-full px-3 py-1 text-sm font-semibold',
                            'Under Review' => 'bg-gray-400 text-white rounded-full px-3 py-1 text-sm font-semibold',
                            'Rejected' => 'bg-red-500 text-white rounded-full px-3 py-1 text-sm font-semibold',
                            default => 'bg-gray-300 text-gray-700 rounded-full px-3 py-1 text-sm font-semibold',
                        };
                    @endphp
                    <span class="{{ $statusClass }}">{{ $r->request_status }}</span>
                </td>
                <td class="py-4 px-6 text-center">
                    <button 
                        class="text-gray-500 hover:text-gray-700" 
                        title="Show Details"
                    >
                        <svg 
                            xmlns="http://www.w3.org/2000/svg" 
                            class="inline h-6 w-6" 
                            fill="none" 
                            viewBox="0 0 24 24" 
                            stroke="currentColor"
                        >
                            <path 
                                stroke-linecap="round" 
                                stroke-linejoin="round" 
                                stroke-width="2" 
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" 
                            />
                            <path 
                                stroke-linecap="round" 
                                stroke-linejoin="round" 
                                stroke-width="2" 
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 
                                   8.268 2.943 9.542 7-1.274 4.057-5.065 
                                   7-9.542 7-4.477 0-8.268-2.943-9.542-7z" 
                            />
                        </svg>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

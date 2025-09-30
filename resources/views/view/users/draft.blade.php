@extends('layouts.tables')

@section('content')
<div class="container-draft bg-[#F0F3F8] p-6 rounded-lg w-full max-w-6xl shadow-lg">
    <h2 class="text-2xl font-bold text-[#012967] mb-4">Draft Request</h2>

    <div id="filter" class="flex items-center mb-6">
        @php
            $activeToggle = request('type', 'all');
        @endphp
        {{-- Tabs --}}
        <form id="type" action="{{route('draft', ['type' => $activeToggle])}}" method="get">
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

    <table class="min-w-full text-left justify-center border-b border-gray-300 mr-10">
        <thead class="bg-transparent text-[#1e293b] border-b border-gray-300">
            <tr>
                <th class="py-3 px-6 font-semibold">No</th>
                <th class="py-3 px-6 font-semibold">Date</th>
                <th class="py-3 px-6 font-semibold">Type</th>
                <th class="py-3 px-6 font-semibold">Task Description</th>
                @if (auth()->user()->role === 'admin')
                    <th class="py-3 px-6 font-semibold">
                            Name
                    </th>
                @endif
                    <th class="py-3 px-6 font-semibold">Duration</th>
                <th class="py-3 px-6 font-semibold">Evidance</th>
                <th class="py-3 px-6 font-semibold text-center">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($data as $d)
            <tr class="{{ $loop->odd ? 'bg-white' : 'bg-[#f1f5f9]' }} border-b border-gray-300 items-center justify-center">
                <td class="py-4 px-6">
                    {{ $loop->iteration }}
                </td>

                <td class="py-4 px-6">
                    {{ $d->date ?? $d->created_at->format('d - m - Y') }}
                </td>
                
                <td class="py-4 px-6">
                    {{ $d->type }}
                </td>

                <td class="py-4 px-6" title="{{ $d->task_description }}">
                    {{ ucfirst(strtolower(Str::limit($d->task_description ?? $d->reason, 25))) }}
                </td>

                @if (auth()->user()->role === 'admin')
                    <td class="py-4 px-6 font-semibold">
                        {{ Str::words($d->user->name, 2) ?? 'N/A' }}
                    </td>
                @endif

                <td class="py-4 px-6 font-semibold capitalize">
                    @php
                    if ($d->type === 'leave') {
                        $duration = \Carbon\Carbon::parse($d->start_leave)->diff(\Carbon\Carbon::parse($d->finished_leave));
                        echo $duration->format('%d days');
                    } else {
                        $duration = \Carbon\Carbon::parse($d->start_overwork)->diff(\Carbon\Carbon::parse($d->finished_overwork));
                        echo $duration->format('%h hours');
                    }
                    @endphp
                </td>

                <td class="py-4 px-6 font-semibold flex-col">
                    @if (isset($d->evidance) && $d->evidance->isNotEmpty())
                        @foreach ($d->evidance as $e)
                            <div class="flex">
                                @if (in_array(pathinfo($e->path, PATHINFO_EXTENSION), ['jpg', 'png', 'jpeg', 'webp']))
                                    <img src="{{ asset('storage/' . $e->path) }}" alt="evidance-image" width="50" class="inline-block mr-2 mb-2">
                                @elseif (in_array(pathinfo($e->path, PATHINFO_EXTENSION), ['mp4', 'mov', 'avi']))
                                    <video autoplay loop muted src="{{ asset('storage/' . $e->path) }}" alt="evidance-video" width="50" class="inline-block mr-2 mb-2"></video>
                                @else
                                    <a href="{{ asset('storage/' . $e->path) }}" target="_blank" class="text-blue-500 hover:underline">
                                        {{ basename($e->path) }}
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    @else
                        {{__('N/A')}}
                    @endif
                </td>

                <td class="py-4 px-6 text-center">
                    <button
                        class="eye-preview-btn border-2 border-gray-500 text-gray-600 rounded px-2 hover:bg-gray-100"
                        title="Show Details"
                        data-date="{{ $d->date ?? $d->created_at->format('d - m - Y') }}"
                        data-description="{{ $d->task_description }}"
                        data-duration="{{ $d->duration ?? 'N/A' }}"
                        data-status="{{ $d->request_status }}"
                    >
                        <i class="bi bi-eye"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="py-8 px-6 text-center text-gray-500">
                    <div class="flex flex-col items-center">
                        <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                            <path d="M12 6v12M6 12h12" />
                        </svg>
                        <p>No overwork data found</p>
                        <a href="{{ route('overwork.form-view') }}" class="text-[#1EB8CD] hover:underline mt-2">
                            Create your first overwork request
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

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
                <th class="py-3 px-6 font-semibold">Task Description</th>
                @if (auth()->user()->role === 'admin')
                    <th class="py-3 px-6 font-semibold">
                            Name
                    </th>
                @endif
                <th class="py-3 px-6 font-semibold">Duration</th>
                <th class="py-3 px-6 font-semibold">Type</th>
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
                    {{ Carbon\Carbon::parse($d->created_at)->format('h - F -Y') }}
                </td>

                <td class="py-4 px-6" title="{{ $d->task_description ?? $d->reason }}">
                    {{ ucfirst(strtolower(Str::limit($d->task_description ?? $d->reason, 25))) }}
                </td>

                @if (auth()->user()->role === 'admin')
                    <td class="py-4 px-6">
                        {{ Str::words($d->user->name, 2) ?? 'N/A' }}
                    </td>
                @endif

                <td class="py-4 px-6">
                    @php
                        $duration = \Carbon\Carbon::parse($d->start_overwork)->diff(\Carbon\Carbon::parse($d->finished_overwork));
                        @endphp
                    @if ($duration->format('%i') == '0')
                        {{ $duration->format('%h hours') }}
                    @else
                        {{ $duration->format('%h hours %i minutes') }}
                    @endif
                </td>
                
                <td class="py-4 px-6">
                    {{ $d->type }}
                </td>

                {{-- <td class="py-4 px-6">
                    @php
                        $totalEvidance = $d->evidance->count();
                        $firstImage = $d->evidance->first(fn($e) => in_array(strtolower(pathinfo($e->path, PATHINFO_EXTENSION)), ['jpg', 'png', 'jpeg', 'webp']));
                        $firstVideo = $d->evidance->first(fn($e) => in_array(strtolower(pathinfo($e->path, PATHINFO_EXTENSION)), ['mp4', 'mov', 'avi']));
                    @endphp
                    @if($totalEvidance > 0)
                    <span class="text-xs bg-blue-100 text-blue-600 px-2 py-2 rounded-full flex">
                        <svg class="w-3 h-3 mr-1 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $totalEvidance }} Media
                    </span>
                    @else
                        <span class="text-gray-500 text-sm">No evidence</span>
                    @endif
                </td> --}}

                <td class="py-4 px-6 text-center">
                    {{$d->user->name}}
                </td>

                <td class="py-4 px-6 text-center">
                    <div class="flex space-x-2">
                        <button
                            class="eye-preview-btn border-2 border-gray-500 text-gray-600 rounded px-2 hover:bg-gray-100"
                            title="Show Details"
                            data-date="{{ Carbon\Carbon::parse($d->created_at)->format('h - F - Y') }}"
                            data-description="{{ $d->task_description }}"
                            data-duration="{{ $d->duration ?? 'N/A' }}"
                            data-status="{{ $d->request_status }}"
                        >
                            <i class="bi bi-eye"></i>
                        </button>
                        <a
                            href="{{ route('overwork.edit', $d->id) }}"
                            class="border-2 border-gray-500 text-gray-600 rounded px-2 hover:bg-gray-100 inline-block"
                            title="Edit"
                        >
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{ route('overwork.delete', $d->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this overwork draft?')">
                            @csrf
                            @method('DELETE')
                            <button
                            type="submit"
                            class="border-2 border-gray-500 text-gray-600 rounded px-2 hover:bg-gray-100"
                            title="Delete"
                            >
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
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

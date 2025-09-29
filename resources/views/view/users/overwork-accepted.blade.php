@extends('layouts.overwork')

@section('content')

<div class="container-draft bg-[#F0F3F8] p-6 rounded-lg w-full max-w-[1400px] shadow-lg">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-[#012967]">Overwork Data</h2>
        <div class="mb-6">
        <input 
            type="search" 
            id="search" 
            name="search" 
            placeholder="Search overwork data..." 
            class="border border-gray-300 rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-400 w-full max-w-md" 
        />
    </div>
    </div>

            <!-- New Data Button -->
    @if (auth()->user()->role === 'user')
        <a href="{{ route('overwork.form-view') }}" 
            class="bg-gradient-to-r from-[#1EB8CD] to-[#2652B8] hover:from-cyan-600 hover:to-blue-800 text-white font-semibold py-2 px-2 rounded-lg transition duration-300 flex items-center space-x-2 w-[130px]">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M12 6v12M6 12h12" />
            </svg>
            <span>New Data</span>
        </a>
    @endif

    <!-- Overwork Table -->
    <table class="min-w-full text-left justify-center border-b border-gray-300 mr-10">
        <thead class="bg-transparent text-[#1e293b] border-b border-gray-300">
            <tr>
                <th class="py-3 px-6 font-semibold">No</th>
                <th class="py-3 px-6 font-semibold">Date</th>
                <th class="py-3 px-6 font-semibold">Task Description</th>
                <th class="py-3 px-6 font-semibold">
                    @if (auth()->user()->role === 'admin')
                        Name
                    @else
                        Duration
                    @endif
                </th>
                <th class="py-3 px-6 font-semibold">Evidance</th>
                <th class="py-3 px-6 font-semibold">Status</th>
                <th class="py-3 px-6 font-semibold text-center">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($data as $r)
            <tr class="{{ $loop->odd ? 'bg-white' : 'bg-[#f1f5f9]' }} border-b border-gray-300 items-center justify-center">
                <td class="py-4 px-6">
                    {{ $loop->iteration }}
                </td>

                <td class="py-4 px-6">
                    {{ $r->date ?? $r->created_at->format('d - m - Y') }}
                </td>

                <td class="py-4 px-6" title="{{ $r->task_description }}">
                    {{ Str::limit($r->task_description, 25) }}
                </td>

                @if (auth()->user()->role === 'admin')
                    <td class="py-4 px-6 font-semibold">
                        {{ Str::words($r->user->name, 2) ?? 'N/A' }}
                    </td>
                @endif

                <td class="py-4 px-6 font-semibold">
                    @php
                        $duration = \Carbon\Carbon::parse($r->start_overwork)->diff(\Carbon\Carbon::parse($r->finished_overwork));
                        echo $duration->format('%h hours %i minutes');
                    @endphp
                </td>

                <td class="py-4 px-6 font-semibold flex-col">
                    @foreach ($r->evidance as $e)
                        @if (pathinfo($e->path, PATHINFO_EXTENSION) === 'jpg' || pathinfo($e->path, PATHINFO_EXTENSION) === 'png' || pathinfo($e->path, PATHINFO_EXTENSION) === 'jpeg' || pathinfo($e->path, PATHINFO_EXTENSION) === 'webp')
                            <div class="flex">
                                <img src="{{asset('storage/' . $e->path)}}" alt="" width="50" class="inline-block mr-2 mb-2">
                            </div>
                        @endif
                    @endforeach
                    @foreach ($r->evidance as $e)
                        <div class="flex">
                            @if (pathinfo($e->path, PATHINFO_EXTENSION) === 'mp4' || pathinfo($e->path, PATHINFO_EXTENSION) === 'mov' || pathinfo($e->path, PATHINFO_EXTENSION) === 'avi')
                                <video autoplay loop muted src="{{asset('storage/' . $e->path)}}" alt="evidance-image" width="50" class="inline-block mr-2 mb-2"></video>
                            @endif
                        </div>
                    @endforeach
                </td>

                <td class="py-4 px-6">
                    @php
                        $statusClass = match($r->request_status) {
                            'accepted' => 'bg-green-500 text-white rounded-full px-3 py-1 text-sm font-semibold',
                            'review' => 'bg-gray-500 text-gray-100 rounded-full px-3 py-1 text-sm font-semibold',
                            'rejected' => 'bg-red-500 text-white rounded-full px-3 py-1 text-sm font-semibold',
                            default => 'bg-yellow-500 text-white rounded-full px-3 py-1 text-sm font-semibold',
                        };
                    @endphp
                    <span class="{{ $statusClass }} capitalize">{{ $r->request_status }}</span>
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

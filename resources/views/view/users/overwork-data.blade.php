@extends('layouts.request-data')

@section('content')

@php
    $requestType = request('type', 'all');
    $requestStatus = request('status', 'submitted');
@endphp

<div class="container-draft bg-[#F0F3F8] p-6 rounded-lg w-full max-w-[1400px] shadow-lg">
    <x-form-filter-all-data title="overwork data" route="overwork.show" :status="$requestStatus" :type="$requestType" />
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
                <th class="py-3 px-6 font-semibold">Overwork Date</th>
                <th class="py-3 px-6 font-semibold w-[250px]">Task Description</th>
                @if (auth()->user()->role === 'admin')
                    <th class="py-3 px-6 font-semibold">
                            Name
                    </th>
                @endif
                    <th class="py-3 px-6 font-semibold">Duration</th>
                <th class="py-3 px-6 font-semibold">Evidence</th>
                <th class="py-3 px-6 font-semibold">Status</th>
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
                    {{ Carbon\Carbon::parse($d->overwork_date)->format('d F Y') }}
                </td>

                <td class="py-4 px-6" title="{{ $d->task_description }}">
                    {{ ucfirst(strtolower(Str::limit($d->task_description, 25))) }}
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
                    @php
                        $totalEvidence = $d->evidence->count();
                        $firstImage = $d->evidence->first(fn($e) => in_array(strtolower(pathinfo($e->path, PATHINFO_EXTENSION)), ['jpg', 'png', 'jpeg', 'webp']));
                        $firstVideo = $d->evidence->first(fn($e) => in_array(strtolower(pathinfo($e->path, PATHINFO_EXTENSION)), ['mp4', 'mov', 'avi']));
                    @endphp
                    @if($totalEvidence >= 1)
                        <span class="text-sm bg-blue-100 text-blue-600 px-auto w-[90px] py-2 rounded-full justify-center flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $totalEvidence }} Media
                        </span>
                    @else
                        <span class="text-gray-500 text-sm">No evidence</span>
                    @endif
                </td>
                <td class="py-4 px-6">
                    @php
                        $statusClass = match($d->request_status) {
                            'approved' => 'bg-green-500 text-white rounded-full px-3 py-1 text-sm',
                            'review' => 'bg-yellow-500 text-white rounded-full px-3 py-1 text-sm',
                            'rejected' => 'bg-red-500 text-white rounded-full px-3 py-1 text-sm',
                            default => 'bg-gray-400 text-white rounded-full px-3 py-1 text-sm',
                        };
                    @endphp
                    <span class="{{ $statusClass }} capitalize">{{ $d->request_status }}</span>
                </td>
                <td class="py-4 px-6 text-center">
                    <div class="flex justify-center items-center space-x-2">
                        <!-- Show Details Button -->
                        <x-action-navigate :d="$d" :requestStatus="$requestStatus" />
                    </div>
                </td>
            </tr>
            @empty
            <tr class="empty">
                <td colspan="8" class="py-8 px-6 text-center text-gray-500">
                    <div class="flex flex-col items-center">
                        <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M12 7v5l3 3" />
                        </svg>
                        <p class="capitalize">No overwork {{request()->segment(2)}} data found</p>
                        @if (auth()->user()->role === 'user')
                            <a href="{{ route('overwork.form-view') }}" class="text-[#1EB8CD] hover:underline mt-2">
                                Create your first overwork request
                            </a>
                        @endif
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

<x-preview-data title="overwork" />

<x-modal-success />

<x-manage-data />
@endsection

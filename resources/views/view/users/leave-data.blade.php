@extends('layouts.request-data')

@section('content')
@php
    $requestType = request('type', 'all');
    $requestStatus = request('status', 'all');
@endphp
<div class="container-draft bg-[#F0F3F8] p-6 rounded-lg w-full max-w-[1400px] shadow-lg">
    <x-form-filter-all-data title="leave date" route="leave.show" :status="$requestStatus" :type="$requestType" />
    @if(auth()->user()->role === 'user')
        <a href="{{ route('leave.form-view') }}" 
            class="bg-gradient-to-r from-[#1EB8CD] to-[#2652B8] hover:from-cyan-600 hover:to-blue-800 text-white font-semibold py-2 px-2 rounded-lg transition duration-300 flex items-center space-x-2 w-[130px]">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M12 6v12M6 12h12" />
            </svg>
            <span>New Data</span>
        </a>
    @endif

    <!-- Leave Table -->
    <table class="min-w-full text-left justify-center border-b border-gray-300 mr-10">
        <thead class="bg-transparent text-[#1e293b] border-b border-gray-300">
            <tr>
                <th class="py-3 px-6 font-semibold">No</th>
                <th class="py-3 px-6 font-semibold">Start Date</th>
                <th class="py-3 px-6 font-semibold w-[400px]">Reason</th>
                @if (auth()->user()->role === 'admin')
                    <th class="py-3 px-6 font-semibold">
                        Name
                    </th>
                    @endif
                <th class="py-3 px-6 font-semibold">Duration</th>
                <th class="py-3 px-6 font-semibold">Status</th>
                <th class="py-3 px-6 font-semibold text-center">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($data as $d)
                @php
                    $start = Carbon\Carbon::parse($d->start_leave);
                    $finish = $start->copy();
                    $periodDays = $d->leave_period / 8;
                    $addDays = 0;
                    
                    while ($addDays < floor($periodDays)) {
                        if (!$finish->isWeekend()) {
                            $addDays++;
                        }
                        $finish->addDay();
                    }

                    $periodHours = ($periodDays - floor($periodDays) ) * 8;
                    
                    if (floor($periodDays) == '0') {
                        $duration = $periodHours . ' hours';
                    } elseif ($periodHours == '0') {
                        $finish = $finish->copy()->subDay();
                        $duration = floor($periodDays) . ' days';
                    } else {
                        $duration = floor($periodDays) . ' days ' . $periodHours . ' hours';
                    }
                @endphp
            <tr class="{{ $loop->odd ? 'bg-white' : 'bg-[#f1f5f9]' }} border-b border-gray-300">
                <td class="py-4 px-6">
                    {{ $loop->iteration }}
                </td>
                <td class="py-4 px-6">
                    {{ Carbon\Carbon::parse($d->start_leave)->format('d F Y') }}
                </td>
                <td class="py-4 px-6" title="{{ $d->reason }}">
                    {{ ucfirst(strtolower(Str::limit($d->reason, 25))) }}
                </td>
                @if (auth()->user()->role === 'admin')
                    <td class="py-4 px-6">
                        {{ Str::words($d->user->name, 2) }}
                    </td>
                @endif
                <td class="py-4 px-6 font-semibold capitalize">{{ $duration }}</td>
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
                        <x-action-navigate :d="$d" :requestStatus="$requestStatus" />
                    </div>
                </td>
            </tr>
            @empty
            <tr class="empty">
                <td colspan="7" class="py-8 px-6 text-gray-500">
                    <div class="flex flex-col items-center">
                        <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                            <path d="M16 2v4M8 2v4M3 10h18" />
                        </svg>
                        <p class="capitalize">No leave {{request()->segment(2)}} data found</p>
                        @if (auth()->user()->role === 'user')
                            <a href="{{ route('leave.form-view') }}" class="text-[#1EB8CD] hover:underline mt-2">
                                Create your first leave request
                            </a>
                        @endif
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<x-preview-data title="leave" />
{{-- <x-modal name="leave-preview-modal" maxWidth="lg">
    <div class="p-6 flex flex-col max-h-[80vh]">
        <div class="flex justify-center items-center mb-4 relative flex-shrink-0">
            <h3 class="text-xl font-extrabold text-[#012967]">
                Leave Preview
            </h3>
            <button
                @click="window.dispatchEvent(new CustomEvent('close-modal', { detail: 'leave-preview-modal' }))"
                class="absolute right-0 text-gray-400 hover:text-gray-600 text-xl"
            >
                &times;
            </button>
        </div>
        <div id="leave-preview-body" class="space-y-3 overflow-y-auto flex-1"></div>
    </div>
</x-modal> --}}

<x-modal-success />

<x-manage-data />

@endsection

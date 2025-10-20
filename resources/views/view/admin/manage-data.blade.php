@extends('layouts.request-data')

@section('content')
<x-modal-success />

    @php
        $requestStatus = request('status', 'all');
    @endphp

<div class="container-draft bg-[#F0F3F8] p-6 rounded-lg w-full max-w-6xl shadow-lg">
    <!-- Title -->
    <x-form-filter-all-data title="submission" route="request.show" :status="$requestStatus" />
    <!-- Draft Table -->
    <table class="min-w-full text-left justify-center border-b border-gray-400">
        <thead class="bg-transparent text-[#1e293b] border-b-2 border-gray-300">
            <tr>
                <th class="py-3 px-6 font-semibold">No</th>
                <th class="py-3 px-6 font-semibold">Schedule</th>
                <th class="py-3 px-6 font-semibold">Type</th>
                <th class="py-3 px-6 font-semibold">Name</th>
                <th class="py-3 px-6 font-semibold">Reason</th>
                <th class="py-3 px-6 font-semibold">Status</th>
                <th class="py-3 px-6 font-semibold text-center">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($data as $d)
                <tr class="{{ $loop->odd ? 'bg-white' : 'bg-[#f1f5f9]' }} border-b border-gray-300">
                    <!-- Number -->
                    <td class="py-4 px-6">{{ $loop->iteration }}</td>

                    <!-- Date -->
                    @if ($d->type === 'overwork')
                        <td class="py-4 px-6">{{ Carbon\Carbon::parse($d->overwork_date)->format('d F Y') }}</td>
                    @else
                        <td class="py-4 px-6">{{ Carbon\Carbon::parse($d->start_leave)->format('d F Y') }}</td>
                    @endif
                    
                    <!-- Type -->
                    <td class="py-4 px-6">
                        <span class="py-1 px-3 rounded-full capitalize text-white {{ $d->type === 'overwork' ? 'bg-amber-500' : 'bg-sky-500' }}">{{ $d->type }}</span>
                    </td>

                    <!-- Status -->
                    <td class="py-4 px-6"> {{ $d->user->name }} </td>

                    <!-- Reason / Task -->
                    <td class="py-4 px-6" title="{{ $d->reason ?? $d->task_description }}">{{ Str::limit($d->reason ?? $d->task_description, 40) }}</td>

                    <!-- Status -->
                    <td class="py-4 px-6">
                        @php
                            $statusClass = match($d->request_status) {
                                'approved' => 'bg-green-500 text-white rounded-full px-3 py-1 text-sm font-semibold',
                                'review' => 'bg-gray-500 text-gray-100 rounded-full px-3 py-1 text-sm font-semibold',
                                'rejected' => 'bg-red-500 text-white rounded-full px-3 py-1 text-sm font-semibold',
                                default => 'bg-yellow-500 text-white rounded-full px-3 py-1 text-sm font-semibold',
                            };
                        @endphp
                        <span class="{{ $statusClass }}">{{ $d->request_status }}</span>
                    </td>

                    <!-- Action -->
                    <td id="data" class="py-4 px-6 text-center">
                        <x-action-navigate :d="$d" :requestStatus="$requestStatus" />
                    </td>
                </tr>
            @empty
            <tr class="empty">
                <td colspan="7" class="py-8 px-6 text-center text-gray-500">
                    @include('view.admin.components.status-data-empty')
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

    <x-preview-data title="request" />
    <x-manage-data />
@endsection

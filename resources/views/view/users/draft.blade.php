@extends('layouts.tables')

@section('content')
@php
    $requestType = request('type', 'all');
    $requestStatus = request('status');
@endphp
<div class="container-draft bg-[#F0F3F8] p-6 rounded-lg w-full max-w-6xl shadow-lg">
    <x-form-filter-all-data title="draft request" route="draft" :status="$requestStatus" :type="$requestType" />

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
                    <span class="py-1 px-3 rounded-full capitalize text-white {{ $d->type === 'overwork' ? 'bg-amber-500' : 'bg-sky-500' }}">{{ $d->type }}</span>
                </td>

                <td class="py-4 px-6 text-center">
                    <div class="flex space-x-2">
                        <x-action-navigate :d="$d" :requestStatus="$requestStatus" /> />
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
            <tr class="empty">
                @php
                    $requestType = request('type', 'all');
                @endphp
                <td colspan="6" class="py-8 px-6 text-center text-gray-500">
                    <div class="flex flex-col items-center">
                        @if ($requestType === 'overwork') 
                            <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="9" />
                                <path d="M12 7v5l3 3" />
                            </svg>
                            <p class="capitalize">No overwork data found</p>
                            <a href="{{ route('overwork.form-view') }}" class="text-[#1EB8CD] hover:underline mt-2">
                                Create your first overwork request
                            </a>
                        @elseif ($requestType === 'leave')
                            <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                <path d="M16 2v4M8 2v4M3 10h18" />
                            </svg>
                            <p class="capitalize">No leave {{request()->segment(2)}} data found</p>
                            <a href="{{ route('leave.form-view') }}" class="text-[#1EB8CD] hover:underline mt-2">
                                Create your first leave request
                            </a>
                        @else
                            <div class="flex space-x-5">
                                <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="9" />
                                    <path d="M12 7v5l3 3" />
                                </svg>
                                <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                    <path d="M16 2v4M8 2v4M3 10h18" />
                                </svg>
                            </div>
                            <p>Draft overwork or leave data not found</p>
                        @endif
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<x-preview-data />
<x-manage-data />
@endsection

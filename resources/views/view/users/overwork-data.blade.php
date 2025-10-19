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
            @forelse($data as $r)
            <tr class="{{ $loop->odd ? 'bg-white' : 'bg-[#f1f5f9]' }} border-b border-gray-300 items-center justify-center">
                <td class="py-4 px-6">
                    {{ $loop->iteration }}
                </td>

                <td class="py-4 px-6">
                    {{ Carbon\Carbon::parse($r->overwork_date)->format('d F Y') }}
                </td>

                <td class="py-4 px-6" title="{{ $r->task_description }}">
                    {{ ucfirst(strtolower(Str::limit($r->task_description, 25))) }}
                </td>

                @if (auth()->user()->role === 'admin')
                    <td class="py-4 px-6">
                        {{ Str::words($r->user->name, 2) ?? 'N/A' }}
                    </td>
                @endif

                <td class="py-4 px-6">
                    @php
                        $duration = \Carbon\Carbon::parse($r->start_overwork)->diff(\Carbon\Carbon::parse($r->finished_overwork));
                        @endphp
                    @if ($duration->format('%i') == '0')
                        {{ $duration->format('%h hours') }}
                    @else
                        {{ $duration->format('%h hours %i minutes') }}
                    @endif
                </td>

                <td class="py-4 px-6">
                    @php
                        $totalEvidence = $r->evidence->count();
                        $firstImage = $r->evidence->first(fn($e) => in_array(strtolower(pathinfo($e->path, PATHINFO_EXTENSION)), ['jpg', 'png', 'jpeg', 'webp']));
                        $firstVideo = $r->evidence->first(fn($e) => in_array(strtolower(pathinfo($e->path, PATHINFO_EXTENSION)), ['mp4', 'mov', 'avi']));
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
                        $statusClass = match($r->request_status) {
                            'approved' => 'bg-green-500 text-white rounded-full px-3 py-1 text-sm',
                            'review' => 'bg-yellow-500 text-white rounded-full px-3 py-1 text-sm',
                            'rejected' => 'bg-red-500 text-white rounded-full px-3 py-1 text-sm',
                            default => 'bg-gray-400 text-white rounded-full px-3 py-1 text-sm',
                        };
                    @endphp
                    <span class="{{ $statusClass }} capitalize">{{ $r->request_status }}</span>
                </td>
                <td class="py-4 px-6 text-center">
                    <div class="flex justify-center items-center space-x-2">
                        <!-- Show Details Button -->
                        <button
                            class="eye-preview-btn border-2 border-gray-500 text-gray-600 rounded px-2 hover:bg-gray-100"
                            title="Show Details"
                            data-date="{{ Carbon\Carbon::parse($r->created_at)->format('d F Y') }}"
                            data-overwork_date="{{ Carbon\Carbon::parse($r->created_at)->format('d F Y') }}"
                            data-start="{{ Carbon\Carbon::parse($r->start_overwork)->format('H : i') }}"
                            data-finished="{{ Carbon\Carbon::parse($r->finished_overwork)->format('H : i') }}"
                            data-description="{{ $r->task_description }}"
                            data-duration="{{ $duration }}"
                            data-status="{{ $r->request_status }}"
                            data-evidences="{{ $r->evidence->toJson() }}"
                        >
                            <i class="bi bi-eye"></i>
                        </button>

                        @if (auth()->user()->role === 'admin')
                            <form action="{{route('request.edit', ['id' => $r->id, 'userId' => $r->user_id])}}" method="get" class="flex gap-2">
                                <button
                                    type="submit" name="approved" value="{{$r->type}}"
                                    class="{{$r->request_status === 'approved' ? 'hidden' : 'flex'}} border-2 border-gray-500 text-gray-600 rounded px-2 hover:bg-gray-100 inline-block"
                                    title="Accept"
                                    onclick="return confirm('Are you sure want to accept this request?')"
                                >
                                    <i class="bi bi-check2-square"></i>
                                </button>

                                <button
                                    type="submit" name="rejected" value="{{$r->type}}"
                                    class="{{$r->request_status === 'rejected' ? 'hidden' : 'flex'}} border-2 border-gray-500 text-gray-600 rounded px-2 hover:bg-gray-100"
                                    title="Reject"
                                    onclick="return confirm('Are you sure want to reject this request?')"
                                >
                                <i class="bi bi-x"></i>
                                </button>
                            </form>
                        @endif
                        
                        @if ($r->request_status === 'draft')
                            <a
                            href="{{ route('overwork.edit', $r->id) }}"
                                class="border-2 border-gray-500 text-gray-600 rounded px-2 hover:bg-gray-100 inline-block"
                                title="Edit"
                            >
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('overwork.delete', $r->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this overwork draft?')">
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
                        @endif
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

<x-modal name="overwork-preview-modal" maxWidth="3xl">
    <div class="p-6 flex flex-col max-h-[80vh]">
        <div class="flex justify-between items-center mb-4 flex-shrink-0">
            <h3 class="text-xl font-extrabold text-[#012967] flex-1 text-center">
                Overwork Preview
            </h3>
            <button
                @click="window.dispatchEvent(new CustomEvent('close-modal', { detail: 'overwork-preview-modal' }))"
                class="text-red-500 hover:text-red-300 text-2xl"
            >
                &times;
            </button>
        </div>
        <div id="overwork-preview-body" class="space-y-3 overflow-y-auto flex-1">
            <!-- content -->
        </div>
    </div>
</x-modal>

<x-modal name="evidence-viewer-modal" maxWidth="6xl">
    <div class="flex items-center justify-center relative p-6">
            <button
                @click="window.dispatchEvent(new CustomEvent('close-modal', { detail: 'evidence-viewer-modal' }))"
                class="absolute right-5 m-5 top-0 text-red-500 hover:text-red-300 text-2xl"
            >
                &times;
            </button>
        <div id="evidence-viewer-body" class="flex items-center justify-center">
            <!-- media content -->
        </div>
            <button id="prev-evidence" class="absolute left-4 bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded">
                &larr;
            </button>
            <button id="next-evidence" class="absolute right-4 bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded">
                &rarr;
            </button>
        </div>
    </div>
</x-modal>

<x-modal-success />

<x-manage-data />
@endsection

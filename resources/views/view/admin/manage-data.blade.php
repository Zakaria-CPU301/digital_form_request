@extends('layouts.tables')

@section('content')
<x-modal-success />

<div class="container-draft bg-[#F0F3F8] p-6 rounded-lg w-full max-w-6xl shadow-lg">
    <!-- Title -->
    <h2 class="text-2xl font-bold text-[#012967] mb-4">Submission</h2>

    <!-- Filter + Search -->
    <div class="flex items-center mb-6">
        @php
            $activeToggle = request('status', 'review');
        @endphp
        {{-- Tabs --}}
        <form id="autoFilter" action="{{route('request.show', ['type' => $activeToggle])}}" method="get" class="w-full flex justify-between items-center space-x-4">
            @include('components.filter-data-toggle')

            <div>
                {{-- Search --}}
                <input
                    type="search"
                    id="search"
                    name="search"
                    placeholder="Search..."
                    value="{{ request('search') }}"
                    class="border border-gray-300 rounded-full px-4 py-1 focus:outline-none focus:ring-2 focus:ring-cyan-400"
                />

                {{-- Month Filter --}}
                <select name="month" id="month" class="border border-gray-300 rounded-full w-[180px] py-1 px-3 focus:outline-none focus:ring-2 focus:ring-cyan-600">
                    <option value="all" {{ request('month') === 'all' ? 'selected' : '' }}>All Months</option>
                    @php
                        $months = [];
                        for ($i = 0; $i < 12; $i++) {
                            $date = now()->subMonths($i);
                            $months[] = ['value' => $date->format('m-Y'), 'label' => $date->format('F Y')];
                        }
                    @endphp
                    @foreach($months as $monthOption)
                        <option value="{{ $monthOption['value'] }}" {{ request('month') === $monthOption['value'] ? 'selected' : '' }}>
                            {{ $monthOption['label'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    <script>
        // document.getElementById('month').addEventListener('change', function() {
        //     this.closest('form').submit();
        // });
    </script>

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
                        @include('view.admin.components.action-navigate')
                    </td>
                </tr>
            @empty
            <tr>
                <td colspan="7" class="py-8 px-6 text-center text-gray-500">
                    @include('view.admin.components.status-data-empty')
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

    @include('view.admin.components.preview-data')

    @include('view.admin.components.manage-data')
@endsection

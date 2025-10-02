@extends('layouts.tables')

@section('content')

<div class="container-draft bg-[#F0F3F8] p-6 rounded-lg w-full max-w-6xl shadow-lg">
    @php
        $activeToggle = request('type', 'all');
    @endphp
    <h2 class="text-2xl font-bold text-[#012967] mb-4">Recent Request</h2>

    <div id="filter" class="flex items-center mb-6">
        {{-- Tabs --}}
        <form id="type" action="{{route('recent', ['type' => $activeToggle])}}" method="get" class="flex items-center space-x-4">
            @include('components.filter-data-toggle')

            {{-- Month Filter --}}
            <div>
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

            {{-- Search --}}
            <div>
                <input
                    type="search"
                    id="search"
                    name="search"
                    placeholder="Search..."
                    value="{{ request('search') }}"
                    class="border border-gray-300 rounded-full px-4 py-1 focus:outline-none focus:ring-2 focus:ring-cyan-400"
                />
            </div>
        </form>
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
            @forelse($data as $r)
            <tr class="{{ $loop->odd ? 'bg-white' : 'bg-[#f1f5f9]' }} border-b border-gray-300">
                <td class="py-4 px-6">
                    {{ $r->date ?? $loop->iteration }}
                </td>
                <td class="py-4 px-6">
                    {{ $r->date ?? $r->created_at->format('d - F - Y') }}
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
                        class="border-2 border-gray-500 text-gray-600 rounded px-2 hover:bg-gray-100"
                        title="Show Details"
                    >
                        <i class="bi bi-eye"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="py-8 px-6 text-center text-gray-500">
                    <div class="flex flex-col items-center">
                        <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <p>No data found</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('month').addEventListener('change', function() {
        this.closest('form').submit();
    });

    document.getElementById('search').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            if (row.cells.length > 3) {
                const reason = row.cells[3].textContent.toLowerCase();
                if (reason.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    });
});
</script>
@endsection

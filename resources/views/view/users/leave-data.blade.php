@extends('layouts.leave')

@section('content')

<div class="container-draft bg-[#F0F3F8] p-6 rounded-lg w-full max-w-[1400px] shadow-lg">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-[#012967]">Leave Data</h2>
        
        <form action="{{ route('leave.submitted') }}" method="GET" class="flex items-center space-x-4 mb-6">
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
            <div>
                <input
                    type="search"
                    id="search"
                    name="search"
                    placeholder="Search leave..."
                    value="{{ request('search') }}"
                    class="border border-gray-300 rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-400 w-full max-w-md"
                />
            </div>
        </form>
    </div>
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
                <th class="py-3 px-6 font-semibold">Date</th>
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
            @forelse($data as $r)
            <tr class="{{ $loop->odd ? 'bg-white' : 'bg-[#f1f5f9]' }} border-b border-gray-300">
                <td class="py-4 px-6">
                    {{ $loop->iteration }}
                </td>
                <td class="py-4 px-6">
                    {{ Carbon\Carbon::parse($r->start_leave)->format('d F Y') }}
                </td>
                <td class="py-4 px-6" title="{{ $r->reason }}">
                    {{ ucfirst(strtolower(Str::limit($r->reason, 25))) }}
                </td>
                @if (auth()->user()->role === 'admin')
                    <td class="py-4 px-6">
                        {{ Str::words($r->user->name, 2) }}
                    </td>
                @endif
                <td class="py-4 px-6 font-semibold capitalize">
                    @php
                        $periodDays = $r->leave_period / 8;
                        $periodHours = ($periodDays - floor($periodDays) ) * 8;

                        if (floor($periodDays) == '0') {
                            $duration = $periodHours . ' hours';
                        } elseif ($periodHours == '0') {
                            $duration = floor($periodDays) . ' days';
                        } else {
                            $duration = floor($periodDays) . ' days ' . $periodHours . ' hours';
                        }
                        echo $duration;
                    @endphp
                </td>
                <td class="py-4 px-6">
                    @php
                        $statusClass = match($r->request_status) {
                            'accepted' => 'bg-green-500 text-white rounded-full px-3 py-1 text-sm',
                            'review' => 'bg-yellow-500 text-white rounded-full px-3 py-1 text-sm',
                            'rejected' => 'bg-red-500 text-white rounded-full px-3 py-1 text-sm',
                            default => 'bg-gray-400 text-white rounded-full px-3 py-1 text-sm',
                        };
                    @endphp
                    <span class="{{ $statusClass }} capitalize">{{ $r->request_status }}</span>
                </td>
                <td class="py-4 px-6 text-center">
                    <div class="flex justify-center items-center space-x-2">
                        <button
                            class="eye-preview-btn border-2 border-gray-500 text-gray-600 rounded px-2 hover:bg-gray-100"
                            title="Show Details"
                            data-date="{{ Carbon\Carbon::parse($r->created_at)->format('d F Y') }}"
                            data-start="{{ Carbon\Carbon::parse($r->start_leave)->format('d F Y') }}"
                            data-finished="{{ Carbon\Carbon::parse($r->start_leave)->copy()->addDays((int) floor($periodDays) == '0' ? floor($periodDays) : floor($periodDays) - 1)->format('d F Y') }}"
                            data-reason="{{ $r->reason }}"
                            data-duration="{{ $duration }}"
                            data-status="{{ $r->request_status }}"
                        >
                            <i class="bi bi-eye"></i>
                        </button>

                        @if (auth()->user()->role === 'admin')
                            <form action="{{route('request.edit', ['id' => $r->id])}}" method="get" class="flex gap-2">
                                <button
                                    type="submit" name="accepted" value="{{$r->type}}"
                                    class="{{$r->request_status === 'accepted' ? 'hidden' : 'flex'}} border-2 border-gray-500 text-gray-600 rounded px-2 hover:bg-gray-100 inline-block"
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
                            href="{{ route('leave.edit', $r->id) }}"
                                class="border-2 border-gray-500 text-gray-600 rounded px-2 hover:bg-gray-100 inline-block"
                                title="Edit"
                            >
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('leave.delete', $r->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this leave draft?')">
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
            <tr>
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

<x-modal name="leave-preview-modal" maxWidth="lg">
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
    <div id="leave-preview-body" class="space-y-3 overflow-y-auto flex-1">
            <!-- content -->
        </div>
    </div>
</x-modal>

<x-modal-success />

<script>
document.getElementById('search').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        if (row.cells.length > 2) {
            const reason = row.cells[2].textContent.toLowerCase();
            console.log(reason.includes(searchTerm));
            
            if (reason.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
});

document.querySelectorAll('.eye-preview-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const date = this.dataset.date;
        const start = this.dataset.start;
        const finish = this.dataset.finished;
        const reason = this.dataset.reason;
        const duration = this.dataset.duration;
        const status = this.dataset.status;
        const statusClass = getStatusClass(status);
        const body = `
            <div class="flex flex-col items-start">
                <span class="font-extrabold text-gray-700">Requested At:</span>
                <span class="text-gray-900 mt-2">${date}</span>
            </div>
            <div class="flex flex-col items-start">
                <span class="font-extrabold text-gray-700">Leave Date:</span>
                <span class="text-gray-900 mt-2 flex gap-5">
                    ${start} 
                        <i class="bi bi-arrow-right text-xl font-bold"></i>
                    ${finish}
                </span>
            </div>
            <div class="flex flex-col items-start">
                <span class="font-extrabold text-gray-700">Reason:</span>
                <span class="text-gray-900 mt-2">${reason.replace(/\n/g, '<br>')}</span>
            </div>
            <div class="flex flex-col items-start">
                <span class="font-extrabold text-gray-700">Duration:</span>
                <span class="text-gray-900 mt-2">${duration}</span>
            </div>
            <div class="flex flex-col items-start">
                <span class="font-extrabold text-gray-700">Status:</span>
                <span class="${statusClass} capitalize">${status}</span>
            </div>
        `;
        document.getElementById('leave-preview-body').innerHTML = body;
        window.dispatchEvent(new CustomEvent('open-modal', { detail: 'leave-preview-modal' }));
    });
});

function getStatusClass(status) {
    switch(status) {
        case 'accepted': return 'bg-green-500 text-white rounded-full px-3 py-1 text-sm';
        case 'review': return 'bg-gray-500 text-white rounded-full px-3 py-1 text-sm';
        case 'rejected': return 'bg-red-500 text-white rounded-full px-3 py-1 text-sm';
        default: return 'bg-gray-400 text-white rounded-full px-3 py-1 text-sm';
    }
}

document.getElementById('month').addEventListener('change', function() {
    this.closest('form').submit();
});

document.getElementById('search').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        if (row.cells.length > 2) {
            const reason = row.textContent.toLowerCase();
            if (reason.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
});
</script>
@endsection

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
                @if (auth()->user()->role === 'admin')
                    <th class="py-3 px-6 font-semibold">
                        Name
                    </th>
                @endif
                <th class="py-3 px-6 font-semibold">Duration</th>
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
                    {{ ucfirst(strtolower(Str::limit($r->task_description, 25))) }}
                </td>

                @if (auth()->user()->role === 'admin')
                    <td class="py-4 px-6 font-semibold">
                        {{ Str::words($r->user->name, 2) ?? 'N/A' }}
                    </td>
                @endif

                <td class="py-4 px-6 font-semibold capitalize">
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
                        class="eye-preview-btn border-2 border-gray-500 text-gray-600 rounded px-2 hover:bg-gray-100"
                        title="Show Details"
                        data-date="{{ $r->date ?? $r->created_at->format('d - m - Y') }}"
                        data-description="{{ $r->task_description }}"
                        data-duration="{{ $r->duration ?? 'N/A' }}"
                        data-status="{{ $r->request_status }}"
                    >
                        <i class="bi bi-eye"></i>
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

<x-modal name="overwork-preview-modal" maxWidth="lg">
    <div class="p-6">
        <div class="flex justify-center items-center mb-4 relative">
            <h3 class="text-xl font-extrabold text-[#012967] text-center">
                Overwork Preview
            </h3>
            <button
                @click="window.dispatchEvent(new CustomEvent('close-modal', { detail: 'overwork-preview-modal' }))"
                class="absolute right-0 text-gray-400 hover:text-gray-600 text-xl"
            >
                &times;
            </button>
        </div>
        <div id="overwork-preview-body" class="space-y-3">
            <!-- content -->
        </div>
    </div>
</x-modal>

<script>
document.getElementById('search').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        if (row.cells.length > 2) {
            const taskDesc = row.cells[2].textContent.toLowerCase();
            if (taskDesc.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
});

document.querySelectorAll('.eye-preview-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;
        const date = this.dataset.date;
        const description = this.dataset.description;
        const duration = this.dataset.duration;
        const status = this.dataset.status;
        const statusClass = getStatusClass(status);
        const body = `
            <div class="flex flex-col items-start">
                <span class="font-extrabold text-gray-700">Date:</span>
                <span class="text-gray-900 mt-2">${date}</span>
            </div>
            <div class="flex flex-col items-start">
                <span class="font-extrabold text-gray-700">Task Description:</span>
                <span class="text-gray-900 mt-2">${description}</span>
            </div>
            <div class="flex flex-col items-start">
                <span class="font-extrabold text-gray-700">Duration:</span>
                <span class="text-gray-900 mt-2">${duration}</span>
            </div>
            <div class="flex flex-col items-start">
                <span class="font-extrabold text-gray-700">Status:</span>
                <span class="${statusClass}">${status}</span>
            </div>
        `;
        document.getElementById('overwork-preview-body').innerHTML = body;
        window.dispatchEvent(new CustomEvent('open-modal', { detail: 'overwork-preview-modal' }));
    });
});

function getStatusClass(status) {
    switch(status) {
        case 'Approved': return 'bg-[#57B5CA] text-white rounded-full px-3 py-1 text-sm font-semibold';
        case 'Under Review': return 'bg-gray-400 text-white rounded-full px-3 py-1 text-sm font-semibold';
        case 'Rejected': return 'bg-[#DC5249] text-white rounded-full px-3 py-1 text-sm font-semibold';
        default: return 'bg-gray-300 text-gray-700 rounded-full px-3 py-1 text-sm font-semibold';
    }
}
</script>
@endsection

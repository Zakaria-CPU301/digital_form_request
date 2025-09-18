@extends('layouts.tables')

@section('content')
<div class="container-draft bg-[#F0F3F8] p-6 rounded-lg w-full max-w-6xl shadow-lg">
    <!-- Title -->
    <h2 class="text-2xl font-bold text-[#012967] mb-4">Draft Request</h2>

    <!-- Filter + Search -->
    <div class="flex items-center mb-6">
        <ul class="flex space-x-6 text-[#012967] font-semibold">
            <li class="border-b-4 border-cyan-400 pb-1 cursor-pointer"><a href="{{ route('draft.all') }}" class="hover:text-cyan-600 transition">All Draft</a></li>
            <li class="cursor-pointer"><a href="{{ route('draft.overwork') }}" class="hover:text-cyan-600 transition">Overwork</a></li>
            <li class="cursor-pointer"><a href="{{ route('draft.leave') }}" class="hover:text-cyan-600 transition">Leave</a></li>
        </ul>
        <div class="ml-auto">
            <input 
                type="search" 
                placeholder="Search..." 
                class="border border-gray-300 rounded-full px-4 py-1 focus:outline-none focus:ring-2 focus:ring-cyan-400" 
            />
        </div>
    </div>

    <!-- Draft Table -->
    <table class="min-w-full text-left justify-center border-b border-gray-400">
        <thead class="bg-transparent text-[#1e293b] border-b-2 border-gray-300">
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
            @foreach($draft as $d)
                <tr class="{{ $loop->odd ? 'bg-white' : 'bg-[#f1f5f9]' }} border-b border-gray-300">
                    <!-- Number -->
                    <td class="py-4 px-6">{{ $loop->iteration }}</td>

                    <!-- Date -->
                    <td class="py-4 px-6">{{ $d->created_at->format('d - m - Y') }}</td>

                    <!-- Type -->
                    <td class="py-4 px-6 font-semibold">{{ $d->type }}</td>

                    <!-- Reason / Task -->
                    <td class="py-4 px-6" title="{{ $d->reason ?? $d->task_description }}">{{ Str::limit($d->reason ?? $d->task_description, 40) }}</td>

                    <!-- Data Detail -->
                    <td class="py-4 px-6 font-semibold">3 Data</td>

                    <!-- Status -->
                    <td class="py-4 px-6">
                        @php
                            $statusClass = match($d->request_status) {
                                'Approved'     => 'bg-cyan-400 text-white rounded-f                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                t-sm font-semibold',
                                'Rejected'     => 'bg-red-500 text-white rounded-full px-3 py-1 text-sm font-semibold',
                                default        => 'bg-gray-300 text-gray-700 rounded-full px-3 py-1 text-sm font-semibold',
                            };
                        @endphp
                        <span class="{{ $statusClass }}">{{ $d->request_status }}</span>
                    </td>

                    <!-- Action -->
                    <td class="py-4 px-6 text-center space-x-2">
                        <button 
                            class="border-2 border-gray-500 text-gray-600 rounded px-2 hover:bg-gray-100" 
                            title="Show"
                        >
                            <i class="bi bi-eye"></i>
                        </button>
                        <a 
                            href="{{ $d->type === 'leave' ? route('leave.edit', $d->id) : route('overwork.edit', $d->id) }}" 
                            class="border-2 border-gray-500 text-gray-600 rounded px-2 hover:bg-gray-100 inline-block" 
                            title="Edit"
                        >
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <button 
                            class="border-2 border-gray-500 text-gray-600 rounded px-2 hover:bg-gray-100" 
                            title="Delete"
                        >
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

<x-app-layout>
    @php
        $activeToggle = request('type', 'all');
    @endphp
    
    <x-slot name="header">
        <div class="bg-gradient-to-r from-cyan-600 to-blue-600 p-6 rounded-b-lg">
            <h2 class="text-white font-bold text-2xl leading-tight">
                {{ __('Hi ') . auth()->user()->name }}!
            </h2>
        </div>
    </x-slot>

    {{-- Cards --}}
    <div class="mx-10 px-6 lg:px-8 py-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
        <div class="bg-[#F0F3F8] rounded-2xl shadow-md p-6 relative">
            <small class="text-[#012967] font-semibold flex items-center justify-between text-[15px]">
                {{ __('Total Overwork') }}
                <i class="bi bi-clock-history text-gray-500 text-lg"></i>
            </small>
            <h1 class="text-3xl font-extrabold text-gray-900 py-2">5 Hours</h1>
            <span class="text-sm text-gray-500">{{ __('Total Overwork') }}</span>
        </div>

        <div class="bg-[#F0F3F8] rounded-2xl shadow-md p-6 relative">
            <small class="text-[#012967] font-semibold flex items-center justify-between text-[15px]">
                {{ __('Total Leave ') }}
                <i class="bi bi-calendar-check text-gray-500 text-lg"></i>
            </small>
            <h1 class="text-3xl font-extrabold text-gray-900 py-2">2 Days</h1>
            <span class="text-sm text-gray-500">{{ __('Total Leave') }}</span>
        </div>
        
        <div class="bg-[#F0F3F8] rounded-2xl shadow-md p-6 relative">
            <small class="text-[#012967] font-semibold flex items-center justify-between text-[15px]">
                {{ __('Leave Balance') }}
                <i class="bi bi-journal-check text-gray-500 text-lg"></i>
            </small>
            <h1 class="text-3xl font-extrabold text-gray-900 py-2">{{ __('3 Days') }}</h1>
            <span class="text-sm text-gray-500">{{ __('Annual leave balance') }}</span>
        </div>

        <div class="bg-[#F0F3F8] rounded-2xl shadow-md p-6 relative">
            <small class="text-[#012967] font-semibold flex items-center justify-between text-[15px]">
                {{ __('Approved Request') }}
                <i class="bi bi-check-circle-fill text-green-600 text-lg"></i>
            </small>
            <h1 class="text-3xl font-extrabold text-gray-900 py-2">{{ $data['approved'] }}</h1>
            <span class="text-sm text-gray-500">{{ __('Request has been approved') }}</span>
        </div>

        <div class="bg-[#F0F3F8] rounded-2xl shadow-md p-6 relative">
            <small class="text-[#012967] font-semibold flex items-center justify-between text-[15px]">
                {{ __('Rejected Request') }}
                <i class="bi bi-x-circle-fill text-red-600 text-lg"></i>
            </small>
            <h1 class="text-3xl font-extrabold text-gray-900 py-2">{{ $data['rejected'] }}</h1>
            <span class="text-sm text-gray-500">{{ __('Request rejected') }}</span>
        </div>
        
        <div class="bg-[#F0F3F8] rounded-2xl shadow-md p-6 relative">
            <small class="text-[#012967] font-semibold flex items-center justify-between text-[15px]">
                {{ __('Pending Request') }}
                <i class="bi bi-hourglass-split text-gray-500 text-lg animate-spin"></i>
            </small>
            <h1 class="text-3xl font-extrabold text-gray-900 py-2">{{ $data['pending'] }}</h1>
            <span class="text-sm text-gray-500">{{ __('Total submission which still under review') }}</span>
        </div>
    </div>

    {{-- Buttons --}}
    <div class="mx-10 px-6 lg:px-8 flex flex-col sm:flex-row gap-6 mb-8">
        <a href="{{ route('leave.form-view') }}" class="flex h-[125px] flex-col items-start bg-gradient-to-r from-[#1EB8CD] to-[#2652B8] rounded-xl p-5 shadow-lg text-white w-full sm:w-1/3 hover:from-cyan-600 hover:to-blue-800 transition">
            <div class="flex items-center gap-3">
                <i class="bi bi-calendar-plus text-2xl"></i>
                <span class="font-semibold text-lg">Apply for leave</span>
            </div>
            <small class="mt-1 text-cyan-200">Create new leave request</small>
        </a>

        <a href="{{ route('overwork.form-view') }}" class="flex flex-col items-start bg-gradient-to-r from-[#1EB8CD] to-[#2652B8] rounded-xl p-5 shadow-lg text-white w-full sm:w-1/3 hover:from-cyan-600 hover:to-blue-800 transition">
            <div class="flex items-center gap-3">
                <i class="bi bi-alarm text-2xl"></i>
                <span class="font-semibold text-lg">Apply for overwork</span>
            </div>
            <small class="mt-1 text-cyan-200">Create new overwork request</small>
        </a>

        <a href="{{ route('draft') }}" class="flex flex-col items-start bg-gradient-to-r from-[#1EB8CD] to-[#2652B8] rounded-xl p-5 shadow-lg text-white w-full sm:w-1/3 hover:from-cyan-600 hover:to-blue-800 transition">
            <div class="flex items-center gap-3">
                <i class="bi bi-file-earmark-text text-2xl"></i>
                <span class="font-semibold text-lg">My draft</span>
            </div>
            <small class="mt-1 text-cyan-200">Request that hasn't submitted yet</small>
        </a>
    </div>

    {{-- Recent Request --}}

<div class="mx-[70px] px-6 lg:px-8 bg-[#F0F3F8] rounded-xl shadow-6xl p-6">
   @php
        $activeToggle = request('type', 'all');
    @endphp
        <h3 class="font-bold text-2xl mb-4 text-[#012967]">Recent Request</h3>
        <div id="data" class="flex items-center mb-6">
            {{-- Tabs --}}
            <form id="type" action="{{route('dashboard')}}#data" method="post">
                @csrf
                @include('components.filter-data-toggle')
            </form>

            {{-- Search --}}
            <div class="ml-auto">
                <input 
                    type="search" 
                    id="search" 
                    name="search" 
                    placeholder="Search..." 
                    class="border border-gray-300 rounded-full px-4 py-1 focus:outline-none focus:ring-2 focus:ring-cyan-400" 
                />
            </div>
        </div>

        {{-- Filter dropdown --}}
        <div>
            <select name="filter" id="filter" class="border border-gray-300 rounded-lg py-1 px-3 focus:outline-none focus:ring-2 focus:ring-cyan-600">
                <option>All Months</option>
                {{-- Add other months dynamically --}}
            </select>
        </div>

        {{-- Table --}}
        <table class="min-w-full text-left border-collapse border-b border-gray-300">
            <thead class="bg-transparent text-[#1e293b] border-b border-gray-300">
                <tr>
                    <th class="py-3 px-6 font-semibold w-12">No</th>
                    <th class="py-3 px-6 font-semibold w-15">Date</th>
                    <th class="py-3 px-6 font-semibold">Type</th>
                    <th class="py-3 px-6 font-semibold w-30">Reason</th>
                    <th class="py-3 px-6 font-semibold">Data Detail</th>
                    <th class="py-3 px-6 font-semibold">Status</th>
                    <th class="py-3 px-6 font-semibold text-center w-16">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['recent'] as $r)
                <tr class="{{ $loop->odd ? 'bg-white' : 'bg-[#f1f5f9]' }} border-b border-gray-300 hover:bg-gray-100 transition">
                    <td class="py-4 px-6">{{ $loop->iteration }}</td>
                    <td class="py-4 px-6">{{ $r->created_at->format('d - m - Y') }}</td>
                    <td class="py-4 px-6 font-semibold">{{ $r->type }}</td>
                    <td class="py-4 px-6 truncate max-w-xs" title="{{ $r->reason ?? $r->task_description }}">
                        {{ Str::limit($r->reason ?? $r->task_description, 40) }}
                    </td>
                    <td class="py-4 px-6 font-semibold">{{ $r->data_detail ?? '3 Data' }}</td>
                    <td class="py-4 px-6">
                        @php
                            $statusClass = match(strtolower($r->request_status)) {
                                'approved', 'accepted' => 'bg-cyan-500 text-white',
                                'under review', 'pending' => 'bg-gray-400 text-white',
                                'rejected' => 'bg-red-500 text-white',
                                default => 'bg-gray-300 text-gray-700',
                            };
                        @endphp
                        <span class="rounded-full px-3 py-1 text-sm font-semibold {{ $statusClass }}">
                            {{ ucfirst($r->request_status) }}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-center">
                        <button 
                            class="text-gray-500 hover:text-gray-700" 
                            title="Show Details"
                        >
                            <i class="bi bi-eye text-xl"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>

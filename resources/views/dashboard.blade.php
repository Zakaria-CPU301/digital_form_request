<x-app-layout>
    @php
        if (auth()->user()->role === 'user') {
            $activeToggle = request('type', 'all');
        } else {
            $activeToggle = request('status', 'review');
        }
        $currentMonth = request('month', 'all');
        $currentSearch = request('search', '');
    @endphp

    <x-slot name="header">
        <div class="bg-gradient-to-r from-cyan-600 to-blue-600 p-6 rounded-b-lg">
            <h2 class="text-white font-bold text-2xl leading-tight">
                {{ __('Hi ') . auth()->user()->name }}!
            </h2>
        </div>
    </x-slot>

    {{-- Cards --}}
    <div class="flex flex-col space-y-7">
        <div class="mx-10 px-6 lg:px-8 pt-8 grid grid-cols-1 {{auth()->user()->role === 'user' ? 'sm:grid-cols-2 md:grid-cols-3' : 'grid-cols-2' }} gap-8">
            @if (auth()->user()->role === 'user')
                <div class="bg-[#F0F3F8] rounded-2xl shadow-md p-6 relative">
                    <small class="text-[#012967] font-semibold flex items-center justify-between text-[15px]">
                        {{ __('Total Overwork') }}
                        <i class="bi bi-clock-history text-gray-500 text-lg"></i>
                    </small>
                    <h1 class="text-3xl font-extrabold text-gray-900 py-2">{{$data['totalOverwork'][0]->total_hours ?? 0}} {{__('Hours')}}</h1>
                    <span class="text-sm text-gray-500">{{ __('Total Overwork') }}</span>
                </div>

                <div class="bg-[#F0F3F8] rounded-2xl shadow-md p-6 relative">
                    <small class="text-[#012967] font-semibold flex items-center justify-between text-[15px]">
                        {{ __('Total Leave') }}
                        <i class="bi bi-journal-check text-gray-500 text-lg"></i>
                    </small>
                    <h1 class="text-3xl font-extrabold text-gray-900 py-2">{{$data['totalLeave'][0]->total_days ?? 0}} {{__('Days')}}</h1>
                    <span class="text-sm text-gray-500">{{ __('Total Leave') }}</span>
                </div>

                <div class="bg-[#F0F3F8] rounded-2xl shadow-md p-6 relative">
                    <small class="text-[#012967] font-semibold flex items-center justify-between text-[15px]">
                        {{ __('Leave Balance') }}
                        <i class="bi bi-journal-check text-gray-500 text-lg"></i>
                    </small>
                    <h1 class="text-3xl font-extrabold text-gray-900 py-2">{{ auth()->user()->overwork_allowance - (int) $data['totalLeave'][0]->total_days }} {{ __('Hours') }}</h1>
                    <span class="text-sm text-gray-500">{{ __('Annual leave balance') }}</span>
                </div>
            @elseif (auth()->user()->role === 'admin')
                <div class="bg-[#F0F3F8] rounded-2xl shadow-md p-6 relative">
                    <small class="text-[#012967] font-semibold flex items-center justify-between text-[15px]">
                        {{ __('Total Overwork') }}
                        <i class="bi bi-clock-history text-gray-500 text-lg"></i>
                    </small>
                    <h1 class="text-3xl font-extrabold text-gray-900 py-2">{{$data['result']->where('type', 'overwork')->count()}}</h1>
                    <span class="text-sm text-gray-500">{{ __('Total Overwork') }}</span>
                </div>

                <div class="bg-[#F0F3F8] rounded-2xl shadow-md p-6 relative">
                    <small class="text-[#012967] font-semibold flex items-center justify-between text-[15px]">
                        {{ __('Total Leave ') }}
                        <i class="bi bi-calendar-check text-gray-500 text-lg"></i>
                    </small>
                    <h1 class="text-3xl font-extrabold text-gray-900 py-2">{{$data['result']->where('type', 'leave')->count()}}</h1>
                    <span class="text-sm text-gray-500">{{ __('Total Leave') }}</span>
                </div>
            @endif
        </div>

        <div class="mx-10 px-6 lg:px-8 pb-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            <div class="bg-[#F0F3F8] rounded-2xl shadow-md p-6 relative">
                <small class="text-[#012967] font-semibold flex items-center justify-between text-[15px]">
                    {{ __('Approved Request') }}
                    <i class="bi bi-check-circle-fill text-green-600 text-lg"></i>
                </small>
                <h1 class="text-3xl font-extrabold text-gray-900 py-2">{{ $data['approved']->count() }}</h1>
                <span class="text-sm text-gray-500">{{ __('Request has been approved') }}</span>
            </div>

            <div class="bg-[#F0F3F8] rounded-2xl shadow-md p-6 relative">
                <small class="text-[#012967] font-semibold flex items-center justify-between text-[15px]">
                    {{ __('Rejected Request') }}
                    <i class="bi bi-x-circle-fill text-red-600 text-lg"></i>
                </small>
                <h1 class="text-3xl font-extrabold text-gray-900 py-2">{{ $data['rejected']->count() }}</h1>
                <span class="text-sm text-gray-500">{{ __('Request rejected') }}</span>
            </div>
            
            <div class="bg-[#F0F3F8] rounded-2xl shadow-md p-6 relative">
                <small class="text-[#012967] font-semibold flex items-center justify-between text-[15px]">
                    {{ __('Pending Request') }}
                    <i class="bi bi-hourglass-split text-gray-500 text-lg animate-spin"></i>
                </small>
                <h1 class="text-3xl font-extrabold text-gray-900 py-2">{{ $data['pending'] ->count() }}</h1>
                <span class="text-sm text-gray-500">{{ __('Total submission which still under review') }}</span>
            </div>
        </div>
    </div>

    {{-- Buttons --}}
    <div class="mx-10 px-6 lg:px-8 flex flex-col sm:flex-row gap-6 mb-8">
        @auth
            @if (auth()->user()->role === 'user')
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
            @elseif (auth()->user()->role === 'admin')
                <a href="{{ route('register') }}" class="flex h-[125px] flex-col items-start bg-gradient-to-r from-[#1EB8CD] to-[#2652B8] rounded-xl p-5 shadow-lg text-white w-full sm:w-1/3 hover:from-cyan-600 hover:to-blue-800 transition">
                    <div class="flex items-center gap-3">
                        <i class="bi bi-calendar-plus text-2xl"></i>
                        <span class="font-semibold text-lg">Add Employee</span>
                    </div>
                    <small class="mt-1 text-cyan-200">Create new employee account</small>
                </a>

                <a href="{{ route('account.show') }}" class="flex flex-col items-start bg-gradient-to-r from-[#1EB8CD] to-[#2652B8] rounded-xl p-5 shadow-lg text-white w-full sm:w-1/3 hover:from-cyan-600 hover:to-blue-800 transition">
                    <div class="flex items-center gap-3">
                        <i class="bi bi-alarm text-2xl"></i>
                        <span class="font-semibold text-lg">Manage Account</span>
                    </div>
                    <small class="mt-1 text-cyan-200">Manage employee account</small>
                </a>

                <a href="{{ route('request.show') }}" class="flex flex-col items-start bg-gradient-to-r from-[#1EB8CD] to-[#2652B8] rounded-xl p-5 shadow-lg text-white w-full sm:w-1/3 hover:from-cyan-600 hover:to-blue-800 transition">
                    <div class="flex items-center gap-3">
                        <i class="bi bi-file-earmark-text text-2xl"></i>
                        <span class="font-semibold text-lg">All Request</span>
                    </div>
                    <small class="mt-1 text-cyan-200">See all request</small>
                </a>
            @endif
        @endauth
    </div>

    {{-- Recent Request --}}
<div id="data"  class="mx-[70px] px-6 lg:px-8 bg-[#F0F3F8] rounded-xl shadow-6xl p-6">
        <h3 class="font-bold text-2xl mb-4 text-[#012967]">Recent Request</h3>

        <form action="{{ route('dashboard') }}#data" method="GET" class="mb-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 mb-4">
                {{-- Tabs --}}
                <div>
                    @include('components.filter-data-toggle')
                </div>
                
                {{-- Search --}}
                <div class="ml-auto">
                    <input
                    type="search"
                    id="search"
                    name="search"
                    placeholder="Search requests..."
                    value="{{ $currentSearch }}"
                    class="border border-gray-300 rounded-full px-4 py-1 focus:outline-none focus:ring-2 focus:ring-cyan-400 w-64"
                    />
                </div>
                <div>
                    <select name="month" id="month" class="border border-gray-300 rounded-full w-[180px] py-1 px-3 focus:outline-none focus:ring-2 focus:ring-cyan-600">
                        <option value="all" {{ $currentMonth === 'all' ? 'selected' : '' }}>All Months</option>
                        @php
                            $months = [];
                            for ($i = 0; $i < 12; $i++) {
                                $date = now()->subMonths($i);
                                $months[] = [
                                    'value' => $date->format('m-Y'),
                                    'label' => $date->format('F Y')
                                ];
                            }
                            @endphp
                        @foreach($months as $monthOption)
                            <option value="{{ $monthOption['value'] }}" {{ $currentMonth === $monthOption['value'] ? 'selected' : '' }}>
                                {{ $monthOption['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>


        {{-- Table --}}
        <table class="min-w-full text-left border-collapse border-b border-gray-300">
            <thead class="bg-transparent text-[#1e293b] border-b border-gray-300">
                <tr>
                    <th class="py-3 px-6 font-semibold w-12">No</th>
                    <th class="py-3 px-6 font-semibold w-15">Date</th>
                    <th class="py-3 px-6 font-semibold">Type</th>
                    @if (auth()->user()->role === 'admin')
                        <th class="py-3 px-6 font-semibold">Name</th>
                    @endif
                    <th class="py-3 px-6 font-semibold w-30">Reason</th>
                    <th class="py-3 px-6 font-semibold">Status</th>
                    <th class="py-3 px-6 font-semibold text-center w-16">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data['requestData'] as $d)
                <tr class="{{ $loop->odd ? 'bg-white' : 'bg-[#f1f5f9]' }} border-b border-gray-300 hover:bg-gray-100 transition">
                    <td class="py-4 px-6">{{ $loop->iteration }}</td>
                    <td class="py-4 px-6">{{ Carbon\Carbon::parse($d->created_at)->format('d - F - Y') }}</td>
                    <td class="py-4 px-6">{{ $d->type }}</td>
                    @if (auth()->user()->role === "admin")
                        <td class="py-4 px-6">{{ $d->user->name }}</td>
                    @endif
                    <td class="py-4 px-6 truncate max-w-xs" title="{{ $d->reason ?? $d->task_description }}">
                        {{ ucfirst(strtolower(Str::limit($d->reason ?? $d->task_description, 40))) }}
                    </td>
                    <td class="py-4 px-6 text-center">
                        @php
                            $statusClass = match($d->request_status) {
                                'accepted' => 'bg-green-500 text-white rounded-full px-3 py-1 text-sm font-semibold',
                                'review' => 'bg-gray-500 text-gray-100 rounded-full px-3 py-1 text-sm font-semibold',
                                'rejected' => 'bg-red-500 text-white rounded-full px-3 py-1 text-sm font-semibold',
                                default => 'bg-yellow-500 text-white rounded-full px-3 py-1 text-sm font-semibold',
                            };
                        @endphp
                        <span class="{{ $statusClass }} capitalize">{{ ucfirst($d->request_status) }}</span>
                    </td>
                    <td class="py-4 px-6 text-center">
                        @if (auth()->user()->role === 'user')
                            <button
                                class="eye-preview-btn border-2 border-gray-500 text-gray-600 rounded px-2 hover:bg-gray-100"
                                title="Show Details"
                                data-id="{{ $d->id }}"
                                data-date="{{ Carbon\Carbon::parse($d->created_at)->format('d - m - Y') }}"
                                data-type="{{ $d->type }}"
                                data-description="{{ $d->reason ?? $d->task_description }}"
                                data-status="{{ $d->request_status }}"
                            >
                                <i class="bi bi-eye"></i>
                            </button>
                        @else
                            @php
                                $status = request('status');
                            @endphp

                            <form action="{{route('request.edit', ['id' => $d->id])}}#data" method="get" class="flex justify-between space-x-2">
                                <button
                                    type="submit" name="type" value="show-dialog"
                                    class="border-2 border-gray-500 text-gray-600 rounded px-2 hover:bg-gray-100"
                                    title="Show"
                                >
                                    <i class="bi bi-eye"></i>
                                </button>

                                <button
                                    type="submit" name="accepted" value="{{$d->type}}"
                                    class="{{$status === 'accepted' ? 'hidden' : 'flex'}} border-2 border-gray-500 text-gray-600 rounded px-2 hover:bg-gray-100 inline-block"
                                    title="Accept"
                                    onclick="return confirm('Are you sure want to accept this request?')"
                                >
                                    <i class="bi bi-check2-square"></i>
                                </button>

                                <button
                                    type="submit" name="rejected" value="{{$d->type}}"
                                    class="{{$status === 'rejected' ? 'hidden' : 'flex'}} border-2 border-gray-500 text-gray-600 rounded px-2 hover:bg-gray-100"
                                    title="Reject"
                                    onclick="return confirm('Are you sure want to reject this request?')"
                                >
                                <i class="bi bi-x"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ auth()->user()->role === 'admin' ? 7 : 6 }}" class="py-8 px-6 text-center text-gray-500">
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

    <x-modal name="dashboard-preview-modal" maxWidth="lg">
        <div class="p-6 flex flex-col max-h-[80vh]">
            <div class="flex justify-center items-center mb-4 relative flex-shrink-0">
                <h3 class="text-xl font-extrabold text-[#012967] text-center">
                    Request Preview
                </h3>
                <button
                    @click="window.dispatchEvent(new CustomEvent('close-modal', { detail: 'dashboard-preview-modal' }))"
                    class="absolute right-0 text-gray-400 hover:text-gray-600 text-xl"
                >
                    &times;
                </button>
            </div>
            <div id="dashboard-preview-body" class="space-y-3 overflow-y-auto flex-1">
                <!-- content -->
            </div>
        </div>
    </x-modal>

    <script>
        function clearFilters() {
            document.getElementById('search').value = '';
            document.getElementById('month').value = 'all';

            const allDataButtons = document.querySelectorAll('button[name="type"][value="all"]');
            if (allDataButtons.length > 0) {
                allDataButtons[0].click();
            }

            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                row.style.display = '';
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('search').addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('tbody tr');
                const isAdmin = '{{ auth()->user()->role }}' === 'admin';
                const reasonIndex = isAdmin ? 4 : 3;

                rows.forEach(row => {
                    if (row.cells.length > reasonIndex) {
                        const reason = row.cells[reasonIndex].textContent.toLowerCase();
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
                    const id = this.dataset.id;
                    const date = this.dataset.date;
                    const type = this.dataset.type;
                    const description = this.dataset.description;
                    const status = this.dataset.status;
                    const statusClass = getStatusClass(status);
                    const body = `
                        <div class="flex flex-col items-start">
                            <span class="font-extrabold text-gray-700">Date:</span>
                            <span class="text-gray-900 mt-2">${date}</span>
                        </div>
                        <div class="flex flex-col items-start">
                            <span class="font-extrabold text-gray-700">Type:</span>
                            <span class="text-gray-900 mt-2">${type}</span>
                        </div>
                        <div class="flex flex-col items-start">
                            <span class="font-extrabold text-gray-700">Description:</span>
                            <span class="text-gray-900 mt-2">${description.replace(/\n/g, '<br>')}</span>
                        </div>
                        <div class="flex flex-col items-start">
                            <span class="font-extrabold text-gray-700">Status:</span>
                            <span class="${statusClass}">${status}</span>
                        </div>
                    `;
                    document.getElementById('dashboard-preview-body').innerHTML = body;
                    window.dispatchEvent(new CustomEvent('open-modal', { detail: 'dashboard-preview-modal' }));
                });
            });
        });

        document.getElementById('month').addEventListener('change', function() {
            this.closest('form').submit();
        });

        function getStatusClass(status) {
            switch(status.toLowerCase()) {
                case 'approved':
                case 'accepted': return 'bg-cyan-500 text-white rounded-full px-3 py-1 text-sm font-semibold';
                case 'under review':
                case 'pending': return 'bg-gray-400 text-white rounded-full px-3 py-1 text-sm font-semibold';
                case 'rejected': return 'bg-red-500 text-white rounded-full px-3 py-1 text-sm font-semibold';
                default: return 'bg-gray-300 text-gray-700 rounded-full px-3 py-1 text-sm font-semibold';
            }
        }
    </script>
</x-app-layout>

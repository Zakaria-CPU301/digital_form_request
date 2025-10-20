<x-app-layout>
    <x-modal-success />
    @php
        $requestType = request('type', 'all');
        $requestStatus = request('status', 'review');
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
                    <span class="text-sm text-gray-500">{{ __('Total Overwork Approved') }}</span>
                </div>

                <div class="bg-[#F0F3F8] rounded-2xl shadow-md p-6 relative">
                    <small class="text-[#012967] font-semibold flex items-center justify-between text-[15px]">
                        {{ __('Total Leave') }}
                        <i class="bi bi-journal-check text-gray-500 text-lg"></i>
                    </small>
                    @php
                        $leavePeriod = (int) $data['totalLeave'][0]->leave_period / 8;
                        $leaveBalance = auth()->user()->overwork_allowance - $leavePeriod;
                        $periodDays = floor($leavePeriod);
                        $periodHours = ($leavePeriod - $periodDays) * 8;

                        if (floor($periodDays) == '0') {
                            $totalLeave = $periodHours . ' hours';
                        } elseif ($periodHours == '0') {
                            $totalLeave = floor($periodDays) . ' days';
                        } else {
                            $totalLeave = floor($periodDays) . ' days ' . $periodHours . ' hours';
                        }

                        if (floor($leaveBalance) == 0) {
                            $balance = ($leaveBalance - floor($leaveBalance)) * 8 . ' hours';
                        } elseif ($leaveBalance - floor($leaveBalance) == 0) {
                            $balance = floor($leaveBalance) . ' days';
                        } else {
                            $balance = floor($leaveBalance) . ' days ' . ($leaveBalance - floor($leaveBalance)) * 8 . ' hours';
                        }
                    @endphp
                    <h1 class="text-3xl font-extrabold text-gray-900 py-2">{{$totalLeave ?? 0 . ' days'}}</h1>
                    <span class="text-sm text-gray-500">{{ __('Total Leave Approved') }}</span>
                </div>

                <div class="bg-[#F0F3F8] rounded-2xl shadow-md p-6 relative">
                    <small class="text-[#012967] font-semibold flex items-center justify-between text-[15px]">
                        {{ __('Leave Balance') }}
                        <i class="bi bi-journal-check text-gray-500 text-lg"></i>
                    </small>
                    <h1 class="text-3xl font-extrabold text-gray-900 py-2">{{ $balance }}</h1>
                    <span class="text-sm text-gray-500">{{ __('Annual leave balance') }}</span>
                </div>
            @elseif (auth()->user()->role === 'admin')
                <div class="bg-[#F0F3F8] rounded-2xl shadow-md p-6 relative">
                    <small class="text-[#012967] font-semibold flex items-center justify-between text-[15px]">
                        {{ __('Total Overwork') }}
                        <i class="bi bi-clock-history text-gray-500 text-lg"></i>
                    </small>
                    <h1 class="text-3xl font-extrabold text-gray-900 py-2">{{$data['approved']->where('type', 'overwork')->count()}} {{__('Data')}}</h1>
                    <span class="text-sm text-gray-500">{{ __('Total Overwork Approved') }}</span>
                </div>

                <div class="bg-[#F0F3F8] rounded-2xl shadow-md p-6 relative">
                    <small class="text-[#012967] font-semibold flex items-center justify-between text-[15px]">
                        {{ __('Total Leave ') }}
                        <i class="bi bi-calendar-check text-gray-500 text-lg"></i>
                    </small>
                    <h1 class="text-3xl font-extrabold text-gray-900 py-2">{{$data['approved']->where('type', 'leave')->count()}} {{__('Data')}}</h1>
                    <span class="text-sm text-gray-500">{{ __('Total Leave Approved') }}</span>
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
                <h1 class="text-3xl font-extrabold text-gray-900 py-2">{{ $data['pending']->count() }}</h1>
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
                    <small class="mt-1 text-cyan-200">Request that hasn't all yet</small>
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
    <div id="data" class="mx-[70px] px-6 lg:px-8 bg-[#F0F3F8] rounded-xl shadow-6xl p-6">
        <x-form-filter-all-data title="recent request" route="dashboard" :status="$requestStatus" :type="$requestType" />

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
                    <td class="py-4 px-6">{{ Carbon\Carbon::parse($d->start_leave ?? $d->overwork_date)->format('d F Y') }}</td>
                    <td class="py-4 px-6">
                        <span class="py-1 px-3 rounded-full capitalize text-white {{ $d->type === 'overwork' ? 'bg-amber-500' : 'bg-sky-500' }}">{{ $d->type }}</span>
                    </td>
                    @if (auth()->user()->role === "admin")
                        <td class="py-4 px-6">{{ $d->user->name }}</td>
                    @endif
                    <td class="py-4 px-6 truncate max-w-xs" title="{{ $d->reason ?? $d->task_description }}">
                        {{ ucfirst(strtolower(Str::limit($d->reason ?? $d->task_description, 40))) }}
                    </td>
                    <td class="py-4 px-6 text-center">
                        @php
                            $statusClass = match($d->request_status) {
                                'approved' => 'bg-green-500 text-white rounded-full px-3 py-1 font-semibold',
                                'review' => 'bg-gray-500 text-gray-100 rounded-full px-3 py-1 font-semibold',
                                'rejected' => 'bg-red-500 text-white rounded-full px-3 py-1 font-semibold',
                                default => 'bg-yellow-500 text-white rounded-full px-3 py-1 font-semibold',
                            };
                        @endphp
                        <span class="{{ $statusClass }} capitalize">{{ ucfirst($d->request_status) }}</span>
                    </td>
                    <td class="py-4 px-6 text-center">
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
</x-app-layout>

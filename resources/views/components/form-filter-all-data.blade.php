<div class="flex {{$route === 'dashboard' || $route === 'draft' ? 'flex-col' : 'flex-row justify-between py-3'}} mb-6 w-full gap-5">
    <h2 class="text-2xl font-bold text-[#012967] capitalize">{{$title}}</h2>
    <form id="autoFilter" action="{{route($route)}}" method="get">
        <div class="w-full flex justify-between items-center {{$route === 'dashboard' ? 'py-2' : ''}}">
            @if ($route === 'dashboard' || $route === 'draft')
                <x-filter-data-toggle :status="$status" :type="$type" />
            @endif

            <div class="flex items-center space-x-4">
                {{-- Month Filter --}}
                <select name="month" id="month" onchange="this.form.submit()" class="border border-gray-300 rounded-full w-[180px] py-1 px-3 focus:outline-none focus:ring-2 focus:ring-cyan-600">
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

                {{-- Search --}}
                <input
                    type="search"
                    id="search"
                    name="search"
                    placeholder="Search..."
                    value="{{ request('search') }}"
                    class="border border-gray-300 rounded-full px-4 py-1 focus:outline-none focus:ring-2 focus:ring-cyan-400"
                />
            </div>
        </div>
    </form>
</div>

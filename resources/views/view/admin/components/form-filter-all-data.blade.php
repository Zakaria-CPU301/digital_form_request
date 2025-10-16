@include('components.filter-data-toggle')

<div>
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

    {{-- Search --}}
    <input
        type="search"
        id="search"
        name="search"
        value="{{ $search }}"
        placeholder="Search..."
        value="{{ request('search') }}"
        class="border border-gray-300 rounded-full px-4 py-1 focus:outline-none focus:ring-2 focus:ring-cyan-400"
    />
</div>
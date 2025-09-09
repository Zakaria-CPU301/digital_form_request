@extends('layouts.main')

@section('content')
<div class="container-draft">
    
    {{-- <x-filter-data /> --}}
    <div class="action flex justify-between items-center">
    <ul class="flex gap-5">
        <li><a href="{{route('recent.all')}}" class="py-2 px-5 bg-blue-100 rounded-lg">All</a></li>
        <li><a href="{{route('recent.overwork')}}" class="py-2 px-5 bg-blue-100 rounded-lg">Overwork</a></li>
        <li><a href="{{route('recent.leave')}}" class="py-2 px-5 bg-blue-100 rounded-lg">Leave</a></li>
    </ul>

    <x-text-input type="text" name="search" id="search" placeholder="Search Data" />
</div>

    <table border="1" class="border text-center">
        <tr>
            <th class="capitalize py-2 px-4 border">no</th>
            <th class="capitalize py-2 px-4 border">date</th>
            <th class="capitalize py-2 px-4 border">type</th>
            <th class="capitalize py-2 px-4 border">reason</th>
            <th class="capitalize py-2 px-4 border">data detail</th>
            <th class="capitalize py-2 px-4 border">status</th>
            <th class="capitalize py-2 px-4 border">user id</th>
            <th class="capitalize py-2 px-4 border">action</th>
        </tr>
        @foreach ($recent as $r)
        {{-- {{dd($r)}} --}}
        <tr>
            <td class="py-5 px-3 border-2 border-collapse">{{$loop->iteration}}</td>
            <td class="py-5 px-3 border-2 border-collapse">{{$r->created_at->diffForHumans()}}</td>
            <td class="py-5 px-3 border-2 border-collapse">{{$r->type}}</td>
            <td class="py-5 px-3 border-2 border-collapse">{{$r->reason ?? $r->task_description}}</td>
            <td class="py-5 px-3 border-2 border-collapse">3 data</td>
            <td class="py-5 px-3 border-2 border-collapse">{{$r->request_status}}</td>
            <td class="py-5 px-3 border-2 border-collapse">{{$r->user_id}}</td>
            <td class="py-5 px-3 border-2 border-collapse">
                <button>show</button>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
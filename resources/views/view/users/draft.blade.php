@extends('layouts.main')

@section('content')
<div class="container-draft">

    <div class="action flex justify-between items-center">
        <ul class="flex gap-5">
            <li><a href="#" class="py-2 px-5 bg-blue-100 rounded-lg">All</a></li>
            <li><a href="#" class="py-2 px-5 bg-blue-100 rounded-lg">Overwork</a></li>
            <li><a href="#" class="py-2 px-5 bg-blue-100 rounded-lg">Leave</a></li>
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
        @foreach ($draft as $d)
        {{-- {{dd($draft)}} --}}
        <tr>
            <td class="py-5 px-3 border-2 border-collapse">{{$loop->iteration}}</td>
            <td class="py-5 px-3 border-2 border-collapse">{{$d->created_at->format('m-d-Y')}}</td>
            <td class="py-5 px-3 border-2 border-collapse">{{$d->type}}</td>
            <td class="py-5 px-3 border-2 border-collapse">{{$d->reason ?? $d->task_description}}</td>
            <td class="py-5 px-3 border-2 border-collapse">3 data</td>
            <td class="py-5 px-3 border-2 border-collapse">{{$d->request_status}}</td>
            <td class="py-5 px-3 border-2 border-collapse">{{$d->user_id}}</td>
            <td class="py-5 px-3 border-2 border-collapse">
                <button>show</button>
                <button>edit</button>
                <button>delete</button>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
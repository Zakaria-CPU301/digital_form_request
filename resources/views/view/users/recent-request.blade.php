@extends('layouts.main')

@section('content')
<div class="container-draft">
    
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
        {{-- {{dd($d)}} --}}
        <tr>
            <td class="py-5 px-3 border-2 border-collapse">{{$loop->iteration}}</td>
            <td class="py-5 px-3 border-2 border-collapse">{{$d->created_at->diffForHumans()}}</td>
            <td class="py-5 px-3 border-2 border-collapse">{{$d->type}}</td>
            <td class="py-5 px-3 border-2 border-collapse">{{$d->reason ?? $d->task_description}}</td>
            <td class="py-5 px-3 border-2 border-collapse">3 data</td>
            <td class="py-5 px-3 border-2 border-collapse">{{$d->request_status}}</td>
            <td class="py-5 px-3 border-2 border-collapse">{{$d->user_id}}</td>
            <td class="py-5 px-3 border-2 border-collapse">
                <button>edit</button>
                <button>delete</button>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
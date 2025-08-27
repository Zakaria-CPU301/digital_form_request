@extends('layouts.main')

@section('content')
<div class="container-draft">
    
    <table border="1" class="border text-center">
        <tr>
            <th class="capitalize py-2 px-4 border">date</th>
            <th class="capitalize py-2 px-4 border">type</th>
            <th class="capitalize py-2 px-4 border">reason</th>
            <th class="capitalize py-2 px-4 border">data detail</th>
            <th class="capitalize py-2 px-4 border">status</th>
            <th class="capitalize py-2 px-4 border">action</th>
        </tr>
        @foreach ($overworks[0] as $o)
        <tr>
            <td class="py-5 px-3 border-2 border-collapse">{{$o->created_at->format('m-d-Y')}}</td>
            <td class="py-5 px-3 border-2 border-collapse">{{$overworks[1]}}</td>
            <td class="py-5 px-3 border-2 border-collapse">{{$o->task_description}}</td>
            <td class="py-5 px-3 border-2 border-collapse">3 data</td>
            <td class="py-5 px-3 border-2 border-collapse">{{$o->request_status}}</td>
            <td class="py-5 px-3 border-2 border-collapse">
                <button>edit</button>
                <button>delete</button>
            </td>
        </tr>
        {{-- 
        diskusi rencana untuk seminar dengan materi dart dan flutter 
        menggunakan tamplating angine 
        
        --}}
        @endforeach
        @foreach ($leaves[0] as $l)
        <tr>
            <td class="py-5 px-3 border-2 border-collapse">{{$l->created_at->format('m-d-Y')}}</td>
            <td class="py-5 px-3 border-2 border-collapse">{{$leaves[1]}}</td>
            <td class="py-5 px-3 border-2 border-collapse">{{$l->reason}}</td>
            <td class="py-5 px-3 border-2 border-collapse">3 data</td>
            <td class="py-5 px-3 border-2 border-collapse">{{$l->request_status}}</td>
            <td class="py-5 px-3 border-2 border-collapse">
                <button>edit</button>
                <button>delete</button>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
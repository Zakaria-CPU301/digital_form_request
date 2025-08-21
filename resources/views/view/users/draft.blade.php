@extends('layouts.main')

@section('content')
<div class="container-draft">
    
    <table border="1">
        <tr>
            <th class="capitalize">date</th>
            <th class="capitalize">type</th>
            <th class="capitalize">reason</th>
            <th class="capitalize">data detail</th>
            <th class="capitalize">status</th>
            <th class="capitalize">action</th>
        </tr>
        @foreach ($overworks[0] as $o)
        <tr>
            <td>{{$o->created_at->format('m-d-Y')}}</td>
            <td>{{$overworks[1]}}</td>
            <td>{{$o->task_description}}</td>
            <td>3 data</td>
            <td>{{$o->request_status}}</td>
            <td>
                <button>edit</button>
                <button>delete</button>
            </td>
        </tr>
        @endforeach
        @foreach ($leaves[0] as $l)
        <tr>
            <td>{{$l->created_at->format('m-d-Y')}}</td>
            <td>{{$leaves[1]}}</td>
            <td>{{$l->reason}}</td>
            <td>3 data</td>
            <td>{{$l->request_status}}</td>
            <td>
                <button>edit</button>
                <button>delete</button>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
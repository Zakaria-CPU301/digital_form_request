@extends('layouts.main')

@section('content')
<form action="{{route('leave.insert')}}" method="post">
    @csrf
    {{-- account_data
    @foreach ($account as $item)
        {{dd($item)}}
    @endforeach --}}
    {{-- <input type="text" name="fullname" id="" value="" disabled> --}}

    {{-- leave_request --}}
    <input type="date" name="start" id="">
    <input type="date" name="finish" id="">
    <textarea name="reason" id=""></textarea>
    <button type="submit" name="action" value="draft">draft</button>
    <button type="submit" name="action" value="submit">submit</button>
</form>
@endsection
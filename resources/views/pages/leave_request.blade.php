@extends('layouts.main')

@section('content')
<form action="{{route('leave.insert')}}" method="post">
    @csrf
    <input type="date" name="start" id="">
    <input type="date" name="finish" id="">
    <textarea name="reason" id=""></textarea>
    <button type="submit">submit</button>
</form>
@endsection
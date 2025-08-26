@extends('layouts.main')

@section('content')
<form action="{{route('leave.insert')}}" method="post">
    @csrf
    {{-- leave_request --}}
    <input type="date" name="start" id="">
    <input type="date" name="finish" id="">
    <textarea name="reason" id=""></textarea>
    <button type="submit" name="action" value="draft">draft</button>
    <button type="submit" name="action" value="submit">submit</button>
</form>
@endsection
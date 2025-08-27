@extends('layouts.main')

@section('content')
<form action="{{route('leave.insert')}}" method="post" class="">
    @csrf
    <h1></h1>
    <input type="hidden" name="user_id" id="" value="{{auth()->user()->id}}">
    <input type="text" name="" id="" value="{{auth()->user()->name}}" disabled>
    <input type="text" name="" id="" value="{{auth()->user()->position}}" disabled>
    <input type="text" name="" id="" value="{{auth()->user()->departement}}" disabled>
    <input type="text" name="" id="" value="{{auth()->user()->phone_number}}" disabled>
    {{-- leave_request --}}
    <input type="date" name="start" id="">
    <input type="date" name="finish" id="">
    <textarea name="reason" id=""></textarea>
    <button type="submit" name="action" value="draft">draft</button>
    <button type="submit" name="action" value="submit">submit</button>
</form>
@endsection
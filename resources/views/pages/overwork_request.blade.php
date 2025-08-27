@extends('layouts.main')

@section('content')

{{-- @if ($errors->has('err'))
    <p>{{$errors->first('err')}}</p>
@endif --}}
<form action="{{route('overwork.insert')}}" method="post">
    @csrf
    <h1>submission informations</h1>
    <input type="hidden" name="user_id" id="" value="{{auth()->user()->id}}">
    <input type="text" name="" id="" value="{{auth()->user()->name}}" disabled>
    <input type="text" name="" id="" value="{{auth()->user()->position}}" disabled>
    <input type="text" name="" id="" value="{{auth()->user()->departement}}" disabled>
    <input type="text" name="" id="" value="{{auth()->user()->phone_number}}" disabled>
    {{-- overwork_request --}}
    <h1>overwork informations</h1>
    <input type="date" name="date" id="">
    <input type="time" name="start" id="">
    <input type="time" name="finish" id="">
    <textarea name="desc" id=""></textarea>
    <button type="submit" name="action" value="draft">draft</button>
    <button type="submit" name="action" value="submit">submit</button>
</form>
@endsection
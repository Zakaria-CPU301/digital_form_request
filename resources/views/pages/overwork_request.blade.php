@extends('layouts.main')

@section('content')

@if ($errors->has('err'))
    <p>{{$errors->first('err')}}</p>
@endif
<form action="{{route('overwork.insert')}}" method="post">
    @csrf
    {{-- overwork_request --}}
    <h1>OVERWORK INFORMATION</h1>
    <input type="date" name="date" id="">
    <input type="time" name="start" id="">
    <input type="time" name="finish" id="">
    <textarea name="desc" id=""></textarea>
    <button type="submit" name="action" value="draft">draft</button>
    <button type="submit" name="action" value="submit">submit</button>
</form>
@endsection
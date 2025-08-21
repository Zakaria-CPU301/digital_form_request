@extends('layouts.main')

@section('content')

@if ($errors->has('err'))
    <p>{{$errors->first('err')}}</p>
@endif
<form action="{{route('overwork.insert')}}" method="post">
    @csrf
    <h1>OVERWORK INFORMATION</h1>
    <input type="date" name="date" id="">
    <input type="time" name="start" id="">
    <input type="time" name="finish" id="">
    <textarea name="desc" id=""></textarea>
    <button type="submit">Submit</button>
</form>
@endsection
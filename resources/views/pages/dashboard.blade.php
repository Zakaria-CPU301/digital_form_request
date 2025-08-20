@extends('layouts.main')

@section('content')
    @if (session()->has('success'))
        <h1>
            <center>{{session('success')}}</center>
        </h1>
    @endif
    <a href="{{route('overwork.form-view')}}">Overwork Request</a>
@endsection
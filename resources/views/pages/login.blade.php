@extends('layouts.main')

@section('content')
<div class="container-login w-full flex flex-col justify-center items-center">
    <h1>add account</h1>
    <form action="{{route('home')}}" method="get" class="flex flex-col space-y-5 w-2/3">
        @csrf

        <input type="email" name="email" id="" placeholder="email">
        <input type="password" name="pass" id="" placeholder="password">
        <button type="submit">submit</button>
    </form>
</div>
@endsection
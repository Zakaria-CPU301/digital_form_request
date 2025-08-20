@extends('layouts.main')

@section('content')
<div class="container-login w-full flex flex-col justify-center items-center">
    <h1>add account</h1>
    <form action="{{route('login')}}" method="post" class="flex flex-col space-y-5 w-2/3">
        @csrf

        <input type="text" name="fullname" placeholder="fullname">
        <input type="email" name="email" id="" placeholder="email">
        <input type="tel" name="phone_number" id="" placeholder="phone number">
        <select name="position" id="">
            <option disabled hidden selected>position</option>
            <option value="a">a</option>
            <option value="b">b</option>
            <option value="c">c</option>
            <option value="d">d</option>
        </select>
        <select name="job" id="">
            <option disabled hidden selected>job</option>
            <option value="a">a</option>
            <option value="b">b</option>
            <option value="c">c</option>
            <option value="d">d</option>
        </select>
        <select name="role" id="">
            <option disabled hidden selected>role</option>
            <option value="admin">admin</option>
            <option value="user">user</option>
        </select>
        <button type="submit">submit</button>
    </form>
</div>
@endsection
@extends('layouts.main')

@section('content')
<div class="container-login w-full flex flex-col justify-center items-center">
    <h1>add account</h1>
    <form action="{{route('account.insert')}}" method="post" class="flex flex-col space-y-5 w-2/3">
        @csrf

        <input type="text" name="fullname" placeholder="fullname" class="@error('fullname') is-invalid @enderror" autofocus value="{{old('fullname')}}">
        @error('fullname')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
        <input type="email" name="email" id="" placeholder="email" class="@error('email') is-invalid @enderror()" value="{{old('email')}}">
        @error('email')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
        <input type="tel" name="phone_number" id="" placeholder="phone number" class="@error('phone_number') is-invalid @enderror()" value="{{old('phone_number')}}"> 
        @error('phone_number')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
        <select name="position" id="" class="@error('position') is-invalid @enderror()" value="{{old('position')}}">
            <option disabled hidden selected>position</option>
            <option value="a">a</option>
            <option value="b">b</option>
            <option value="c">c</option>
            <option value="d">d</option>
        </select>
        @error('position')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
        <select name="job" id="" class="@error('email') is-invalid @enderror()" value="{{old('job')}}">
            <option disabled hidden selected>job</option>
            <option value="a">a</option>
            <option value="b">b</option>
            <option value="c">c</option>
            <option value="d">d</option>
        </select>
        @error('job')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
        <select name="role" id="" class="@error('email') is-invalid @enderror()" value="old{{'role'}}">
            <option disabled hidden selected>role</option>
            <option value="admin">admin</option>
            <option value="user">user</option>
        </select>
        @error('role')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
        <button type="submit">submit</button>
    </form>
</div>
@endsection
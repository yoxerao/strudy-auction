@extends('layouts.app')

@section('title', 'adminLogin')

@section('content')
<!-- Login basic -->
<div class=formulario>
    @if(\Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <div class="alert-body">
            {{ \Session::get('success') }}
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    {{ \Session::forget('success') }}
    @if(\Session::get('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <div class="alert-body">
            {{ \Session::get('error') }}
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <form method="POST" action="{{ route('adminLoginPost') }}">
        {{ csrf_field() }}

        <label for="username">Username</label>
        <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus>
        @if ($errors->has('username'))
        <span class="error">
            {{ $errors->first('username') }}
        </span>
        @endif

        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>
        @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
        @endif

        <div class="pt-5">
            <button type="submit" class="btn btn-danger">Login</button>
        </div>
        <a class="btn btn-danger btn-lg height_btn" href="{{ route('login') }}">Login as User</a>

    </form>
</div>
@endsection
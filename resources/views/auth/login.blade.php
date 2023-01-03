@extends('layouts.app')

@section('content')
<div class=formulario>

    <form method="POST" action="{{ route('login') }}">
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

        <label>
            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
        </label>

        <div class="submit pt-5">
            <button type="submit" class="btn btn-danger">Login</button>
        </div>
        <a class="btn btn-danger btn-lg height_btn" href="{{ route('adminLogin') }}">Login as Admin</a>
        <a class="btn btn-danger btn-lg height_btn" href="{{ route('register') }}">Register</a>
        <a class="btn btn-danger btn-lg height_btn" href="{{ route('showLinkForm') }}">Forgot Password</a>

    </form>
</div>

@endsection
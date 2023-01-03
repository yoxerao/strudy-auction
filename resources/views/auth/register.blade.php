@extends('layouts.app')

@section('content')
<div class=formulario>

  <form method="POST" action="{{ route('register') }}">
    {{ csrf_field() }}

    <label for="name">Name</label>
    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
    @if ($errors->has('name'))
    <span class="error">
      {{ $errors->first('name') }}
    </span>
    @endif

    <label for="username">Username</label>
    <input id="username" type="text" name="username" value="{{ old('username') }}" required>
    @if ($errors->has('username'))
    <span class="error">
      {{ $errors->first('username') }}
    </span>
    @endif

    <label for="email">E-Mail Address</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
    @if ($errors->has('email'))
    <span class="error">
      {{ $errors->first('email') }}
    </span>
    @endif

    <label for="password">Password</label>
    <input id="password" type="password" name="password" required>
    @if ($errors->has('password'))
    <span class="error">
      {{ $errors->first('password') }}
    </span>
    @endif

    <label for="password-confirm">Confirm Password</label>
    <input id="password-confirm" type="password" name="password_confirmation" required>

    <button class="btn btn-danger btn-lg" type="submit">
      Register
    </button>
    <a class="btn btn-danger btn-lg" href="{{ route('login') }}">Login</a>
  </form>
</div>
@endsection
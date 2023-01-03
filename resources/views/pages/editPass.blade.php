@extends('layouts.app')

@section('title', "editPass")

@section('content')
<div class=formulario>
  <form method="POST" action="{{ route('editPass', ['id' => $user['id']]) }}">

    @method('PUT')
    {{ csrf_field() }}

    <label for="password">Password</label>
    <input id="password" type="password" name="password" required>
    @if ($errors->has('password'))
    <span class="error">
      {{ $errors->first('password') }}
    </span>
    @endif

    <label for="password-confirm">Confirm Password</label>
    <input id="password-confirm" type="password" name="password_confirmation" required>

    <div class="pt-5">
      <button type="submit" class="btn btn-danger"> Submit </button>
    </div>

  </form>
</div>
@endsection
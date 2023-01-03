@extends('layouts.app')

@section('content')
<div class="formulario">
  <form method="POST" action="{{ route('showLinkForm') }}">
    {{ csrf_field() }}

    <label for="email">E-Mail Address</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    @if ($errors->has('email'))
    <span class="error">
      {{ $errors->first('email') }}
    </span>
    @endif

    <div class="pt-5">
      <button type="submit" class="btn btn-danger">Send</button>
    </div>

  </form>
</div>

@endsection
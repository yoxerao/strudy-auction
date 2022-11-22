@extends('layouts.app')

@section('content')
<from method="POST" action="{{ route('showLinkForm') }}">
  {{ csrf_field() }}

  <label for="email">E-Mail Address</label>
  <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
  @if ($errors->has('email'))
  <span class="error">
    {{ $errors->first('email') }}
  </span>
  @endif

  <button type="submit">
    Send
  </button>

</from>

@endsection
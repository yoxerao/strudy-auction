@extends('layouts.app')

@section('title', "editProfile")

@section('content')

<form method="POST" action="{{ route('editProfile', ['id' => $user['id']]) }}">

    @method('PUT')
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

    <button type="submit"> Submit </button>

</form>
@endsection
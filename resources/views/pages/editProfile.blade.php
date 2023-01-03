@extends('layouts.app')

@section('title', "editProfile")

@section('content')
<div class=formulario>

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

        <div class="pt-5">
            <button type="submit" class="btn btn-danger">Submit</button>
        </div>

    </form>
</div>
@endsection
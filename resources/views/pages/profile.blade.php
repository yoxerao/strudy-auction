@extends('layouts.app')

@section('title', 'userInfo')

@section('content')
@if (Auth::check() && Auth::id() != $user['id'])
    <button class="button button-outline" onclick="window.location.href='/user/{{ $user['id'] }}/report'">Report User</button>
@endif

<section id='userInfo'>
    <h4 class="text-center">name: {{ $user['name'] }}</h4>
    <h4 class="text-center">email: {{ $user['email'] }}</h4>
    <h4 class="text-center">username: {{ $user['username'] }}</h4>
    <h4 class="text-center">rating: {{ $user['rating'] }}</h4>
    <h4 class="text-center">balance: {{ $user['balance'] }}</h4>
    
    
    @if ($user['id'] == Auth::user()->id)
        <a class="button button-outline" href="{{ route('editUser', ['id' => $user['id']]) }}">Edit profile</a>
        <a class="button button-outline" href="{{ route('editPass', ['id' => $user['id']]) }}">Change password</a>
        <a class="button button-outline" href="{{ route('depositForm', ['id' => $user['id']]) }}">Deposit into account</a>
    @endif
</section>
@endsection
@extends('layouts.app')

@section('title', 'userInfo')

@section('content')
@if (Auth::check() && Auth::id() != $user['id'])
<div class="col-md-12 text-center">
    <button class="btn btn-danger" onclick="window.location.href='/user/{{ $user['id'] }}/report'">Report User</button>
</div>
@endif

<section id='userInfo'>
    <div class="d-flex flex-column align-items-center justify-content-between">
        <div class="text-left text_size">name: {{ $user['name'] }}</div>
        <div class="text-left text_size">email: {{ $user['email'] }}</div>
        <div class="text-left text_size">username: {{ $user['username'] }}</div>
        <div class="text-left text_size">rating: {{ $user['rating'] }}</div>
        <div class="text-left text_size">balance: {{ $user['balance'] }}</div>
        
    
    @if ($user['id'] == Auth::user()->id)
        <div class="pt-5">
            <a class="btn btn-danger btn-lg" href="{{ route('editUser', ['id' => $user['id']]) }}">Edit profile</a>
            <a class="btn btn-danger btn-lg" href="{{ route('editPass', ['id' => $user['id']]) }}">Change password</a>
            <a class="button button-outline" href="{{ route('depositForm', ['id' => $user['id']]) }}">Deposit into account</a>
        </div>
    @endif        
    </div>
</section>
@endsection
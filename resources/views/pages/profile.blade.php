@extends('layouts.app')

@section('title', 'userInfo')

@section('content')
<section id='userInfo'>
    <h4 class="text-center">name: {{ $user['name'] }}</h4>
    <h4 class="text-center">email: {{ $user['email'] }}</h4>
    <h4 class="text-center">username: {{ $user['username'] }}</h4>
    <h4 class="text-center">rating: {{ $user['rating'] }}</h4>
    <h4 class="text-center">balance: {{ $user['balance'] }}</h4>
    
    <a class="button button-outline" href="{{ route('editUser', ['id' => $user['id']]) }}">Edit profile</a>

</section>
@endsection
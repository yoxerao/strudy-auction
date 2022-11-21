@extends('layouts.app')

@section('title', 'userInfo')

@section('content')
<section id='userInfo'>
    <h4 class="text-center my-0 py-0">name: {{ $user['name'] }}</h4>
    <h4 class="text-center my-0 py-0">email: {{ $user['email'] }}</h4>
    <h4 class="text-center my-0 py-0">username: {{ $user['username'] }}</h4>
    <h4 class="text-center my-0 py-0">rating: {{ $user['rating'] }}</h4>
    <h4 class="text-center my-0 py-0">balance: {{ $user['balance'] }}</h4>
    
</section>
@endsection
@extends('layouts.app')

@section('title', 'userInfo')

@section('content')
<section id='userInfo'>
    <h4 class="text-center my-0 py-0">{{ $user['name'] }}</h4>
    <h4 class="text-center my-0 py-0">{{ $user['email'] }}</h4>
    <h4 class="text-center my-0 py-0">{{ $user['username'] }}</h4>
    <h4 class="text-center my-0 py-0">{{ $user['rating'] }}</h4>
    <h4 class="text-center my-0 py-0">{{ $user['balance'] }}</h4>
    
</section>
@endsection
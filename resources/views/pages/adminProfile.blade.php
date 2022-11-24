@extends('layouts.app')

@section('title', 'adminInfo')

@section('content')
<section id='adminInfo'>
    <h4 class="text-center">name: {{ $admin['name'] }}</h4>
    <h4 class="text-center">email: {{ $admin['email'] }}</h4>
    <h4 class="text-center">username: {{ $admin['username'] }}</h4>
    
</section>
@endsection
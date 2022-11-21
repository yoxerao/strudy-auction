@extends('layouts.app')

@section('userInfo')
    <section id='userInfo'>
        <from method="GET" action="{{ route('userProfile') }}">
            <h2 class="text-center my-0 py-0">{{ $user['name'] }}</h2>
            <h2 class="text-center my-0 py-0">{{ $user['email'] }}</h2>
            <h2 class="text-center my-0 py-0">{{ $user['username'] }}</h2>
            <h2 class="text-center my-0 py-0">{{ $user['email'] }}</h2>
            <h2 class="text-center my-0 py-0">{{ $user['rating'] }}</h2>
            <h2 class="text-center my-0 py-0">{{ $user['balance'] }}</h2>
        </from>
    </section>    
@endsection
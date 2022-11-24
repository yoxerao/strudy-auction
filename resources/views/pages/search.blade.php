@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
    <section id="search">
        <h1 class="text-center">Search Results</h1>
        <form class="form-inline my-2 my-lg-0" method="get" action="{{route('search')}}">
            <input class="form-control mr-sm-2" name = "query" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </section>
    <section id="users">
        @if (count($users) > 0)
            <h2>Users</h2>
            <ul>
                @foreach($users as $user)
                    <h4><a href="/user/{{$user->id}}">{{$user->name}}</a></h4>
                @endforeach
            </ul>

        @else
            <h2>No users found</h2>
        @endif
    </section>
@endsection
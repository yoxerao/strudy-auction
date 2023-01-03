@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
<section id="search">
    <div class="p-5">
        <h1 class="text-center">Search Results</h1>
        <form class="form-inline my-2 my-lg-0" method="get" action="{{route('search')}}">
            <input class="form-control mr-sm-2" name="query" type="search" placeholder="Search" aria-label="Search">
        </form>
    </div>
</section>
<section class="text-danger" id="users">
    <div class="p-5">
        @if (count($users) > 0)
        <h2>Users</h2>
        <ul>
            @foreach($users as $user)
            <h4><a class="text-dark" href="/user/{{$user->id}}">{{$user->name}}</a></h4>
            @endforeach
        </ul>

        @else
        <h2>No users found</h2>
        @endif
    </div>
</section>
<section class="text-danger" id="auctions">
    <div class="p-5">
        @if (count($auctions) > 0)
        <h2>Auctions</h2>
        <ul>
            @foreach($auctions as $auction)
            <h4><a class="text-dark" href="/auctions">{{$auction->name}}</a></h4>
            @endforeach
        </ul>

        @else
        <h2>No auctions found</h2>
        @endif
    </div>
</section>
@endsection
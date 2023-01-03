@extends('layouts.app')

@section('title', 'Home Page')

@section('content')

<section id="header">
    <h1 class="text-center">Welcome to the home page</h1>
    <form class="form-inline my-2 my-lg-0" method="get" action="{{route('search')}}">
        <input class="form-control mr-sm-2" name = "query" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
    <br>
    <button class="button button-outline" onclick="window.location.href='/auctions'">All Auctions</button>
</section>

@endsection
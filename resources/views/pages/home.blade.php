@extends('layouts.app')

@section('title', 'Home Page')

@section('content')

<section id="header">
    <div>
        <div class="text_search">
            <h1 class="text-center">Discover new products and create your auctions</h1>
        </div>
        <div class="search-forms">
            <form class="form-inline my-2 my-lg-0" method="get" action="{{route('search')}}">
                <input class="form-control mr-sm-2" name="query" type="search" placeholder="Search" aria-label="Search">
            </form>
            <!-- <form class="form-inline my-2 my-lg-0" method="get" action="{{route('search')}}">
                <input class="form-control mr-sm-2" name="query" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form> -->
        </div>
    </div>
    <div class="p-5">
        <button class=" btn btn-danger btn-lg" onclick=" window.location.href='/auctions'">All Auctions</button>
    </div>
</section>

@endsection
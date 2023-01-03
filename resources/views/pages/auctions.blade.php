@extends('layouts.app')

@section('title', 'Auctions')

@section('content')

<section id="auctions">

    <section id="search-bar">
    <form class="form-inline my-2 my-lg-0" method="get" action="{{route('search')}}">
        <input class="form-control mr-sm-2" name = "query" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
    </section>
    
    <a href="/auction/create">
        <button> Create Auction </button>
    </a>
    
    <section id="list-auctions">
    @foreach ($auctions as $auction)
        <article class="auction">
            <a href="/auction/{{ $auction->id }}" > <h1> {{ $auction->name }} </h1> </a>
            <div class="timer" data-end-date="{{$auction->end_date}}">
            </div>
            <br>
            <p>{{ $auction->description }}</p>
            <p>Buyout: {{ $auction->buyout_value }}</p>
            <p>Min Bid: {{ $auction->min_bid }}</p>
            <p>Winner: {{ $auction->winner }}</p>

        </article>
    @endforeach
    </section>
</section>

@endsection
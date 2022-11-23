@extends('layouts.app')

@section('title', 'Auctions')

@section('content')

<section id="auctions">
    <a href="/auction/create">
        <button> Create Auction </button>
    </a>
    @foreach ($auctions as $auction)
        <article class="auction">
            <h1>{{ $auction->name }}</h1>
            <p>{{ $auction->description }}</p>
            <p>Buyout: {{ $auction->buyout_value }}</p>
            <p>Min Bid: {{ $auction->min_bid }}</p>
            <p>Start Date: {{ $auction->start_date }}</p>
            <p>End Date: {{ $auction->end_date }}</p>
            <p>Winner: {{ $auction->winner }}</p>
            <p>Owner: {{ $auction->owner }}</p>
            <a href="/auction/edit/{{ $auction->id }}">
                <button> Edit or Delete Auction </button>
            </a>
            <p></p>
            <a href="/bid/makeBid/{{ $auction->id }}">
                <button> Make Bid </button>
            </a>
        </article>
    @endforeach
</section>

@endsection
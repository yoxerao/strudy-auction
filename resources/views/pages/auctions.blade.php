@extends('layouts.app')

@section('title', 'Auctions')

@section('content')

<section id="auctions">
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
        </article>
</section>

@endsection
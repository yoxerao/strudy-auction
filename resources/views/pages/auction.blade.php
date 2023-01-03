@extends('layouts.app')

@section('title', 'Auctions')

@section('content')

<section id=auction>
    <article class="auction">
        <h1>{{ $auction['name'] }}</h1>
        <p>{{ $auction['description'] }}</p>
        <p>Buyout: {{ $auction['buyout_value'] }}</p>
        <p>Min Bid: {{ $auction['min_bid'] }}</p>
        <p>Start Date: {{ $auction['start_date'] }}</p>
        <p>End Date: {{ $auction['end_date'] }}</p>
        <p>Winner: {{ $auction['winner'] }}</p>
        <p>Owner: {{ $auction['user_id'] }}</p>
        <a href="/auction/edit/{{ $auction['id'] }}">
            <button> Edit or Delete Auction </button>
        </a>
        <p></p>
        <a href="/bid/makeBid/{{ $auction['id'] }}">
            <button> Make Bid </button>
        </a>
    </article>
</section>

<section id=commment>
    <h4> Comments </h4>
@foreach ($comments as $comment)

    <article class="comment">
        <p>Author: {{ $comment['author'] }}</p>
        <p>Date: {{ $comment['creation_date'] }}</p>
        <p>Text: {{ $comment['content'] }}</p>
    </article>
@endforeach

<form method="POST" action="{{ route('createComment') }}">
    {{ csrf_field() }}
    <input type="hidden" name="id_auction" value="{{  $auction['id'] }}" />
    <label for="content">Text</label>
    <input id="content" type="text" name="content" value="{{ old('content') }}" required autofocus>
    @if ($errors->has('content'))
    <span class="error">
        {{ $errors->first('content') }}
    </span>
    @endif
    <button type="submit">
      Submit
    </button>
</from>
</section>
@endsection


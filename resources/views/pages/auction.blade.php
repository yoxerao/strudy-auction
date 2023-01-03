@extends('layouts.app')

@section('title', 'Auctions')

@section('content')

<section id=auction>
    <article class="auction">
        <h1>{{ $auction['name'] }}</h1>
        <div class="timer" data-end-date="{{$auction['end_date']}}"></div>
        <p>{{ $auction['description'] }}</p>
        <p>Buyout: {{ $auction['buyout_value'] }}</p>
        <p>Min Bid: {{ $auction['min_bid'] }}</p>
        <p>Winner: {{ $auction['winner'] }}</p>
        <p>Owner: {{ $auction['user_id'] }}</p>
        <a href="/auction/edit/{{ $auction['id'] }}">
            <button> Edit or Delete Auction </button>
        </a>
        <p></p>
        <a href="/bid/makeBid/{{ $auction['id'] }}">
            <button> Make Bid </button>
        </a>
        <form action="{{ route('deleteBid', $auction['id']) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Remove Bid</button>
        </form>
    </article>
</section>

<section id=commment>
    <h3> Comments </h3>
@foreach ($comments as $comment)
    <article class="comment">
        <p>Author: {{ $comment['author'] }}</p>
        <p>Date: {{ $comment['creation_date'] }}</p>
        <p>Text: {{ $comment['content'] }}</p>
        <form method="POST" action="{{ route('deleteComment', $comment->id) }}">
            @csrf
            @method('DELETE')
            <input type="hidden" name="id_auction" value="{{  $auction['id'] }}" />
            <button type="submit" class="btn btn-xs btn-danger btn-flat show_confirm" data-toggle="tooltip" title='Delete'>
                Delete
            </button>
        </form>
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


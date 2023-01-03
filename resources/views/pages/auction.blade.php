@extends('layouts.app')

@section('title', 'Auctions')

@section('content')

<section id=auction>
    <div class="p-3 m-3">
        <article class="auction">
            <h1>{{ $auction['name'] }}</h1>
            <div class="timer" data-end-date="{{$auction['end_date']}}"></div>
            <p>{{ $auction['description'] }}</p>
            <p>Buyout: {{ $auction['buyout_value'] }}</p>
            <p>Min Bid: {{ $auction['min_bid'] }}</p>
            <p>Winner: {{ $auction['winner'] }}</p>
            <p>Owner: {{ $auction['user_id'] }}</p>
            <div class="p-2 m-2 row">
                <div class="col-md-2 ps-2">
                    <a href="/auction/edit/{{ $auction['id'] }}">
                        <button class="btn btn-danger"> Edit or Delete Auction </button>
                    </a>
                </div>
                <div class="col-md-2 ps-2">
                    <a href="/bid/makeBid/{{ $auction['id'] }}">
                        <button class="btn btn-danger"> Make Bid </button>
                    </a>
                </div>
                <div class="col-md-6 ps-2">
                    <form action="{{ route('deleteBid', $auction['id']) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Remove Bid</button>
                    </form>
                </div>
            </div>
        </article>
    </div>
</section>

<section id=commment>
    <div class="p-2">
        <h3> Comments </h3>
        @foreach ($comments as $comment)
        <div class="card">
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
        </div>
    </div>
    @endforeach
    <div class="p-2">
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
            <button type="submit" class="btn btn-danger">
                Submit
            </button>
        </form>
    </div>
</section>
@endsection
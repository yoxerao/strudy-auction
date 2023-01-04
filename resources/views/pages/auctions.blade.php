@extends('layouts.app')

@section('title', 'Auctions')

@section('content')

<section id="auctions">

    <section id="search-bar">
        <form class="form-inline my-2 my-lg-0" method="get" action="{{route('search')}}">
            <input class="form-control mr-sm-2" name="query" type="search" placeholder="Search" aria-label="Search">
        </form>
    </section>

    <div class="createAuctionButton p-2">
        <a href="/auction/create">
            <button class="btn btn-danger"> Create Auction </button>
        </a>
    </div>


    <section id="list-auctions">
        <div class="p-1">
            @foreach ($auctions as $auction)
            <div class="card p-3 m-3">
                <article class="auction">
                    <a href="/auction/{{ $auction->id }}">
                        <h1 class="text-dark"> {{ $auction->name }} </h1>
                    </a>
                    <div class="timer" data-end-date="{{$auction->end_date}}">
                    </div>
                    <br>
                    <p>{{ $auction->description }}</p>
                    <p>Buyout: {{ $auction->buyout_value }}</p>
                    <p>Min Bid: {{ $auction->min_bid }}</p>
                    <p>Winner: {{ $auction->winner }}</p>
                    
                        
                            
           
                <div>
                    @if (Auth::id() == $auction->user_id)
                        <div class="p-3 m-3">
                            <a href="/auction/edit/{{ $auction->id }}">
                                <button class="btn btn-danger"> Edit or Delete Auction </button>
                            </a>
                        </div> 
                    @endif
                    @if(Auth::check())
                        <div class="p-3 m-3">
                            <a href="/bid/makeBid/{{ $auction->id }}">
                                <button class="btn btn-danger"> Make Bid </button>
                            </a>
                        </div>
                    @endif
                </div>
                @if(Auth::check())
                    <div class="p-3 m-3">
                        <form action="{{ route('deleteBid', $auction->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">Remove Bid</button>
                        </form>
                    </div>
                    <form action="{{ route('followAuction', $auction->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Follow Auction</button>
                    </form>
                @endif
            
                <a href="/auction/followers/{{ $auction->id }}">
                    <button> See Auction Followers </button>
                </a>
            </article>
            </div>
            @endforeach
        </div>
    </section>

</section>
@endsection
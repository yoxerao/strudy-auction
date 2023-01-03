@extends('layouts.app')

@section('title', 'Followers')

@section('content')

<section id="followers">
    
    <section id="list-followers">
        <h1>Auction Followers</h1>
    @foreach ($followers as $follower)
        <article class="follower">
            <p>{{ $follower->id_user }}</p>
        </article>
    @endforeach
    </section>
    <a href="/auctions">
        <button> Back </button>
    </a>
</section>  
@endsection
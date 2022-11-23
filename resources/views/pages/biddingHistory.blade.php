@extends('layouts.app')

@section('title', 'Bidding History')

@section('content')

<section id="biddingHistory">
    <table class="table table-striped">
    @if(count($bids) > 0)
        @foreach($bids as $bid)
            <tr>
                <td><a href="/auction/{{$bid->id_auction}}">{{$bid->id_auction}}</a></td>
                <td>{{$bid->value}}</td>
                <td>{{$bid->date}}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td>No bids</td>
        </tr>
    @endif
    </table>
</section>
@endsection
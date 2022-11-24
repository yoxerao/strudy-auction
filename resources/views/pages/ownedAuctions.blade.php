@extends('layouts.app')

@section('title', 'Owned Auctions')

@section('content')

<section id="ownedAuctions">
    <table class="table table-striped">
    @if(count($auctions) > 0)
        @foreach($auctions as $auction)
            <tr>
                <td><a href="/auction/{{$auction->id}}">{{$auction->name}}</a></td>
                <td>{{$auction->description}}</td>
                <td>{{$auction->start_date}}</td>
                <td>{{$auction->end_date}}</td>
                <td>{{$auction->winner}}</td>
                <td>{{$auction->owner}}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td>No auctions</td>
        </tr>
    @endif
    </table>
@endsection
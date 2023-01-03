@extends('layouts.app')

@section('title', 'Admin Home Page')

@section('content')


<section id="content">
    <h1 class="text-center">Welcome to the admin page</h1>
    <form class="form-inline my-2 my-lg-0" method="get" action="{{route('search')}}">
        <input class="form-control mr-sm-2" name = "query" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
    <br>
    <section id="reports">

        @if (count($reports) > 0)
            <h2>Reports</h2>
            <ul>
                @foreach($reports as $report)
                    @php
                        $reported = App\Models\User::find($report->reported);
                    @endphp
                    <div>
                        <h4><a href="/user/{{$reported->id}}">{{$reported->name}}</a></h4>
                        <p>{{$report->reason}}</p>
                        <br>
                        <form method="POST" action="{{ route('validateBan') }}">
                            @csrf
                            <input type="hidden" name="administrator" value="{{ Auth::guard('admin')->user()->id }}">
                            <input type="hidden" name="report" value="{{ $report->id }}">
                            <input type="hidden" name="banned" value="1">
                            <button type="submit">Ban user</button>
                        </form>
                        <form method="POST" action="{{ route('validateBan') }}">
                            @csrf
                            <input type="hidden" name="administrator" value="{{ Auth::guard('admin')->user()->id }}">
                            <input type="hidden" name="report" value="{{ $report->id }}">
                            <input type="hidden" name="banned" value="0">
                            <button type="submit">Ignore Request</button>
                        </form>
                    </div>
                @endforeach
            </ul>

        @else
            <h2>No reports found</h2>
        @endif
    </section>

</section>


@endsection
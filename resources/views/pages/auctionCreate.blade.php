@extends('layouts.app')

@section('name', 'Auction')

@section('content')
<div class=formulario>

  <form method="POST" action="{{ route('createAuction') }}">
    {{ csrf_field() }}

    <label for="name">Name</label>
    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
    @if ($errors->has('name'))
    <span class="error">
      {{ $errors->first('name') }}
    </span>
    @endif

    <label for="buyout_value">Buyout Value</label>
    <input id="buyout_value" type="number" step=0.01 name="buyout_value" value="{{ old('buyout_value') }}" required>
    @if ($errors->has('buyout_value'))
    <span class="error">
      {{ $errors->first('buyout_value') }}
    </span>
    @endif

    <label for="min_bid">Minimum Bid</label>
    <input id="min_bid" type="number" step=0.01 name="min_bid" value="{{ old('min_bid') }}" required>
    @if ($errors->has('min_bid'))
    <span class="error">
      {{ $errors->first('min_bid') }}
    </span>
    @endif

    <label for="description">Description</label>
    <input id="description" type="text" name="description">
    @if ($errors->has('description'))
    <span class="error">
      {{ $errors->first('description') }}
    </span>
    @endif

    <label for="start_date">Start Date</label>
    <input id="start_date" type="datetime-local" name="start_date" required>
    @if ($errors->has('start_date'))
    <span class="error">
      {{ $errors->first('start_date') }}
    </span>
    @endif

    <label for="end_date">End Date</label>
    <input id="end_date" type="datetime-local" name="end_date" required>
    @if ($errors->has('end_date'))
    <span class="error">
      {{ $errors->first('end_date') }}
    </span>
    @endif

    <div class="pt-5">
      <button type="submit" class="btn btn-danger">Create</button>
    </div>
  </form>
</div>
@endsection
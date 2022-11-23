@extends('layouts.app')

@section('title', '$auction->name')

@section('content')
<form method="POST" action="{{ route('makeBid', ['id' => $auction->id]) }}">
    {{ csrf_field() }}

    <label for="value">Value</label>
    <input id="value" type="number" name="value" value="{{ old('value') }}" required>
    @if ($errors->has('value'))
      <span class="error">
          {{ $errors->first('value') }}
      </span>
    @endif

    <button type="submit">
      Bid
    </button>
</form>
@endsection
@extends('layouts.app')

@section('title', '$auction->name')

@section('content')
<div class=formulario>
  <form method="POST" action="{{ route('makeBid', ['id' => $auction->id]) }}">
    {{ csrf_field() }}

    <label for="value">Value</label>
    <input id="value" type="number" step=0.01 name="value" value="{{ old('value') }}" required>
    @if ($errors->has('value'))
    <span class="error">
      {{ $errors->first('value') }}
    </span>
    @endif
    <div class="pt-5">
      <button type="submit" class="btn btn-danger">
        Bid
      </button>
    </div>
  </form>
</div>
@endsection
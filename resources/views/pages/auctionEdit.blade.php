@extends('layouts.app')

@section('title', '$auction->name')

@section('content')
<div class=formulario>

  <form method="POST" action="{{ route('editAuction', ['id' => $auction->id]) }}">
    @method('PUT')
    {{ csrf_field() }}


    <label for="name">Name</label>
    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
    @if ($errors->has('name'))
    <span class="error">
      {{ $errors->first('name') }}
    </span>
    @endif

    <label for="description">Description</label>
    <input id="description" type="text" name="description">
    @if ($errors->has('description'))
    <span class="error">
      {{ $errors->first('description') }}
    </span>
    @endif

    <div class="pt-5">
      <button type="submit" class="btn btn-danger">Save</button>
    </div>
  </form>

  <form method="POST" action="{{ route('deleteAuction', $auction->id) }}">

    @csrf
    @method('DELETE')

    <button type="submit" class="btn btn-xs btn-danger btn-flat show_confirm" data-toggle="tooltip" title='Delete'>
      Delete
    </button>
  </form>
</div>
@endsection
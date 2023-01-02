
@extends('layouts.app')

@section('title', 'report user')

@section('content')


    <section id="content">
        <form action="/user/{{ $user->id }}/report" method="POST">
            @csrf
            <label for="reason">Provide a reason for the report:</label>
            <textarea name="reason" id="reason"></textarea>
            <br>
            <button type="submit">Report User</button>
        </form>
    </section>
    

@endsection
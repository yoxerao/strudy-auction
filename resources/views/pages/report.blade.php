@extends('layouts.app')

@section('title', 'report user')

@section('content')


<section id="content">
    <div class="formulario">
        <form action="/user/{{ $user->id }}/report" method="POST">
            @csrf
            <label for="reason">Provide a reason for the report:</label>
            <textarea name="reason" id="reason"></textarea>
            <br>

            <div class="pt-5">
                <button type="submit" class="btn btn-danger">Report User</button>
            </div>
        </form>
    </div>
</section>


@endsection
@extends('layouts.main')

@section('content')
    <div class="onepost">
        <h3>Good work!</h3>
        <p>{{ $route_name }}</p>
    </div>
    <div class="onepost">
        <h3>Good work!</h3>
        <p>{{ $route_name }}</p>
    </div>
    <div class="onepost">
        <h3>Good work!</h3>
        <p>{{ $route_name }}</p>
    </div>
    <div class="onepost">
        <h3>Good work!</h3>
        <p>{{ $route_name }}</p>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Exit</button>
    </form>
@endsection
@extends('layouts.exception')

@section('content')
    <div class="exception-403">
        <div class="exception-403-caption">
            <h2>{{ __($exception->getMessage()) }}</h2>
        </div>
    </div>
@endsection
@extends('layouts.exception')

@section('content')
    <div class="exception-wrapper">
        <div class="big-caption">403</div>
        <div class="small-caption">{{ __('error') }}</div>
        <div class="exception-danger">
            <h2>{{ __($exception->getMessage()) }}</h2>
        </div>
    </div>
@endsection
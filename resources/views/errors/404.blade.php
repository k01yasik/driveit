@extends('layouts.exception')

@section('content')
    <div class="navigation-wrapper-404">
        @include('components.navigation')
    </div>
    <div class="exception-wrapper">
        <div class="big-caption-404">{{ __('Are you sure the page was here?') }}</div>
    </div>
@endsection
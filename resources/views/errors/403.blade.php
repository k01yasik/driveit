@extends('layouts.main')

@section('content')
    <div class="exception-wrapper">
        <div class="exception-danger">
            @if ($exception->getMessage() === 'User is not logged in.')
                <h2>{{ __('User is not logged in.') }}</h2>
            @endif
        </div>
    </div>
@endsection
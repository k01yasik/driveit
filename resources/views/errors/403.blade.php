@extends('layouts.main')

@section('content')
    <div class="exception-danger">
        <p>{{ $exception->getMessage() }}</p>
    </div>
@endsection
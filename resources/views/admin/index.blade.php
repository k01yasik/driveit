@extends('layouts.admin')

@section('content')
    @include('admin.components.panel')
    <div class="right-panel">
        <div class="breadcrumbs">
            <ul>
                <li>{{ __('Number of articles published by month and year') }}</li>
            </ul>
        </div>
        <canvas id="postChart" class="post-chart"></canvas>
    </div>
@endsection
@extends('layouts.admin')

@section('content')
    @include('admin.components.panel')
    <div class="right-panel">
        <div class="breadcrumbs">
            <ul>
                <li>{{ __('Number of articles published by month and year') }}</li>
            </ul>
        </div>
        <div class="canvas-wrapper">
            <canvas id="postChart" class="post-chart"></canvas>
        </div>
        <div class="breadcrumbs margin-top">
            <ul>
                <li>{{ __('Total number of comments for all time') }}</li>
            </ul>
        </div>
        <div class="canvas-wrapper">
            <canvas id="commentsChart" class="comments-chart"></canvas>
        </div>
        <div class="breadcrumbs margin-top">
            <ul>
                <li>{{ __('The number of users in the last month') }}</li>
            </ul>
        </div>
        <div class="canvas-wrapper">
            <canvas id="usersChart" class="comments-chart"></canvas>
        </div>
        <div class="breadcrumbs margin-top">
            <ul>
                <li>{{ __('Distribution of users by country in the last month') }}</li>
            </ul>
        </div>
        <div class="canvas-wrapper">
            <canvas id="countryChart" class="country-chart"></canvas>
        </div>
        <div class="breadcrumbs margin-top">
            <ul>
                <li>{{ __('Distribution of users from Russia by city for the last month') }}</li>
            </ul>
        </div>
        <div class="canvas-wrapper">
            <canvas id="cityChart" class="country-chart"></canvas>
        </div>
    </div>
@endsection
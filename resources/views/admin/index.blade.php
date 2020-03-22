@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col s12 m4 l3 sm-margin-bottom-2">
            @include('admin.components.panel')
        </div>
        <div class="col s12 m8 l9">
            <div class="right-panel">
                <div class="canvas-wrapper">
                    <canvas id="postChart" class="post-chart"></canvas>
                </div>
                <div class="breadcrumbs no-top-border-radius flex flex-v-center">
                    <ul class="flex flex-v-center">
                        <li class="flex flex-v-center">{{ __('Number of articles published by month and year') }}</li>
                    </ul>
                </div>
                <div class="canvas-wrapper">
                    <canvas id="commentsChart" class="comments-chart"></canvas>
                </div>
                <div class="breadcrumbs no-top-border-radius margin-top flex flex-v-center">
                    <ul class="flex flex-v-center">
                        <li class="flex flex-v-center">{{ __('Total number of comments for all time') }}</li>
                    </ul>
                </div>
                <div class="canvas-wrapper">
                    <canvas id="usersChart" class="comments-chart"></canvas>
                </div>
                <div class="breadcrumbs no-top-border-radius margin-top flex flex-v-center">
                    <ul class="flex flex-v-center">
                        <li class="flex flex-v-center">{{ __('The number of users in the last month') }}</li>
                    </ul>
                </div>
                <div class="canvas-wrapper">
                    <canvas id="countryChart" class="country-chart"></canvas>
                </div>
                <div class="breadcrumbs no-top-border-radius margin-top flex flex-v-center">
                    <ul class="flex flex-v-center">
                        <li class="flex flex-v-center">{{ __('Distribution of users by country in the last month') }}</li>
                    </ul>
                </div>
                <div class="canvas-wrapper">
                    <canvas id="cityChart" class="country-chart"></canvas>
                </div>
                <div class="breadcrumbs no-top-border-radius last-child margin-top flex flex-v-center">
                    <ul class="flex flex-v-center">
                        <li class="flex flex-v-center">{{ __('Distribution of users from Russia by city for the last month') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
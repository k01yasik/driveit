@extends('layouts.admin')

@section('admin-title', __('Dashboard'))

@section('content')
    <div class="admin-chart-grid">
        @foreach ([
            'postChart' => __('Number of articles published by month and year'),
            'commentsChart' => __('Total number of comments for all time'),
            'usersChart' => __('The number of users in the last month'),
            'countryChart' => __('Distribution of users by country in the last month'),
            'cityChart' => __('Distribution of users from Russia by city for the last month'),
        ] as $chartId => $label)
            <section class="admin-chart" aria-labelledby="{{ $chartId }}-label">
                <h2 id="{{ $chartId }}-label">{{ $label }}</h2>
                <canvas id="{{ $chartId }}" role="img" aria-labelledby="{{ $chartId }}-label"></canvas>
            </section>
        @endforeach
    </div>
@endsection

@push('admin-scripts')
    <x-googleanalytics :posts="$posts" :commentsVerified="$commentsVerified" :commentsNotVerified="$commentsNotVerified" />
@endpush

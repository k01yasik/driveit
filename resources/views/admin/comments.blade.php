@extends('layouts.admin')

@section('admin-title', __('Comments'))

@section('content')
    @include('admin.components.breadcrumbs', [
        'items' => [
            ['route' => 'admin.index', 'label' => __('Dashboard')],
            ['label' => __('Comments')],
        ]
    ])

    @include('admin.comments.partials.filters')

    @if ($comments->isEmpty())
        <div class="empty-state">
            <p>{{ __('No comments found') }}</p>
        </div>
    @else
        <div class="comments-list">
            @foreach ($comments as $comment)
                @include('admin.comments.partials.comment-item', compact('comment'))
            @endforeach
        </div>

        @include('components.pagination', ['paginator' => $comments])
    @endif
@endsection

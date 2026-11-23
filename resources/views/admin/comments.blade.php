@extends('layouts.admin')

@section('admin-title', __('Comments'))

@section('content')
    @include('admin.components.breadcrumbs', [
        'items' => array_filter([
            ['route' => 'admin.index', 'label' => __('Home')],
            ['label' => __('Comments')],
            $unpublish_comments_count > 0 ? [
                'route' => 'admin.comments.unpublished',
                'label' => __('Unpublished comments'),
                'badge' => $unpublish_comments_count
            ] : null
        ])
    ])

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

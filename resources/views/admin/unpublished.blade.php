@extends('layouts.admin')

@section('admin-title', __('Unpublished comments'))

@section('content')
    @include('admin.components.breadcrumbs', [
        'items' => [
            ['route' => 'admin.index', 'label' => __('Home')],
            ['route' => 'admin.comments', 'label' => __('Comments')],
            ['label' => __('Unpublished comments')],
        ]
    ])

    @if ($comments)
        <div class="comments-list">
            @foreach ($comments as $comment)
                @include('admin.comments.partials.comment-item', compact('comment'))
            @endforeach
        </div>
    @else
        <div class="empty-state"><p>{{ __('There are no unpublished comments') }}</p></div>
    @endif
@endsection

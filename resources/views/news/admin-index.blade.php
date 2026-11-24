@extends('layouts.admin')

@section('admin-title', __('News'))

@section('content')
    <p class="admin-section-actions"><a class="admin-primary-action" href="{{ route('news.create') }}">{{ __('Create news') }}</a></p>
    @forelse ($news as $item)
        <article class="admin-news-item">
            <h2>{{ $item->title }}</h2>
            <p>{{ $item->description }}</p>
            <small>{{ $item->is_published ? __('Published') : __('Draft') }}</small>
        </article>
    @empty
        <div class="empty-state"><p>{{ __('No news yet') }}</p></div>
    @endforelse
    @if ($news->hasPages())
        <nav class="admin-page-links" aria-label="{{ __('Pagination') }}">
            @if ($news->previousPageUrl())
                <a href="{{ $news->previousPageUrl() }}">{{ __('pagination.previous') }}</a>
            @endif
            @if ($news->nextPageUrl())
                <a href="{{ $news->nextPageUrl() }}">{{ __('pagination.next') }}</a>
            @endif
        </nav>
    @endif
@endsection

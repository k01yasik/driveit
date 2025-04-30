@extends('layouts.profile')

@section('content')
    <div class="admin-container">
        <!-- Левая панель - вынесена в отдельный компонент -->
        <aside class="admin-sidebar">
            @include('admin.components.panel')
        </aside>

        <!-- Основной контент -->
        <main class="admin-main-content">
            <!-- Хлебные крошки - вынесены в отдельный компонент -->
            @include('admin.components.breadcrumbs', [
                'items' => [
                    ['route' => 'admin.index', 'label' => __('Home')],
                    ['label' => __('Comments')],
                    $unpublish_comments_count > 0 ? [
                        'route' => 'admin.comments.unpublished', 
                        'label' => __('Unpublished comments'),
                        'badge' => $unpublish_comments_count
                    ] : null
                ]->filter()
            ])

            <!-- Список комментариев -->
            @if($comments->isEmpty())
                <div class="empty-state">
                    <p>{{ __('No comments found') }}</p>
                </div>
            @else
                <div class="comments-list">
                    @foreach($comments as $comment)
                        @include('admin.comments.partials.comment-item', compact('comment'))
                    @endforeach
                </div>

                <!-- Пагинация -->
                @include('components.pagination', ['paginator' => $comments])
            @endif
        </main>
    </div>
@endsection

@extends('layouts.main')

@section('content')
    <section class="breadcrumbs flex flex-v-center">
        <ul class="flex flex-v-center">
            <x-breadcrumbs.item class="flex flex-v-center">
                <x-breadcrumbs.link :route="route('posts.index')" class="all-posts-item pill">{{ __('All posts') }}</x-breadcrumbs.link>
            </x-breadcrumbs.item>
            <x-breadcrumbs.item class="flex flex-v-center">
                <x-breadcrumbs.link :route="route('posts.rated')" class="all-posts-item pill">{{ __('Best posts') }}</x-breadcrumbs.link>
            </x-breadcrumbs.item>
            <x-breadcrumbs.item class="flex flex-v-center">
                <x-breadcrumbs.link :route="route('best.comments.month')" class="all-posts-item pill">{{ __('Best of the month by comments') }}</x-breadcrumbs.link>
            </x-breadcrumbs.item>
        </ul>
    </section>
    <section>
        @each('components.post', $posts, 'post')
    </section>
@endsection
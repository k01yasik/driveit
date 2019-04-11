@extends('layouts.empty')

@section('content')
    @include('admin.components.panel')
    <div class="right-panel">
        <div class="post-create-wrapper">
            <h2 class="post-create-heading">{{ __('Edit a html body post') }}</h2>
            <h3 class="post-create-heading">{{ $post->name }}</h3>

            <form method="POST" action="{{ route('admin.posts.html.update', ['id' => $post->id]) }}">
                @csrf
                @method('PUT')

                <label for="html" class="required">{{ __('Post html body')}}</label>
                <textarea name="html" id="html" type="text" rows="20" required>{!! $post->body !!}</textarea>

                <button type="submit" class="button btn-post-height">{{ __('Update a post') }}</button>
            </form>
        </div>
    </div>
@endsection
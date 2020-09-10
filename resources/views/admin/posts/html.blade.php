@extends('layouts.profile')

@section('content')
    <div class="row">
        <div class="col s12 m12 l3 sm-margin-bottom-2">
            @include('admin.components.panel')
        </div>
        <div class="col s12 m12 l9">
            <div class="right-panel">
                <div class="post-create-wrapper">
                    <h2 class="post-create-heading">{{ __('Edit a html body post') }}</h2>
                    <h3 class="post-create-heading">{{ $post->name }}</h3>
                    <form method="POST" action="{{ route('admin.posts.html.update', ['id' => $post->id]) }}">
                        @csrf
                        @method('PUT')
                        <label for="body" class="required">{{ __('Post html code')}}</label>
                        <textarea name="body" id="body" type="text" rows="20" required>{!! $post->body !!}</textarea>
                        <button type="submit" class="button btn-post-height">{{ __('Update a post') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.admin')

@section('admin-title', __('Create news'))

@section('content')
    <form class="admin-news-form" action="{{ route('news.store') }}" method="POST">
        @csrf
        @if ($errors->any())
            <ul role="alert" class="admin-form-errors">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <label for="news-title">{{ __('Title') }}</label>
        <input id="news-title" name="title" value="{{ old('title') }}" maxlength="255" required>
        <label for="news-description">{{ __('Description') }}</label>
        <textarea id="news-description" name="description" rows="3" required>{{ old('description') }}</textarea>
        <label for="news-body">{{ __('Body') }}</label>
        <textarea id="news-body" name="body" rows="8" required>{{ old('body') }}</textarea>
        <label class="admin-checkbox">
            <input type="checkbox" name="is_published" value="1" @checked(old('is_published'))>
            {{ __('Publish') }}
        </label>
        <div class="admin-section-actions">
            <button type="submit" class="admin-primary-action">{{ __('Save') }}</button>
            <a href="{{ route('admin.news.index') }}">{{ __('Cancel') }}</a>
        </div>
    </form>
@endsection

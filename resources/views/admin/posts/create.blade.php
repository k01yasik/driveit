@extends('layouts.profile')

@section('content')
    <div class="row">
        <div class="col s12 m12 l3 sm-margin-bottom-2">
            @include('admin.components.panel')
        </div>
        <div class="col s12 m12 l9">
            <div class="post-create-wrapper">
                <h2 class="post-create-heading">{{ __('Create a post') }}</h2>
                <div class="block-wrapper">
                    <h3 class="post-create-subheading">{{ __('Upload image') }}</h3>
                    <div class="post_upload_image_button">
                        <svg version="1.1" class="choose-landscape" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 315.58 315.58" style="enable-background:new 0 0 315.58 315.58;" xml:space="preserve">
                    <g>
                        <path d="M310.58,33.331H5c-2.761,0-5,2.238-5,5v238.918c0,2.762,2.239,5,5,5h305.58c2.763,0,5-2.238,5-5V38.331
                        C315.58,35.569,313.343,33.331,310.58,33.331z M285.58,242.386l-68.766-71.214c-0.76-0.785-2.003-0.836-2.823-0.114l-47.695,41.979
                        l-60.962-75.061c-0.396-0.49-0.975-0.77-1.63-0.756c-0.631,0.013-1.22,0.316-1.597,0.822L30,234.797V63.331h255.58V242.386z"></path>
                        <path d="M210.059,135.555c13.538,0,24.529-10.982,24.529-24.531c0-13.545-10.991-24.533-24.529-24.533
                        c-13.549,0-24.528,10.988-24.528,24.533C185.531,124.572,196.511,135.555,210.059,135.555z"></path>
                    </g>
                </svg>
                    </div>
                </div>
                <form enctype="multipart/form-data" id="post_upload_image">
                    <input type="file" id="post_upload_image_input" accept="image/jpeg,image/png" name="post_upload_image">
                </form>
                <form method="POST" action="{{ route('admin.posts.store') }}" id="create-post-form">
                    @csrf
                    <input type="hidden" id="image" name="image">
                    <label for="slug" class="required">{{ __('Post slug')}}</label>
                    <input name="slug" id="slug" type="text" required>
                    <label for="title" class="required">{{ __('Post title')}}</label>
                    <input name="title" id="title" type="text" required>
                    <label for="description" class="required">{{ __('Post description')}}</label>
                    <input name="description" id="description" type="text" required>
                    <label for="name" class="required">{{ __('Post name')}}</label>
                    <input name="name" id="name" type="text" required>
                    <label for="category" class="required">{{ __('Choose a category') }}</label>
                    <select id="category" name="category" class="select-category" required>
                        <option value="">--{{ __('Choose a category') }}--</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{mb_strtoupper(mb_substr($category->displayname, 0, 1)) . mb_substr($category->displayname, 1)}}</option>
                        @endforeach
                    </select>
                    <label for="caption" class="required">{{ __('Post caption')}}</label>
                    <textarea name="caption" id="caption" type="text" required></textarea>
                    <label for="body" class="required">{{ __('Post body')}}</label>
                    <textarea name="body" id="body" class="hidden-element" type="text" required></textarea>
                    <button type="submit" class="button btn-post-height hidden-element">{{ __('Save a post') }}</button>
                </form>
                @include('components.texteditor', ['type' => 'post'])
                <div class="button btn-post-height submit-post-form">{{ __('Save a post') }}</div>
            </div>
        </div>
    </div>
@endsection
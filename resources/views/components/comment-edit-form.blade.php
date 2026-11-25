@props(['comment', 'action', 'back'])

<form action="{{ $action }}" method="POST" class="post-create-wrapper">
    @csrf
    @method('PATCH')
    <label for="edit-comment-message">{{ __('Comment') }}</label>
    <textarea id="edit-comment-message" name="message" rows="8" maxlength="5000" required
              @error('message') aria-invalid="true" aria-describedby="edit-comment-error" @enderror>{{ old('message', $comment->message) }}</textarea>
    @error('message')
        <p id="edit-comment-error" role="alert">{{ $message }}</p>
    @enderror
    <p>{{ __('Changes will be sent for moderation.') }}</p>
    <button class="button" type="submit">{{ __('Save') }}</button>
    <a href="{{ $back }}">{{ __('Cancel') }}</a>
</form>

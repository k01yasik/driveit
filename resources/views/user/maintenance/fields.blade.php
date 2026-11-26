@php
    $failed = old('maintenance_form') === $formId;
    $title = $failed ? old('title') : $reminder?->title;
    $dueOn = $failed ? old('due_on') : $reminder?->due_on?->toDateString();
    $dueKm = $failed ? old('due_odometer_km') : $reminder?->due_odometer_km;
@endphp
<input type="hidden" name="maintenance_form" value="{{ $formId }}">
<label for="{{ $formId }}-title">{{ __('Maintenance task') }}</label>
<input id="{{ $formId }}-title" name="title" maxlength="150" value="{{ $title }}" required>
<label for="{{ $formId }}-date">{{ __('Due date') }}</label>
<input id="{{ $formId }}-date" type="date" name="due_on" value="{{ $dueOn }}">
<label for="{{ $formId }}-km">{{ __('Due odometer (km)') }}</label>
<input id="{{ $formId }}-km" type="number" name="due_odometer_km" min="0" max="9999999" value="{{ $dueKm }}">

@php
    $carForm = $car ? 'car-'.$car->id : 'new-car';
    $values = old('car_form') === $carForm ? old() : ($car?->getAttributes() ?? []);
@endphp
<input type="hidden" name="car_form" value="{{ $carForm }}">
@foreach (['make' => 'Car make', 'model' => 'Car model'] as $field => $label)
    <label for="{{ $carForm }}-{{ $field }}">{{ __($label) }}</label>
    <input id="{{ $carForm }}-{{ $field }}" name="{{ $field }}" maxlength="100" value="{{ $values[$field] ?? '' }}" required>
@endforeach
<label for="{{ $carForm }}-year">{{ __('Year') }}</label>
<input id="{{ $carForm }}-year" name="year" type="number" min="1886" max="{{ now()->year + 1 }}" value="{{ $values['year'] ?? '' }}">
<label for="{{ $carForm }}-album">{{ __('Photo album') }}</label>
<select id="{{ $carForm }}-album" name="album_id" class="browser-default">
    <option value="">{{ __('No album') }}</option>
    @foreach ($albums as $album)
        <option value="{{ $album->id }}" @selected((string) ($values['album_id'] ?? '') === (string) $album->id)>{{ $album->name }}</option>
    @endforeach
</select>

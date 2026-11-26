@extends('layouts.profile')

@section('content')
    <div class="row">
        <div class="col s12 m12 l3 sm-margin-bottom-2">
            @include('components.profile')
        </div>
        <div class="col s12 m12 l9">
            <div class="profile-block">
                <div class="profile-block-content">
                    <h1 class="profile-title">{{ __('Maintenance reminders') }}</h1>
                    @if ($errors->any())
                        <ul role="alert">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    @forelse ($cars as $car)
                        <section class="margin-bottom-2">
                            <h2 class="profile-title">{{ $car->make }} {{ $car->model }} @if ($car->year) ({{ $car->year }}) @endif</h2>
                            @php($odometerForm = 'odometer-'.$car->id)
                            <form method="POST" action="{{ route('user.maintenance.odometer', [$user['username'], $car->id]) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="maintenance_form" value="{{ $odometerForm }}">
                                <label for="{{ $odometerForm }}">{{ __('Current odometer (km)') }}</label>
                                <input id="{{ $odometerForm }}" name="odometer_km" type="number" min="0" max="9999999"
                                       value="{{ old('maintenance_form') === $odometerForm ? old('odometer_km') : $car->odometer_km }}" required>
                                <button class="btn-flat" type="submit">{{ __('Update odometer') }}</button>
                            </form>

                            @php($newForm = 'new-reminder-'.$car->id)
                            <details @if (old('maintenance_form') === $newForm) open @endif>
                                <summary>{{ __('Add maintenance reminder') }}</summary>
                                <p>{{ __('Set a date, an odometer reading, or both. The reminder is due when either is reached.') }}</p>
                                <form method="POST" action="{{ route('user.maintenance.store', [$user['username'], $car->id]) }}">
                                    @csrf
                                    @include('user.maintenance.fields', ['formId' => $newForm, 'reminder' => null])
                                    <button class="btn" type="submit">{{ __('Add maintenance reminder') }}</button>
                                </form>
                            </details>

                            <ul>
                                @forelse ($car->maintenanceReminders as $reminder)
                                    <li class="margin-bottom-2">
                                        <h3>{{ $reminder->title }}</h3>
                                        @if ($reminder->completed_at)
                                            <p>{{ __('Completed on :date', ['date' => $reminder->completed_at->format('d.m.Y')]) }}</p>
                                        @elseif ($dueReminderIds->has($reminder->id))
                                            <strong>{{ __('Maintenance due now') }}</strong>
                                        @else
                                            <p>{{ __('Maintenance planned') }}</p>
                                        @endif
                                        @if ($reminder->due_on)
                                            <p>{{ __('Due date') }} <time datetime="{{ $reminder->due_on->toDateString() }}">{{ $reminder->due_on->format('d.m.Y') }}</time></p>
                                        @endif
                                        @if ($reminder->due_odometer_km !== null)
                                            <p>{{ __('Due odometer (km)') }} {{ number_format($reminder->due_odometer_km, 0, '', ' ') }}</p>
                                        @endif

                                        @unless ($reminder->completed_at)
                                            <form method="POST" action="{{ route('user.maintenance.complete', [$user['username'], $reminder->id]) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button class="btn-flat" type="submit">{{ __('Complete maintenance') }}</button>
                                            </form>
                                            @php($editForm = 'edit-reminder-'.$reminder->id)
                                            <details @if (old('maintenance_form') === $editForm) open @endif>
                                                <summary>{{ __('Edit maintenance reminder') }}</summary>
                                                <form method="POST" action="{{ route('user.maintenance.update', [$user['username'], $reminder->id]) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    @include('user.maintenance.fields', ['formId' => $editForm])
                                                    <button class="btn" type="submit">{{ __('Save maintenance reminder') }}</button>
                                                </form>
                                            </details>
                                        @endunless
                                        <form method="POST" action="{{ route('user.maintenance.destroy', [$user['username'], $reminder->id]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn-flat" type="submit">{{ __('Delete maintenance reminder') }}</button>
                                        </form>
                                    </li>
                                @empty
                                    <li>{{ __('No maintenance reminders yet') }}</li>
                                @endforelse
                            </ul>
                        </section>
                    @empty
                        <p><a href="{{ route('user.settings', $user['username']) }}">{{ __('Add a car in your garage first') }}</a></p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

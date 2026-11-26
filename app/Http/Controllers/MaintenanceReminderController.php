<?php

namespace App\Http\Controllers;

use App\MaintenanceReminder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MaintenanceReminderController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $cars = $user->cars()->with(['maintenanceReminders' => fn ($query) => $query
            ->orderByRaw('CASE WHEN completed_at IS NULL THEN 0 ELSE 1 END')
            ->latest('id')])->orderBy('id')->get();
        $dueReminderIds = MaintenanceReminder::forOwner($user->id)->due()->pluck('id')->flip();

        return view('user.maintenance.index', [
            'seo' => ['title' => __('Maintenance reminders'), 'description' => __('Maintenance reminders')],
            'cars' => $cars,
            'dueReminderIds' => $dueReminderIds,
            'dueMaintenanceCount' => $dueReminderIds->count(),
        ]);
    }

    public function updateOdometer(Request $request, string $username, int $car): RedirectResponse
    {
        $car = $request->user()->cars()->findOrFail($car);
        $data = $request->validate(['odometer_km' => 'required|integer|min:0|max:9999999']);
        $car->odometer_km = $data['odometer_km'];
        $car->save();

        return redirect()->route('user.maintenance.index', $username);
    }

    public function store(Request $request, string $username, int $car): RedirectResponse
    {
        $car = $request->user()->cars()->findOrFail($car);
        $car->maintenanceReminders()->create($this->validateReminder($request));

        return redirect()->route('user.maintenance.index', $username);
    }

    public function update(Request $request, string $username, int $reminder): RedirectResponse
    {
        $record = MaintenanceReminder::forOwner($request->user()->id)->whereNull('completed_at')->findOrFail($reminder);
        MaintenanceReminder::whereKey($record->id)->whereNull('completed_at')->update($this->validateReminder($request));

        return redirect()->route('user.maintenance.index', $username);
    }

    public function complete(Request $request, string $username, int $reminder): RedirectResponse
    {
        $record = MaintenanceReminder::forOwner($request->user()->id)->findOrFail($reminder);
        MaintenanceReminder::whereKey($record->id)->whereNull('completed_at')->update(['completed_at' => now()]);

        return redirect()->route('user.maintenance.index', $username);
    }

    public function destroy(Request $request, string $username, int $reminder): RedirectResponse
    {
        MaintenanceReminder::forOwner($request->user()->id)->findOrFail($reminder)->delete();

        return redirect()->route('user.maintenance.index', $username);
    }

    private function validateReminder(Request $request): array
    {
        $data = $request->validate([
            'title' => 'required|string|max:150',
            'due_on' => 'required_without:due_odometer_km|nullable|date_format:Y-m-d',
            'due_odometer_km' => 'required_without:due_on|nullable|integer|min:0|max:9999999',
        ]);

        return $data + ['due_on' => null, 'due_odometer_km' => null];
    }
}

<?php

namespace Tests\Feature;

use App\Car;
use App\MaintenanceReminder;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MaintenanceReminderTest extends TestCase
{
    use RefreshDatabase;

    public function test_date_and_mileage_reminders_become_due_and_can_be_completed(): void
    {
        (new \SeoTableSeeder())->run();
        $this->travelTo(now()->setDate(2026, 11, 26)->setTime(14, 0));
        $owner = $this->user('driver');
        $car = $owner->cars()->create(['make' => 'Toyota', 'model' => 'Celica']);
        $secondCar = $owner->cars()->create(['make' => 'Honda', 'model' => 'Civic']);
        $page = route('user.maintenance.index', $owner->username);
        $store = route('user.maintenance.store', [$owner->username, $car->id]);

        $this->actingAs($owner)->post($store, [
            'title' => 'Oil change', 'due_on' => '2026-11-26',
        ])->assertRedirect($page);
        $this->post($store, [
            'title' => 'Timing belt', 'due_on' => '2026-12-26', 'due_odometer_km' => 150000,
        ])->assertRedirect($page);
        $this->post(route('user.maintenance.store', [$owner->username, $secondCar->id]), [
            'title' => 'Brake fluid', 'due_odometer_km' => 150000,
        ])->assertRedirect($page);

        $oil = $car->maintenanceReminders()->where('title', 'Oil change')->sole();
        $belt = $car->maintenanceReminders()->where('title', 'Timing belt')->sole();
        $this->get($page)->assertOk()->assertSee('Oil change')->assertViewHas('dueMaintenanceCount', 1)
            ->assertViewHas('dueReminderIds', fn ($ids) => $ids->has($oil->id) && !$ids->has($belt->id));

        $odometer = route('user.maintenance.odometer', [$owner->username, $car->id]);
        $this->patch($odometer, ['odometer_km' => 149999])->assertRedirect($page);
        $this->get($page)->assertViewHas('dueMaintenanceCount', 1);
        $this->patch($odometer, ['odometer_km' => 150000])->assertRedirect($page);
        $this->get($page)->assertViewHas('dueMaintenanceCount', 2)
            ->assertViewHas('dueReminderIds', fn ($ids) => $ids->has($belt->id));

        $this->get(route('user.profile', $owner->username))->assertOk()
            ->assertViewHas('dueMaintenanceCount', 2)->assertSee($page);

        $complete = route('user.maintenance.complete', [$owner->username, $oil->id]);
        $this->patch($complete)->assertRedirect($page);
        $completed = $oil->refresh()->completed_at;
        $this->assertNotNull($completed);
        $this->travel(1)->hour();
        $this->patch($complete)->assertRedirect($page);
        $this->assertTrue($completed->equalTo($oil->refresh()->completed_at));
        $this->get($page)->assertViewHas('dueMaintenanceCount', 1)->assertSee('26.11.2026');
        $this->patch(route('user.maintenance.update', [$owner->username, $oil->id]), [
            'title' => 'Changed', 'due_on' => '2026-12-01',
        ])->assertNotFound();
    }

    public function test_reminder_requires_a_trigger_and_can_be_rescheduled_or_deleted(): void
    {
        $owner = $this->user('driver');
        $car = $owner->cars()->create(['make' => 'Toyota', 'model' => 'Celica']);
        $page = route('user.maintenance.index', $owner->username);
        $store = route('user.maintenance.store', [$owner->username, $car->id]);

        $this->actingAs($owner)->postJson($store, ['title' => 'Service'])
            ->assertUnprocessable()->assertJsonValidationErrors(['due_on', 'due_odometer_km']);
        $this->postJson($store, ['title' => 'Service', 'due_on' => '2026-02-30', 'due_odometer_km' => -1])
            ->assertUnprocessable()->assertJsonValidationErrors(['due_on', 'due_odometer_km']);
        $this->post($store, ['title' => 'Service', 'due_on' => '2026-11-26'])->assertRedirect($page);
        $reminder = $car->maintenanceReminders()->sole();
        $this->patch(route('user.maintenance.update', [$owner->username, $reminder->id]), [
            'title' => 'Oil change', 'due_odometer_km' => 0,
        ])->assertRedirect($page);
        $this->assertDatabaseHas('maintenance_reminders', [
            'id' => $reminder->id, 'title' => 'Oil change', 'due_on' => null, 'due_odometer_km' => 0,
        ]);
        $this->delete(route('user.maintenance.destroy', [$owner->username, $reminder->id]))->assertRedirect($page);
        $this->assertModelMissing($reminder);
    }

    public function test_another_user_cannot_view_or_manage_maintenance(): void
    {
        $owner = $this->user('driver');
        $visitor = $this->user('visitor');
        $car = $owner->cars()->create(['make' => 'Toyota', 'model' => 'Celica']);
        $reminder = $car->maintenanceReminders()->create(['title' => 'Private maintenance', 'due_odometer_km' => 5]);

        $this->getJson(route('user.maintenance.index', $owner->username))->assertUnauthorized();
        $this->actingAs($visitor)->get(route('user.maintenance.index', $owner->username))->assertForbidden();
        $this->get(route('user.maintenance.index', $visitor->username))->assertOk()->assertDontSee($reminder->title);
        $this->postJson(route('user.maintenance.store', [$visitor->username, $car->id]), [])->assertNotFound();
        $this->patchJson(route('user.maintenance.odometer', [$visitor->username, $car->id]), [])->assertNotFound();
        $this->patchJson(route('user.maintenance.update', [$visitor->username, $reminder->id]), [])->assertNotFound();
        $this->patchJson(route('user.maintenance.complete', [$visitor->username, $reminder->id]))->assertNotFound();
        $this->deleteJson(route('user.maintenance.destroy', [$visitor->username, $reminder->id]))->assertNotFound();

        $this->assertNull(Car::findOrFail($car->id)->odometer_km);
        $this->assertNull(MaintenanceReminder::findOrFail($reminder->id)->completed_at);
    }

    private function user(string $username): User
    {
        $id = DB::table('users')->insertGetId([
            'username' => $username, 'email' => $username.'@example.test', 'email_verified_at' => now(),
        ]);
        DB::table('profiles')->insert(['user_id' => $id, 'avatar' => '/avatar.png', 'public' => true]);

        return User::findOrFail($id);
    }
}

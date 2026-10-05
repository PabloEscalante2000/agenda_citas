<?php

use App\Models\Patient;
use App\Models\Sesion;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->terapeuta = User::factory()->create([
        "role" => "t"
    ]);
    $this->paciente = Patient::factory()->create();
    $this->manana = now()->addDay()->setTime(10, 0, 0);
});

test('un usuario sin autenticar no puede ver sesiones', function () {
    $this->getJson("api/v1/sesions")->assertUnauthorized();
});

test("un terapeuta solo puede ver sus propias sesiones", function () {
    $otro = User::factory()->create([
        "role" => "t"
    ]);

    Sesion::factory(3)->for($this->terapeuta, "user")->create();
    Sesion::factory(2)->for($otro, "user")->create();

    Sanctum::actingAs($this->terapeuta);

    $this->getJson("api/v1/sesions")
        ->assertOk()
        ->assertJsonCount(3, "data");
});

test('un terapeuta no puede ver la sesión de otro terapeuta', function () {
    $otro   = User::factory()->terapeuta()->create();
    $sesion = Sesion::factory()->for($otro)->create();

    Sanctum::actingAs($this->terapeuta);

    $this->getJson("/api/v1/sesiones/{$sesion->id}")->assertForbidden();
});

test('no se puede crear una sesión en el pasado', function () {
    Sanctum::actingAs($this->terapeuta);

    $this->postJson('/api/v1/sesions', [
        'patient_id' => $this->paciente->id,
        'start_time' => now()->subHour()->toDateTimeString(),
        'end_time'   => now()->toDateTimeString(),
    ])->assertUnprocessable()
      ->assertJsonValidationErrors('start_time');
});

test('no se pueden crear sesions solapadas para el mismo terapeuta', function () {
    Sesion::factory()->for($this->terapeuta)->create([
        'start_time' => $this->manana,
        'end_time'   => $this->manana->copy()->addHour(),
    ]);

    Sanctum::actingAs($this->terapeuta);

    $this->postJson('/api/v1/sesions', [
        'patient_id' => $this->paciente->id,
        'start_time' => $this->manana->copy()->subHour()->toDateTimeString(),          // 9:00
        'end_time'   => $this->manana->copy()->addMinutes(30)->toDateTimeString(),     // 10:30
    ])->assertUnprocessable()
      ->assertJsonValidationErrors('start_time');

    expect(Sesion::count())->toBe(1);
});

test('un terapeuta no puede crear una sesión justo después de otra', function () {
    Sesion::factory()->for($this->terapeuta)->create([
        'start_time' => $this->manana,
        'end_time'   => $this->manana->copy()->addHour(),
    ]);

    Sanctum::actingAs($this->terapeuta);

    $this->postJson('/api/v1/sesions', [
        'patient_id' => $this->paciente->id,
        'start_time' => $this->manana->copy()->addHour()->toDateTimeString(),   // 11:00
        'end_time'   => $this->manana->copy()->addHours(2)->toDateTimeString(), // 12:00
    ])->assertCreated();

    expect(Sesion::count())->toBe(2);
});

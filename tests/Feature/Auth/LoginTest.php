<?php

use App\Models\User;

test('un usuario puede iniciar sesión con credenciales correctas', function () {
    $user = User::factory()->create([
        "role" => "t"
    ]);

    $response = $this->postJson('api/v1/login' , [
        "email" => $user->email,
        "password" => "password"
    ]);

    $response->assertOk()->assertJsonStructure([
        "message",
        "token"
    ]);
});

test("no puede iniciar sesión con una contraseña incorrecta", function () {
    $user = User::factory()->create([
        "role" => "t"
    ]);

    $response = $this->postJson('api/v1/login' , [
        "email" => $user->email,
        "password" => "wrong-password"
    ]);

    $response->assertForbidden()->assertJsonStructure([
        "message"
    ]);
});

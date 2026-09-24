<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\Sesion;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'a', // * a -> administrador, t -> terapeuta
        ]);

        $terapeutas = User::factory(5)->create([
            'role' => 't', // * a -> administrador, t -> terapeuta
        ]);

        $pacientes = Patient::factory(10)->create();

        Sesion::factory(30)
            ->recycle($terapeutas)
            ->recycle($pacientes)
            ->create();
    }
}

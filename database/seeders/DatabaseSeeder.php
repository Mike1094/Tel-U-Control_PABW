<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create or get users (idempotent)
        User::firstOrCreate(
            ['email' => 'admin@telkom.id'],
            ['name' => 'Admin', 'password' => Hash::make('password'), 'role' => 'admin']
        );

        User::firstOrCreate(
            ['email' => 'satpam@telkom.id'],
            ['name' => 'Satpam', 'password' => Hash::make('password'), 'role' => 'satpam']
        );

        User::firstOrCreate(
            ['email' => 'mahasiswa@telkom.id'],
            ['name' => 'Mahasiswa Telkom', 'password' => Hash::make('password'), 'role' => 'civitas']
        );

        User::firstOrCreate(
            ['email' => 'warga@email.com'],
            ['name' => 'Warga', 'password' => Hash::make('password'), 'role' => 'warga']
        );

        // Additional dummy Civitas
        User::factory(5)->create([
            'role' => 'civitas'
        ]);

        $this->call([
            GateSeeder::class,
        ]);
    }
}

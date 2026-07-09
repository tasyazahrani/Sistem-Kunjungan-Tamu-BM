<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@benermeriah.go.id'],
            [
                'name' => 'Administrator SIMANTAP',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'petugas@benermeriah.go.id'],
            [
                'name' => 'Petugas Resepsionis',
                'password' => Hash::make('password'),
                'role' => 'petugas',
            ]
        );

        User::updateOrCreate(
            ['email' => 'pimpinan@benermeriah.go.id'],
            [
                'name' => 'Sekretaris Daerah',
                'password' => Hash::make('password'),
                'role' => 'pimpinan',
            ]
        );
    }
}

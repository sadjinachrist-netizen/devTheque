<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'sadjinachrist@gmail.com'], // <-- ton email
            [
                'name'     => 'Christ Sadjina',
                'password' => Hash::make('P@$$word'), // <-- ton mot de passe
                'role'     => 'admin',
            ]
        );
    }
}
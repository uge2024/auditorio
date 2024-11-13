<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'ci' => '12345678',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'Gobernacion010@gmail.com',
            'password' => Hash::make('sistemasUge010'), // Cambia la contraseña a una más segura
            'address' => '123 Admin Street',
            'number' => '123456789',
            'unidad' => 'Admin Unidad',
            'tipo_usuario' => 'admin', // Tipo de usuario administrador
            'estatus' => 'activo',
        ]);
    }
}

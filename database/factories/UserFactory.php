<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'ci' => $this->faker->numerify('########'),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'address' => $this->faker->address,
            'number' => $this->faker->phoneNumber,
            'unidad' => $this->faker->word,
            'registro' => 'registrado',
            'tipo_usuario' => 'user',
            'estatus' => 'activo',
            'remember_token' => Str::random(10),
        ];
    }
}

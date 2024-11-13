<?php

namespace Database\Factories;

use App\Models\Auditorio;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuditorioFactory extends Factory
{
    protected $model = Auditorio::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->company,
            'ubicacion' => $this->faker->address,
            'imagen' => $this->faker->imageUrl(),
            'capacidad' => $this->faker->numberBetween(50, 500),
            'descripcion' => $this->faker->sentence,
        ];
    }
}

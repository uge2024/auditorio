<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EquipoFactory extends Factory
{
    public function definition()
    {
        return [
            'nombre' => $this->faker->word,
            'codigo' => $this->faker->unique()->numerify('EQ-###'),
            'imagen' => $this->faker->imageUrl(),
            'descripcion' => $this->faker->sentence,
            'id_auditorio' => \App\Models\Auditorio::factory(),
        ];
    }
}

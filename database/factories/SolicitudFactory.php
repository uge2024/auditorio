<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SolicitudFactory extends Factory
{
    public function definition()
    {
        return [
            'id_usuario' => \App\Models\User::factory(),
            'id_auditorio' => \App\Models\Auditorio::factory(),
            'fecha_uso' => $this->faker->date,
            'hora_inicio' => $this->faker->time,
            'hora_final' => $this->faker->time,
            'actividad' => $this->faker->sentence,
            'estado' => 'pendiente',
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SolicitudEquipoFactory extends Factory
{
    public function definition()
    {
        return [
            'id_solicitud' => \App\Models\Solicitud::factory(),
            'id_equipo' => \App\Models\Equipo::factory(),
            'estado' => $this->faker->randomElement(['pendiente', 'asignado', 'devuelto']),
        ];
    }
}

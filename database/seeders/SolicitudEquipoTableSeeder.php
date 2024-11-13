<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SolicitudEquipo;

class SolicitudEquipoTableSeeder extends Seeder
{
    public function run()
    {
        SolicitudEquipo::factory()->count(10)->create();
    }
}

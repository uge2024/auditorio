<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipo;

class EquipoTableSeeder extends Seeder
{
    public function run()
    {
        Equipo::factory()->count(10)->create();
    }
}

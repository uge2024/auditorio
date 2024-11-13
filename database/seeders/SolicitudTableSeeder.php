<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Solicitud;

class SolicitudTableSeeder extends Seeder
{
    public function run()
    {
        Solicitud::factory()->count(15)->create();
    }
}

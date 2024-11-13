<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Auditorio;

class AuditorioTableSeeder extends Seeder
{
    public function run()
    {
        Auditorio::factory()->count(5)->create();
    }
}

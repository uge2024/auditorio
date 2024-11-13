<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Solicitud;
use Carbon\Carbon;

class UpdateSolicitudEstado extends Command
{
    // Define el nombre del comando y la descripción
    protected $signature = 'solicitud:update-estado';
    protected $description = 'Actualiza el estado de las solicitudes a finalizado si han llegado a la hora final';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now()->format('H:i'); // Obtiene la hora actual en formato 'H:i'

        // Actualiza el estado de las solicitudes cuyo estado es 'aprobado' y la hora final ha pasado
        Solicitud::where('estado', 'aprobado')
            ->where('hora_final', '<=', $now)
            ->update(['estado' => 'finalizada']);

        $this->info('Estado de las solicitudes actualizadas a finalizado.');
    }
}

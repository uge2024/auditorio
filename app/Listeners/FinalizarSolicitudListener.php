<?php

namespace App\Listeners;

use App\Events\Solicitudaprobado;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class FinalizarSolicitudListener
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\Solicitudaprobado  $event
     * @return void
     */
    public function handle(Solicitudaprobado $event)
    {
        $solicitud = $event->solicitud;

        // Calcular el tiempo restante hasta la hora_final
        $horaFinal = Carbon::createFromTimeString($solicitud->hora_final);
        $diferenciaTiempo = $horaFinal->diffInSeconds(Carbon::now());

        // Si la hora final es en el futuro, esperaremos hasta ese momento
        if ($diferenciaTiempo > 0) {
            sleep($diferenciaTiempo); // Pausa la ejecución hasta la hora_final
        }

        // Una vez alcanzada la hora_final, actualizamos el estado a "finalizada"
        $solicitud->estado = 'finalizada';
        $solicitud->save();

        // Log para verificar el cambio en la consola o log del servidor
        Log::info('Solicitud ' . $solicitud->id_solicitud . ' ha sido finalizada.');
    }
}

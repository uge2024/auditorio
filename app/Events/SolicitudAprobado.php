<?php

namespace App\Events;

use App\Models\Solicitud;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Solicitudaprobado
{
    use Dispatchable, SerializesModels;

    public $solicitud;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Solicitud $solicitud)
    {
        // Asignamos la solicitud aprobado al evento
        $this->solicitud = $solicitud;
    }
}

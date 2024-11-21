<?php

namespace App\Events;

use App\Models\Solicitud;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SolicitudAprobado
{
    use Dispatchable, SerializesModels;

    public $solicitud;

    /**
     * Create a new event instance.
     *
     * @param Solicitud $solicitud
     */
    public function __construct(Solicitud $solicitud)
    {
        $this->solicitud = $solicitud;
    }
}

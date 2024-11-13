<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudEquipo extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'solicitud_equipo';

    // Campos que se pueden rellenar masivamente
    protected $fillable = [
        'id_solicitud',
        'id_equipo',
        'estado',
    ];

    // Casting de atributos
    protected $casts = [
        'estado' => 'string',
    ];

    // Relación con el modelo Solicitud
    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class, 'id_solicitud', 'id_solicitud');
    }

    // Relación con el modelo Equipo
    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'id_equipo', 'id_equipo');
    }
}

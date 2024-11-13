<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    // Definir la tabla asociada al modelo
    protected $table = 'equipo'; // Nombre de la tabla en la base de datos

    // Definir la clave primaria
    protected $primaryKey = 'id_equipo'; // Clave primaria

    // Definir los campos que se pueden llenar masivamente
    protected $fillable = [
        'nombre',
        'codigo', // Añadido campo 'codigo' según la migración
        'imagen',
        'descripcion',
        'id_auditorio',

    ];



    // Definir la relación inversa con el modelo SolicitudEquipo
    public function solicitudes()
    {
        return $this->hasMany(SolicitudEquipo::class, 'id_equipo', 'id_equipo');
    }

    // Definir la relacion con el modelo Auditorio
    public function auditorio()
    {
        return $this->belongsTo(Auditorio::class, 'id_auditorio', 'id_auditorio');
    }

}
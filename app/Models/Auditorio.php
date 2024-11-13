<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auditorio extends Model
{
    use HasFactory;

    protected $table = 'auditorio'; // Nombre de la tabla

    protected $primaryKey = 'id_auditorio'; // Clave primaria

    public $incrementing = true; // Define si la clave primaria es auto-incremental
    protected $keyType = 'int'; // Tipo de clave primaria

    protected $fillable = [
        'nombre',
        'ubicacion', // Asegúrate de que esto también esté en la tabla si se usa
        'imagen',    // Agregado para permitir la asignación masiva
        'capacidad',
        'descripcion',
    ];
    public function solicitudes()
    {
        return $this->hasMany(Solicitud::class, 'id_auditorio', 'id_auditorio');
    }
   // Relación con el modelo Equipo
   public function equipos()
   {
       return $this->hasMany(Equipo::class, 'id_auditorio', 'id_auditorio');
   }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Solicitud extends Model
{
    use HasFactory;

    protected $table = 'solicitud';
    protected $primaryKey = 'id_solicitud';

    protected $fillable = [
        'id_usuario',
        'id_auditorio',
        'fecha_uso',
        'hora_inicio',
        'hora_final',
        'actividad',
        'estado',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id');
    }

    public function auditorio()
    {
        return $this->belongsTo(Auditorio::class, 'id_auditorio', 'id_auditorio');
    }

    public function equipos()
    {
        return $this->belongsToMany(Equipo::class, 'solicitud_equipo', 'id_solicitud', 'id_equipo')
            ->withPivot('estado')
            ->withTimestamps();
    }

    public static function updateExpiredRequests()
    {
        $now = Carbon::now();
        self::where('estado', 'aprobado')
            ->where('hora_final', '<=', $now->format('H:i'))
            ->where('fecha_uso', $now->format('Y-m-d'))
            ->update(['estado' => 'finalizada']);
    }
}
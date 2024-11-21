<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',    // ID del usuario asociado a la notificación
        'message',    // Mensaje de la notificación
        'type',       // Tipo de notificación (solicitud, usuario, interacción)
        'read',       // Estado de lectura
    ];

    /**
     * Relación: Una notificación pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: Notificaciones no leídas.
     */
    public function scopeUnread($query)
    {
        return $query->where('read', false);
    }

    /**
     * Scope: Notificaciones por tipo.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope: Notificaciones para administradores.
     * Muestra las notificaciones de tipo solicitud o usuario.
     */
    public function scopeForAdmin($query)
    {
        return $query->whereIn('type', ['solicitud', 'usuario']);
    }

    /**
     * Scope: Notificaciones para usuarios normales.
     * Muestra notificaciones de interacción.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId)->where('type', 'interaccion');
    }
}

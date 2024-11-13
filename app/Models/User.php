<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'ci',
        'first_name',
        'last_name',
        'email',
        'password',
        'address',
        'number',
        'unidad',
        'estatus',  // 'activo' o 'inactivo'
        'tipo_usuario',  // 'admin' o 'user'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Método para obtener el nombre completo del usuario
    public function fullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',   // ID of the user receiving the notification
        'message',   // Notification message
        'read',      // Boolean to indicate if the notification has been read
    ];

    /**
     * Define the relationship between Notification and User.
     * A notification belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

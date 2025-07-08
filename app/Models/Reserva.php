<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $fillable = [
        'user_id', 'session_id', 'libro_id', 'cantidad', 'reservado_hasta'
    ];

    public function libro()
    {
        return $this->belongsTo(Libro::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

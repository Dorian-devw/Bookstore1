<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    protected $table = 'carrito';
    
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

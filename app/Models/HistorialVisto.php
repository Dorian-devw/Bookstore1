<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialVisto extends Model
{
    protected $table = 'historial_vistos';
    
    protected $fillable = [
        'user_id', 'libro_id', 'visto_en'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function libro()
    {
        return $this->belongsTo(Libro::class);
    }
} 
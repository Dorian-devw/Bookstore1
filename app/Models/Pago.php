<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable = [
        'pedido_id', 'tipo', 'estado', 'referencia', 'fecha'
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}

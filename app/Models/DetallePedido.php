<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    protected $table = 'detalles_pedido';
    
    protected $fillable = [
        'pedido_id', 'libro_id', 'cantidad', 'precio_unitario'
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function libro()
    {
        return $this->belongsTo(Libro::class);
    }
}

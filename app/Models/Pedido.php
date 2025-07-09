<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'user_id', 'estado', 'total', 'metodo_pago', 'fecha', 'fecha_entrega', 'cupon_id', 'descuento',
        'cliente_nombre', 'cliente_email', 'cliente_telefono', 'direccion_entrega', 'session_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class);
    }

    public function pago()
    {
        return $this->hasOne(Pago::class);
    }

    public function cupon()
    {
        return $this->belongsTo(Cupon::class);
    }
}

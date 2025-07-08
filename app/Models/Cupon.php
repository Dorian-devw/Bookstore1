<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Cupon extends Model
{
    protected $table = 'cupones';

    protected $fillable = [
        'codigo', 'tipo', 'valor', 'minimo_compra', 'usos_maximos', 'usos_actuales',
        'fecha_inicio', 'fecha_fin', 'activo', 'descripcion'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'activo' => 'boolean',
    ];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    public function calcularDescuento($subtotal)
    {
        if ($this->tipo === 'porcentaje') {
            return ($subtotal * $this->valor) / 100;
        } else {
            return $this->valor;
        }
    }

    public function esValido($subtotal = 0)
    {
        $hoy = Carbon::today();
        
        // Verificar si está activo
        if (!$this->activo) {
            return false;
        }

        // Verificar fechas
        if ($hoy < $this->fecha_inicio || $hoy > $this->fecha_fin) {
            return false;
        }

        // Verificar monto mínimo
        if ($subtotal < $this->minimo_compra) {
            return false;
        }

        // Verificar usos máximos
        if ($this->usos_maximos && $this->usos_actuales >= $this->usos_maximos) {
            return false;
        }

        return true;
    }

    public function incrementarUso()
    {
        $this->increment('usos_actuales');
    }

    public static function buscarPorCodigo($codigo)
    {
        return static::where('codigo', strtoupper($codigo))->first();
    }
} 
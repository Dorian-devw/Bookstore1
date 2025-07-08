<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Libro extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo', 'descripcion', 'precio', 'stock', 'imagen', 'categoria_id', 'autor_id', 'idioma', 'valoracion', 'publicado_en'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function autor()
    {
        return $this->belongsTo(Autor::class);
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class);
    }

    public function carritos()
    {
        return $this->hasMany(Carrito::class);
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }

    public function detallesPedido()
    {
        return $this->hasMany(DetallePedido::class);
    }

    public function historialVistos()
    {
        return $this->hasMany(HistorialVisto::class);
    }

    public function resenas()
    {
        return $this->hasMany(Resena::class);
    }

    public function resenasAprobadas()
    {
        return $this->resenas()->aprobadas();
    }

    public function getValoracionPromedioAttribute()
    {
        return $this->resenasAprobadas()->avg('calificacion') ?? 0;
    }

    public function getTotalResenasAttribute()
    {
        return $this->resenasAprobadas()->count();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Libro extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo', 'descripcion', 'precio', 'stock', 'imagen', 'categoria_id', 'autor_id', 'idioma', 'valoracion', 'valoracion_por_defecto', 'publicado_en'
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
        $resenasAprobadas = $this->resenasAprobadas();
        $totalResenas = $resenasAprobadas->count();
        
        if ($totalResenas > 0) {
            // Calcular promedio de reseñas de usuarios
            $promedioResenas = $resenasAprobadas->avg('calificacion');
            
            // Calcular promedio ponderado: 70% reseñas de usuarios + 30% calificación por defecto
            $valoracionFinal = ($promedioResenas * 0.7) + ($this->valoracion_por_defecto * 0.3);
            
            return round($valoracionFinal, 1);
        } else {
            // Si no hay reseñas, usar solo la calificación por defecto
            return $this->valoracion_por_defecto;
        }
    }

    public function getTotalResenasAttribute()
    {
        return $this->resenasAprobadas()->count();
    }

    // Método para obtener solo el promedio de reseñas de usuarios
    public function getPromedioResenasUsuariosAttribute()
    {
        return $this->resenasAprobadas()->avg('calificacion') ?? 0;
    }
}

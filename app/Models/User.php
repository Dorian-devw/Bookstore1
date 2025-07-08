<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Obtener los pedidos del usuario
     */
    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    /**
     * Obtener los favoritos del usuario
     */
    public function favoritos()
    {
        return $this->hasMany(Favorito::class);
    }

    /**
     * Obtener el historial de libros vistos del usuario
     */
    public function historialVisto()
    {
        return $this->hasMany(HistorialVisto::class);
    }

    /**
     * Obtener las direcciones del usuario
     */
    public function direcciones()
    {
        return $this->hasMany(Direccion::class);
    }

    /**
     * Obtener las reseñas del usuario
     */
    public function resenas()
    {
        return $this->hasMany(Resena::class);
    }
}

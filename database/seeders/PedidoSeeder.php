<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\User;
use App\Models\Libro;
use App\Models\Pago;
use Carbon\Carbon;

class PedidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = User::where('email', '!=', 'admin@flying-bookstore.com')->get();
        $libros = Libro::all();
        
        if ($usuarios->isEmpty() || $libros->isEmpty()) {
            $this->command->error('No hay usuarios o libros disponibles para crear pedidos.');
            return;
        }

        $estados = ['pendiente', 'procesando', 'enviado', 'entregado', 'cancelado'];
        $metodosPago = ['tarjeta', 'yape', 'transferencia'];

        // Crear pedidos para los últimos 3 meses
        for ($i = 0; $i < 25; $i++) {
            $usuario = $usuarios->random();
            $fecha = Carbon::now()->subDays(rand(1, 90));
            $estado = $estados[array_rand($estados)];
            $metodoPago = $metodosPago[array_rand($metodosPago)];
            
            // Crear pedido
            $pedido = Pedido::create([
                'user_id' => $usuario->id,
                'fecha' => $fecha,
                'estado' => $estado,
                'total' => 0,
                'metodo_pago' => $metodoPago,
            ]);

            // Crear detalles del pedido (1-4 libros por pedido)
            $totalPedido = 0;
            $cantidadLibros = rand(1, 4);
            $librosPedido = $libros->random($cantidadLibros);
            
            foreach ($librosPedido as $libro) {
                $cantidad = rand(1, 3);
                $precio = $libro->precio;
                $subtotal = $precio * $cantidad;
                $totalPedido += $subtotal;

                DetallePedido::create([
                    'pedido_id' => $pedido->id,
                    'libro_id' => $libro->id,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precio,
                ]);

                // Actualizar stock del libro
                $libro->decrement('stock', $cantidad);
            }

            // Actualizar total del pedido
            $pedido->update(['total' => $totalPedido]);

            // Crear pago para pedidos no cancelados
            if ($estado !== 'cancelado') {
                Pago::create([
                    'pedido_id' => $pedido->id,
                    'tipo' => $metodoPago,
                    'fecha' => $fecha,
                ]);
            }
        }

        $this->command->info('Pedidos de prueba creados exitosamente.');
    }
}

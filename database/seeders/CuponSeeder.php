<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cupon;
use Carbon\Carbon;

class CuponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cupones = [
            [
                'codigo' => 'BIENVENIDA10',
                'tipo' => 'porcentaje',
                'valor' => 10,
                'minimo_compra' => 50,
                'usos_maximos' => 100,
                'fecha_inicio' => Carbon::now(),
                'fecha_fin' => Carbon::now()->addMonths(3),
                'descripcion' => '10% de descuento para nuevos clientes',
            ],
            [
                'codigo' => 'DESCUENTO20',
                'tipo' => 'porcentaje',
                'valor' => 20,
                'minimo_compra' => 100,
                'usos_maximos' => 50,
                'fecha_inicio' => Carbon::now(),
                'fecha_fin' => Carbon::now()->addMonths(2),
                'descripcion' => '20% de descuento en compras mayores a S/ 100',
            ],
            [
                'codigo' => 'SOLES10',
                'tipo' => 'fijo',
                'valor' => 10,
                'minimo_compra' => 30,
                'usos_maximos' => 200,
                'fecha_inicio' => Carbon::now(),
                'fecha_fin' => Carbon::now()->addMonths(6),
                'descripcion' => 'S/ 10 de descuento en compras mayores a S/ 30',
            ],
            [
                'codigo' => 'NAVIDAD25',
                'tipo' => 'porcentaje',
                'valor' => 25,
                'minimo_compra' => 150,
                'usos_maximos' => 30,
                'fecha_inicio' => Carbon::now(),
                'fecha_fin' => Carbon::now()->addMonths(1),
                'descripcion' => '25% de descuento especial de navidad',
            ],
        ];

        foreach ($cupones as $cupon) {
            Cupon::create($cupon);
        }
    }
}

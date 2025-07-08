<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libro;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $masVendidos = Libro::with(['autor', 'categoria'])
            ->select(
                'libros.id',
                'libros.titulo',
                'libros.imagen',
                'libros.precio',
                'libros.descripcion',
                'libros.autor_id',
                'libros.categoria_id',
                DB::raw('COALESCE(SUM(detalles_pedido.cantidad),0) as total_ventas')
            )
            ->leftJoin('detalles_pedido', 'libros.id', '=', 'detalles_pedido.libro_id')
            ->groupBy(
                'libros.id',
                'libros.titulo',
                'libros.imagen',
                'libros.precio',
                'libros.descripcion',
                'libros.autor_id',
                'libros.categoria_id'
            )
            ->orderByDesc('total_ventas')
            ->take(5)
            ->get();
        $destacados = Libro::orderByDesc('valoracion')->take(5)->get();
        $novedades = Libro::orderByDesc('created_at')->take(8)->get();
        $nuevosLanzamientos = Libro::orderByDesc('id')->take(8)->get();
        $categorias = \App\Models\Categoria::with(['libros' => function($q) {
            $q->withCount(['detallesPedido as ventas_totales' => function($query) {
                $query->select(\DB::raw('COALESCE(SUM(cantidad),0)'));
            }])->orderByDesc('ventas_totales');
        }])->get();
        $categoriasConLibro = $categorias->map(function($cat) {
            $libro = $cat->libros->first();
            return [
                'id' => $cat->id,
                'nombre' => $cat->nombre,
                'libro' => $libro,
            ];
        });
        return view('home', compact('masVendidos', 'destacados', 'novedades', 'categorias', 'nuevosLanzamientos', 'categoriasConLibro'));
    }
}

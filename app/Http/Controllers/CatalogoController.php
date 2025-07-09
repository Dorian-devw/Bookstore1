<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libro;
use App\Models\Categoria;

class CatalogoController extends Controller
{
    public function index(Request $request)
    {
        $query = Libro::query();

        // Filtros
        if ($request->filled('categoria')) {
            $query->where('categoria_id', $request->categoria);
        }
        if ($request->filled('idioma')) {
            $query->where('idioma', $request->idioma);
        }
        if ($request->filled('precio_min')) {
            $query->where('precio', '>=', $request->precio_min);
        }
        if ($request->filled('precio_max')) {
            $query->where('precio', '<=', $request->precio_max);
        }
        if ($request->filled('valoracion')) {
            $query->where('valoracion', '>=', $request->valoracion);
        }

        $libros = $query->orderByDesc('created_at')->paginate(12);
        $categorias = Categoria::all();
        $idiomas = ['español', 'inglés'];

        return view('catalogo', compact('libros', 'categorias', 'idiomas'));
    }

    public function show($id)
    {
        $libro = \App\Models\Libro::with('autor', 'categoria')->findOrFail($id);
        
        // Registrar en historial si el usuario está autenticado
        if (auth()->check()) {
            \App\Models\HistorialVisto::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'libro_id' => $id
                ],
                [
                    'visto_en' => now()
                ]
            );
        }
        
        // Obtener libros recomendados
        $recomendados = \App\Models\Libro::where('id', '!=', $id)
            ->where(function($query) use ($libro) {
                $query->where('categoria_id', $libro->categoria_id)
                      ->orWhere('autor_id', $libro->autor_id);
            })
            ->orderByDesc('valoracion')
            ->take(6)
            ->get();
        
        return view('libro_detalle', compact('libro', 'recomendados'));
    }

    public function buscarAjax(Request $request)
    {
        $q = $request->input('q');
        if (!$q) {
            return response()->json([]);
        }
        $libros = Libro::with('autor')
            ->where('titulo', 'like', "%{$q}%")
            ->orWhereHas('autor', function($query) use ($q) {
                $query->where('nombre', 'like', "%{$q}%");
            })
            ->take(8)
            ->get();
        $resultados = $libros->map(function($libro) {
            return [
                'id' => $libro->id,
                'titulo' => $libro->titulo,
                'autor' => $libro->autor ? $libro->autor->nombre : '',
                'imagen' => $libro->imagen ? asset($libro->imagen) : asset('images/default-book.png'),
                'url' => route('libro.detalle', $libro->id),
            ];
        });
        return response()->json($resultados);
    }
}

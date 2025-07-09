<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libro;
use App\Models\Categoria;
use App\Models\Autor;
use Illuminate\Support\Facades\Storage;

// Controlador para la gestión de libros en el panel de administración
class AdminLibroController extends Controller
{
    // Muestra la lista de libros para administración
    public function index(Request $request)
    {
        $query = Libro::with('autor', 'categoria');
        if ($request->filled('buscar')) {
            $query->where('titulo', 'like', '%' . $request->buscar . '%');
        }
        $libros = $query->orderByDesc('created_at')->paginate(10);
        return view('admin.libros.index', compact('libros'));
    }

    // Muestra el formulario para crear un nuevo libro
    public function create()
    {
        $categorias = Categoria::all();
        $autores = Autor::all();
        return view('admin.libros.create', compact('categorias', 'autores'));
    }

    // Guarda un nuevo libro en la base de datos
    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required',
            'descripcion' => 'nullable',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'imagen' => 'nullable|image|max:2048',
            'categoria_id' => 'required|exists:categorias,id',
            'autor_id' => 'required|exists:autores,id',
            'idioma' => 'required',
            'valoracion' => 'nullable|numeric|min:0|max:5',
            'publicado_en' => 'nullable|date',
        ]);
        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('libros', 'public');
        }
        Libro::create($data);
        return redirect()->route('admin.libros.index')->with('success', 'Libro creado correctamente');
    }

    // Muestra el formulario para editar un libro existente
    public function edit($id)
    {
        $libro = Libro::findOrFail($id);
        $categorias = Categoria::all();
        $autores = Autor::all();
        return view('admin.libros.edit', compact('libro', 'categorias', 'autores'));
    }

    // Actualiza la información de un libro
    public function update(Request $request, $id)
    {
        $libro = Libro::findOrFail($id);
        $data = $request->validate([
            'titulo' => 'required',
            'descripcion' => 'nullable',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'imagen' => 'nullable|image|max:2048',
            'categoria_id' => 'required|exists:categorias,id',
            'autor_id' => 'required|exists:autores,id',
            'idioma' => 'required',
            'valoracion' => 'nullable|numeric|min:0|max:5',
            'publicado_en' => 'nullable|date',
        ]);
        if ($request->hasFile('imagen')) {
            // Borrar imagen anterior si existe
            if ($libro->imagen && Storage::disk('public')->exists($libro->imagen)) {
                Storage::disk('public')->delete($libro->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('libros', 'public');
        }
        $libro->update($data);
        return redirect()->route('admin.libros.index')->with('success', 'Libro actualizado correctamente');
    }

    // Elimina un libro de la base de datos
    public function destroy($id)
    {
        $libro = Libro::findOrFail($id);
        if ($libro->imagen && Storage::disk('public')->exists($libro->imagen)) {
            Storage::disk('public')->delete($libro->imagen);
        }
        $libro->delete();
        return redirect()->route('admin.libros.index')->with('success', 'Libro eliminado correctamente');
    }

    // Gestión de stock (listado y edición inline)
    public function stock(Request $request)
    {
        $query = Libro::with('autor', 'categoria');
        if ($request->filled('bajo')) {
            $query->where('stock', '<', 10);
        }
        $libros = $query->orderBy('stock')->paginate(15);
        return view('admin.libros.stock', compact('libros'));
    }

    public function actualizarStock(Request $request, $id)
    {
        $libro = Libro::findOrFail($id);
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);
        $libro->stock = $request->stock;
        $libro->save();
        return redirect()->route('admin.stock.index')->with('success', 'Stock actualizado correctamente');
    }
}

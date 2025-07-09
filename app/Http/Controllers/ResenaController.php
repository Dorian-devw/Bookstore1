<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Resena;
use App\Models\Libro;

class ResenaController extends Controller
{
    // Mostrar reseñas de un libro
    public function index($libro_id)
    {
        $libro = Libro::findOrFail($libro_id);
        $resenas = $libro->resenasAprobadas()->with('user')->orderByDesc('created_at')->paginate(10);
        return view('resenas.index', compact('libro', 'resenas'));
    }

    // Formulario para crear reseña
    public function create($libro_id)
    {
        $libro = Libro::findOrFail($libro_id);
        
        // Verificar si el usuario ya reseñó este libro
        $resenaExistente = Resena::where('user_id', Auth::id())
            ->where('libro_id', $libro_id)
            ->first();
            
        if ($resenaExistente) {
            return redirect()->route('resenas.edit', $resenaExistente->id);
        }
        
        return view('resenas.create', compact('libro'));
    }

    // Guardar reseña
    public function store(Request $request, $libro_id)
    {
        $request->validate([
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:1000',
        ]);

        // Verificar si ya existe una reseña
        $resenaExistente = Resena::where('user_id', Auth::id())
            ->where('libro_id', $libro_id)
            ->first();
            
        if ($resenaExistente) {
            return redirect()->route('resenas.edit', $resenaExistente->id)
                ->with('error', 'Ya has reseñado este libro');
        }

        Resena::create([
            'user_id' => Auth::id(),
            'libro_id' => $libro_id,
            'calificacion' => $request->calificacion,
            'comentario' => $request->comentario,
            'estado' => 'pendiente', // Requiere moderación
        ]);

        return redirect()->route('libro.detalle', $libro_id)
            ->with('success', 'Tu reseña ha sido enviada y está pendiente de aprobación');
    }

    // Formulario para editar reseña
    public function edit($id)
    {
        $resena = Resena::where('id', $id)
            ->where('user_id', Auth::id())
            ->with('libro')
            ->firstOrFail();
            
        return view('resenas.edit', compact('resena'));
    }

    // Actualizar reseña
    public function update(Request $request, $id)
    {
        $resena = Resena::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $request->validate([
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:1000',
        ]);

        $resena->update([
            'calificacion' => $request->calificacion,
            'comentario' => $request->comentario,
            'estado' => 'pendiente', // Requiere nueva moderación
        ]);

        return redirect()->route('libro.detalle', $resena->libro_id)
            ->with('success', 'Tu reseña ha sido actualizada y está pendiente de aprobación');
    }

    // Eliminar reseña
    public function destroy($id)
    {
        $resena = Resena::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        $libro_id = $resena->libro_id;
        $resena->delete();

        return redirect()->route('libro.detalle', $libro_id)
            ->with('success', 'Reseña eliminada correctamente');
    }

    // Panel de administración para moderar reseñas
    public function adminIndex(Request $request)
    {
        $query = Resena::with(['user', 'libro']);

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtro por calificación
        if ($request->filled('calificacion')) {
            $query->where('calificacion', $request->calificacion);
        }

        $resenas = $query->orderByDesc('created_at')->paginate(20);
            
        return view('admin.resenas.index', compact('resenas'));
    }

    // Aprobar/rechazar reseña (admin)
    public function moderar(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:aprobado,rechazado',
        ]);

        $resena = Resena::findOrFail($id);
        $libro = $resena->libro;
        $estadoAnterior = $resena->estado;
        
        $resena->update(['estado' => $request->estado]);

        // Actualizar la valoración del libro
        $this->actualizarValoracionLibro($libro);

        $mensaje = 'Reseña ' . $request->estado . ' correctamente';
        
        // Si se aprobó una reseña que antes estaba rechazada, o viceversa
        if ($estadoAnterior !== $request->estado) {
            $mensaje .= '. La valoración del libro ha sido actualizada.';
        }

        return back()->with('success', $mensaje);
    }

    // Método privado para actualizar la valoración del libro
    private function actualizarValoracionLibro($libro)
    {
        $resenasAprobadas = $libro->resenasAprobadas();
        $totalResenas = $resenasAprobadas->count();
        
        if ($totalResenas > 0) {
            // Calcular promedio de reseñas de usuarios
            $promedioResenas = $resenasAprobadas->avg('calificacion');
            
            // Calcular promedio ponderado: 70% reseñas de usuarios + 30% calificación por defecto
            $valoracionFinal = ($promedioResenas * 0.7) + ($libro->valoracion_por_defecto * 0.3);
            
            $libro->update(['valoracion' => round($valoracionFinal, 1)]);
        } else {
            // Si no hay reseñas aprobadas, usar solo la calificación por defecto
            $libro->update(['valoracion' => $libro->valoracion_por_defecto]);
        }
    }
}

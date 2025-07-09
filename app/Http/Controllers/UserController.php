<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pedido;
use App\Models\Favorito;
use App\Models\HistorialVisto;
use App\Models\Direccion;
use Barryvdh\DomPDF\Facade\Pdf;

// Controlador para la gestión de usuarios, perfil, direcciones, favoritos, historial y comprobantes
class UserController extends Controller
{
    // Muestra el panel principal del usuario con resumen de pedidos, favoritos, historial y direcciones
    public function panel()
    {
        $user = Auth::user();
        $pedidos = Pedido::where('user_id', $user->id)->orderByDesc('fecha')->take(5)->get();
        $favoritos = Favorito::where('user_id', $user->id)->with('libro')->take(5)->get();
        $historial = HistorialVisto::where('user_id', $user->id)->with('libro')->orderByDesc('visto_en')->take(5)->get();
        $direcciones = Direccion::where('user_id', $user->id)->get();
        
        return view('user.panel', compact('user', 'pedidos', 'favoritos', 'historial', 'direcciones'));
    }

    // Muestra la información personal del usuario
    public function perfil()
    {
        $user = Auth::user();
        return view('user.perfil', compact('user'));
    }

    // Permite actualizar el perfil del usuario
    public function actualizarPerfil(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);
        
        $user->update($request->only(['name', 'email']));
        return redirect()->route('user.perfil')->with('success', 'Perfil actualizado correctamente');
    }

    // Muestra la lista de direcciones del usuario
    public function direcciones()
    {
        $direcciones = Direccion::where('user_id', Auth::id())->get();
        return view('user.direcciones', compact('direcciones'));
    }

    // Permite crear una nueva dirección para el usuario
    public function crearDireccion(Request $request)
    {
        $request->validate([
            'direccion' => 'required|string',
            'ciudad' => 'required|string',
            'departamento' => 'required|string',
            'referencia' => 'nullable|string',
            'telefono' => 'required|string',
        ]);

        $direccion = Direccion::create([
            'user_id' => Auth::id(),
            'direccion' => $request->direccion,
            'ciudad' => $request->ciudad,
            'departamento' => $request->departamento,
            'referencia' => $request->referencia,
            'telefono' => $request->telefono,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true, 
                'message' => 'Dirección agregada correctamente',
                'direccion' => $direccion
            ]);
        }

        return redirect()->route('user.direcciones')->with('success', 'Dirección agregada correctamente');
    }

    // Permite eliminar una dirección del usuario
    public function eliminarDireccion($id)
    {
        $direccion = Direccion::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $direccion->delete();
        return redirect()->route('user.direcciones')->with('success', 'Dirección eliminada correctamente');
    }

    // Devuelve las direcciones del usuario en formato JSON (AJAX)
    public function obtenerDirecciones()
    {
        $direcciones = Direccion::where('user_id', Auth::id())->get();
        return response()->json($direcciones);
    }

    // Crea una dirección automática si el usuario no tiene ninguna
    public function crearDireccionAutomatica()
    {
        $user = Auth::user();
        
        // Verificar si ya tiene direcciones
        $direccionesExistentes = Direccion::where('user_id', $user->id)->count();
        
        if ($direccionesExistentes == 0) {
            // Crear dirección por defecto con Lima
            $direccion = Direccion::create([
                'user_id' => $user->id,
                'direccion' => 'Dirección por defecto',
                'ciudad' => 'Lima',
                'departamento' => 'Lima',
                'referencia' => 'Dirección automática',
                'telefono' => $user->telefono ?? '999999999',
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Dirección automática creada',
                'direccion' => $direccion
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Ya existen direcciones'
        ]);
    }

    // Muestra el historial de pedidos del usuario
    public function pedidos()
    {
        $pedidos = Pedido::where('user_id', Auth::id())->orderByDesc('fecha')->paginate(10);
        return view('user.pedidos', compact('pedidos'));
    }

    // Muestra el detalle de un pedido específico del usuario
    public function pedidoDetalle($id)
    {
        $pedido = Pedido::with(['detalles.libro', 'pago'])->where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('user.pedido_detalle', compact('pedido'));
    }

    // Muestra la lista de favoritos del usuario
    public function favoritos()
    {
        $favoritos = Favorito::where('user_id', Auth::id())->paginate(12);
        return view('user.favoritos', compact('favoritos'));
    }

    // Permite agregar o quitar un libro de favoritos (soporta AJAX)
    public function agregarFavorito(Request $request)
    {
        // Obtener siempre primero de input (FormData o x-www-form-urlencoded)
        $libroId = $request->input('libro_id');
        $action = $request->input('action', 'add');

        // Si no hay, intenta del JSON (por si acaso)
        if (!$libroId && $request->expectsJson()) {
            $data = $request->json()->all();
            $libroId = $data['libro_id'] ?? null;
            $action = $data['action'] ?? 'add';
        }

        \Log::info('Petición favoritos (unificado):', [
            'libro_id' => $libroId,
            'action' => $action,
            'all_data' => $request->all(),
            'has_libro_id' => $request->has('libro_id'),
            'libro_id_type' => gettype($libroId),
            'headers' => $request->headers->all()
        ]);
        
        // Validar que el libro existe
        if (!$libroId) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'ID de libro requerido']);
            }
            return back()->with('error', 'ID de libro requerido');
        }
        
        $libro = \App\Models\Libro::find($libroId);
        if (!$libro) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Libro no encontrado']);
            }
            return back()->with('error', 'Libro no encontrado');
        }
        
        $existe = Favorito::where('user_id', Auth::id())->where('libro_id', $libroId)->exists();
        
        if ($request->expectsJson()) {
            // Petición AJAX
            if ($action === 'remove') {
                // Eliminar favorito
                if ($existe) {
                    Favorito::where('user_id', Auth::id())->where('libro_id', $libroId)->delete();
                    return response()->json(['success' => true, 'message' => 'Eliminado de favoritos']);
                } else {
                    return response()->json(['success' => false, 'message' => 'No estaba en favoritos']);
                }
            } else {
                // Agregar favorito
                if (!$existe) {
                    Favorito::create([
                        'user_id' => Auth::id(),
                        'libro_id' => $libroId,
                    ]);
                    return response()->json(['success' => true, 'message' => 'Agregado a favoritos']);
                } else {
                    return response()->json(['success' => false, 'message' => 'Ya está en favoritos']);
                }
            }
        }
        
        // Petición normal (no AJAX)
        if (!$existe) {
            Favorito::create([
                'user_id' => Auth::id(),
                'libro_id' => $libroId,
            ]);
        }
        
        return back()->with('success', 'Libro agregado a favoritos');
    }

    // Permite eliminar un libro de favoritos
    public function eliminarFavorito($id)
    {
        $favorito = Favorito::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $favorito->delete();
        return back()->with('success', 'Libro eliminado de favoritos');
    }

    // Muestra el historial de libros vistos por el usuario
    public function historial()
    {
        $historial = HistorialVisto::where('user_id', Auth::id())->with('libro')->orderByDesc('visto_en')->paginate(12);
        return view('user.historial', compact('historial'));
    }

    // Permite descargar el comprobante PDF de un pedido
    public function comprobante($id)
    {
        $pedido = Pedido::with(['detalles.libro', 'pago'])->where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $pdf = Pdf::loadView('user.comprobante', compact('pedido'));
        return $pdf->download('comprobante_pedido_'.$pedido->id.'.pdf');
    }
} 
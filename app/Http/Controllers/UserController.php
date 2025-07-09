<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pedido;
use App\Models\Favorito;
use App\Models\HistorialVisto;
use App\Models\Direccion;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{

    // Panel principal del usuario
    public function panel()
    {
        $user = Auth::user();
        $pedidos = Pedido::where('user_id', $user->id)->orderByDesc('fecha')->take(5)->get();
        $favoritos = Favorito::where('user_id', $user->id)->with('libro')->take(5)->get();
        $historial = HistorialVisto::where('user_id', $user->id)->with('libro')->orderByDesc('visto_en')->take(5)->get();
        $direcciones = Direccion::where('user_id', $user->id)->get();
        
        return view('user.panel', compact('user', 'pedidos', 'favoritos', 'historial', 'direcciones'));
    }

    // Información personal
    public function perfil()
    {
        $user = Auth::user();
        return view('user.perfil', compact('user'));
    }

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

    // Direcciones
    public function direcciones()
    {
        $direcciones = Direccion::where('user_id', Auth::id())->get();
        return view('user.direcciones', compact('direcciones'));
    }

    public function crearDireccion(Request $request)
    {
        $request->validate([
            'direccion' => 'required|string',
            'ciudad' => 'required|string',
            'departamento' => 'required|string',
            'referencia' => 'nullable|string',
            'telefono' => 'required|string',
        ]);

        Direccion::create([
            'user_id' => Auth::id(),
            'direccion' => $request->direccion,
            'ciudad' => $request->ciudad,
            'departamento' => $request->departamento,
            'referencia' => $request->referencia,
            'telefono' => $request->telefono,
        ]);

        return redirect()->route('user.direcciones')->with('success', 'Dirección agregada correctamente');
    }

    public function eliminarDireccion($id)
    {
        $direccion = Direccion::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $direccion->delete();
        return redirect()->route('user.direcciones')->with('success', 'Dirección eliminada correctamente');
    }

    // Historial de pedidos
    public function pedidos()
    {
        $pedidos = Pedido::where('user_id', Auth::id())->orderByDesc('fecha')->paginate(10);
        return view('user.pedidos', compact('pedidos'));
    }

    public function pedidoDetalle($id)
    {
        $pedido = Pedido::with(['detalles.libro', 'pago'])->where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('user.pedido_detalle', compact('pedido'));
    }

    // Favoritos
    public function favoritos()
    {
        $favoritos = Favorito::where('user_id', Auth::id())->paginate(12);
        return view('user.favoritos', compact('favoritos'));
    }

    public function agregarFavorito(Request $request)
    {
        $request->validate(['libro_id' => 'required|exists:libros,id']);
        
        $existe = Favorito::where('user_id', Auth::id())->where('libro_id', $request->libro_id)->exists();
        if (!$existe) {
            Favorito::create([
                'user_id' => Auth::id(),
                'libro_id' => $request->libro_id,
            ]);
        }
        
        return back()->with('success', 'Libro agregado a favoritos');
    }

    public function eliminarFavorito($id)
    {
        $favorito = Favorito::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $favorito->delete();
        return back()->with('success', 'Libro eliminado de favoritos');
    }

    // Historial de libros vistos
    public function historial()
    {
        $historial = HistorialVisto::where('user_id', Auth::id())->with('libro')->orderByDesc('visto_en')->paginate(12);
        return view('user.historial', compact('historial'));
    }

    public function comprobante($id)
    {
        $pedido = Pedido::with(['detalles.libro', 'pago'])->where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $pdf = Pdf::loadView('user.comprobante', compact('pedido'));
        return $pdf->download('comprobante_pedido_'.$pedido->id.'.pdf');
    }
} 
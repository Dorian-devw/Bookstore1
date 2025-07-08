<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pedido;

class AdminUsuarioController extends Controller
{
    // Listado y búsqueda de usuarios
    public function index(Request $request)
    {
        $query = User::query();
        if ($request->filled('buscar')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->buscar . '%')
                  ->orWhere('email', 'like', '%' . $request->buscar . '%');
            });
        }
        $usuarios = $query->orderByDesc('created_at')->paginate(12);
        return view('admin.usuarios.index', compact('usuarios'));
    }

    // Ver pedidos de un usuario
    public function pedidos($id)
    {
        $usuario = User::findOrFail($id);
        $pedidos = Pedido::where('user_id', $id)->orderByDesc('fecha')->paginate(10);
        return view('admin.usuarios.pedidos', compact('usuario', 'pedidos'));
    }

    // Formulario para editar usuario
    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        return view('admin.usuarios.edit', compact('usuario'));
    }

    // Actualizar usuario
    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'email_verified' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $usuario->update([
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => $request->email_verified ? now() : null,
        ]);

        // Si se marca como inactivo, podemos agregar lógica adicional aquí
        if (!$request->is_active) {
            // Por ejemplo, invalidar sesiones activas
        }

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado correctamente');
    }
}

<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLibroController;
use App\Http\Controllers\AdminUsuarioController;
use App\Http\Controllers\AdminPedidoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResenaController;
use App\Http\Controllers\SuscriptorController;
use App\Http\Controllers\PagoController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalogo', [CatalogoController::class, 'index'])->name('catalogo');
Route::get('/libro/{id}', [CatalogoController::class, 'show'])->name('libro.detalle');

// Rutas públicas del carrito
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
Route::post('/carrito/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::post('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
Route::get('/carrito/confirmar', [CarritoController::class, 'confirmar'])->name('carrito.confirmar');
Route::post('/carrito/confirmar', [CarritoController::class, 'procesarCompra'])->name('carrito.procesar');
Route::get('/carrito/comprobante/{id}', [CarritoController::class, 'comprobante'])->name('carrito.comprobante');

// Redirigir dashboard a la página principal
Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Redirigir rutas de Breeze a las rutas de la aplicación
    Route::get('/profile', function () {
        return redirect()->route('user.perfil');
    })->name('profile.edit');
    
    Route::patch('/profile', function () {
        return redirect()->route('user.perfil');
    })->name('profile.update');
    
    Route::delete('/profile', function () {
        return redirect()->route('user.perfil');
    })->name('profile.destroy');
    
    // Rutas protegidas del carrito (ya no necesarias, movidas a públicas)
    
    // Rutas de usuario (PRINCIPALES)
    Route::get('/user/panel', [UserController::class, 'panel'])->name('user.panel');
    Route::get('/user/perfil', [UserController::class, 'perfil'])->name('user.perfil');
    Route::post('/user/perfil', [UserController::class, 'actualizarPerfil'])->name('user.perfil.update');
    Route::get('/user/direcciones', [UserController::class, 'direcciones'])->name('user.direcciones');
    Route::post('/user/direcciones', [UserController::class, 'crearDireccion'])->name('user.direcciones.store');
    Route::post('/user/direcciones/{id}/eliminar', [UserController::class, 'eliminarDireccion'])->name('user.direcciones.destroy');
    Route::get('/user/pedidos', [UserController::class, 'pedidos'])->name('user.pedidos');
    Route::get('/user/pedidos/{id}', [UserController::class, 'pedidoDetalle'])->name('user.pedido.detalle');
    Route::get('/user/favoritos', [UserController::class, 'favoritos'])->name('user.favoritos');
    Route::post('/user/favoritos', [UserController::class, 'agregarFavorito'])->name('user.favoritos.store');
    Route::post('/user/favoritos/{id}/eliminar', [UserController::class, 'eliminarFavorito'])->name('user.favoritos.destroy');
    Route::get('/user/historial', [UserController::class, 'historial'])->name('user.historial');
    
    // Rutas de reseñas
    Route::get('/libro/{libro_id}/resenas', [ResenaController::class, 'index'])->name('resenas.index');
    Route::get('/libro/{libro_id}/resena/crear', [ResenaController::class, 'create'])->name('resenas.create');
    Route::post('/libro/{libro_id}/resena', [ResenaController::class, 'store'])->name('resenas.store');
    Route::get('/resena/{id}/editar', [ResenaController::class, 'edit'])->name('resenas.edit');
    Route::put('/resena/{id}', [ResenaController::class, 'update'])->name('resenas.update');
    Route::delete('/resena/{id}', [ResenaController::class, 'destroy'])->name('resenas.destroy');
    
    // Rutas de administración (con middleware admin)
    Route::middleware('admin')->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.panel');
        Route::get('/admin/libros', [AdminLibroController::class, 'index'])->name('admin.libros.index');
        Route::get('/admin/libros/crear', [AdminLibroController::class, 'create'])->name('admin.libros.create');
        Route::post('/admin/libros', [AdminLibroController::class, 'store'])->name('admin.libros.store');
        Route::get('/admin/libros/{id}/editar', [AdminLibroController::class, 'edit'])->name('admin.libros.edit');
        Route::post('/admin/libros/{id}', [AdminLibroController::class, 'update'])->name('admin.libros.update');
        Route::post('/admin/libros/{id}/eliminar', [AdminLibroController::class, 'destroy'])->name('admin.libros.destroy');
        Route::get('/admin/stock', [AdminLibroController::class, 'stock'])->name('admin.stock.index');
        Route::post('/admin/stock/{id}', [AdminLibroController::class, 'actualizarStock'])->name('admin.stock.update');
        Route::get('/admin/usuarios', [AdminUsuarioController::class, 'index'])->name('admin.usuarios.index');
        Route::get('/admin/usuarios/{id}/pedidos', [AdminUsuarioController::class, 'pedidos'])->name('admin.usuarios.pedidos');
        Route::get('/admin/usuarios/{id}/editar', [AdminUsuarioController::class, 'edit'])->name('admin.usuarios.edit');
        Route::post('/admin/usuarios/{id}', [AdminUsuarioController::class, 'update'])->name('admin.usuarios.update');
        Route::get('/admin/pedidos', [AdminPedidoController::class, 'index'])->name('admin.pedidos.index');
        Route::get('/admin/pedidos/{id}', [AdminPedidoController::class, 'show'])->name('admin.pedidos.show');
        Route::post('/admin/pedidos/{id}/estado', [AdminPedidoController::class, 'actualizarEstado'])->name('admin.pedidos.estado');
        Route::get('/admin/pedidos/{id}/comprobante', [AdminPedidoController::class, 'comprobante'])->name('admin.pedidos.comprobante');
        
        // Panel admin - reseñas
        Route::get('/admin/resenas', [ResenaController::class, 'adminIndex'])->name('admin.resenas.index');
        Route::post('/admin/resenas/{id}/moderar', [ResenaController::class, 'moderar'])->name('admin.resenas.moderar');
    });
});

// Ruta para generar reportes en PDF
Route::get('admin/reportes/pdf', [App\Http\Controllers\AdminController::class, 'generarReportePDF'])->name('admin.reportes.pdf');


// Nueva ruta GET '/buscar-ajax'
Route::get('/buscar-ajax', [App\Http\Controllers\CatalogoController::class, 'buscarAjax'])->name('buscar.ajax');

Route::post('/suscribirse', [SuscriptorController::class, 'store'])->name('suscribirse');

Route::post('/pago/mercadopago', [PagoController::class, 'mercadopago'])->name('pago.mercadopago');
Route::get('/pago/exito', [PagoController::class, 'exito'])->name('pago.exito');
Route::get('/pago/fallo', [PagoController::class, 'fallo'])->name('pago.fallo');
Route::get('/pago/pendiente', [PagoController::class, 'pendiente'])->name('pago.pendiente');

require __DIR__.'/auth.php';

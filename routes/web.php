<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BloqueoPeluqueroController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\UserController;
use Illuminate\Console\Application;

// Rutas accesibles para usuarios no logueados
Route::middleware(['comprobarRol', 'comprobarRolPeluquero'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Landing');
    })->name('landing');
    Route::get('/servicios', [ServicioController::class, 'index'])->name('servicios.servicios');
    Route::get('/productos', [ProductoController::class, 'index'])->name('productos.productos');
    Route::get('/quienes-somos', function () {
        return Inertia::render('QuienesSomos');
    })->name('quienes-somos');
});

// Rutas accesibles para el usuario logueado
Route::middleware(['auth', 'verified', 'comprobarRol', 'comprobarRolPeluquero'])->group(function () {
    // Rutas del carrito
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito');
    Route::post('/carrito/clear', [CarritoController::class, 'clear'])->name('clear');
    Route::post('/carrito/completar-compra', [CarritoController::class, 'completarCompra'])->name('completarCompra');
    Route::post('/carrito/decrementarCantidad/{carritoItem}', [CarritoController::class, 'decrementarCantidad'])->name('decrementarCantidad');
    Route::post('/carrito/incrementarCantidad/{carritoItem}', [CarritoController::class, 'incrementarCantidad'])->name('incrementarCantidad');    
    Route::post('/carrito/add/{producto}', [CarritoController::class, 'add'])->name('add');
    Route::middleware('auth')->post('/carrito/migrar', [CarritoController::class, 'migrar'])->name('carrito.migrar');

    // Rutas de citas del usuario
    Route::get('/citas', [CitaController::class, 'index']);
    Route::get('/citas/{id}/create', [CitaController::class, 'create']);
    Route::post('/citas', [CitaController::class, 'store'])->name('citas.store');
    Route::get('/historial-citas', [CitaController::class, 'historial'])->name('historial-citas');
    Route::put('/citas/updateFromHistorial/{id}', [CitaController::class, 'updateFromHistorial'])->name('citas.updateFromHistorial');
    Route::get('/citas/obtenerCitas', [CitaController::class, 'obtenerCitas'])->name('citas.obtenerCitas');
    Route::get('/citas/obtenerCitasReserva', [CitaController::class, 'obtenerCitasReserva'])->name('citas.obtenerCitasReserva');
    Route::put('/citas/{id}/cancelar', [CitaController::class, 'cancelar'])->name('citas.cancelar');

    // Rutas de pedidos
    Route::get('/pedidos/create', [PedidoController::class, 'create'])->name('pedidos.create');
    Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store');
    Route::get('/historial_pedidos', [PedidoController::class, 'historial'])->name('historial_pedidos');
    Route::get('/pedidos/{id}', [PedidoController::class, 'show']);
    Route::post('/pedidos/cancelar/{pedido}', [PedidoController::class, 'cancelarPedido']);
    Route::get('/pedidos/{id}/pdf', [PedidoController::class, 'descargarPDF'])->name('pedidos.pdf');


    // Perfil del usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas accesibles para el usuario peluquero
Route::middleware(['auth', 'peluquero'])->group(function () {
    Route::get('/peluquero/horas', [CitaController::class, 'gestionarHoras'])->name('peluquero.horas');
    Route::get('/peluquero/citas', [CitaController::class, 'gestionarCitas'])->name('peluquero.citas');
    Route::get('/peluquero', [CitaController::class, 'peluqueros'])->name('peluquero.peluquero');
    Route::post('/citas/aceptar/{id}', [CitaController::class, 'aceptarCita'])->name('citas.aceptar');
    Route::post('/citas/cancelar/{id}', [CitaController::class, 'cancelarCita'])->name('peluquero.citas.cancelar');
    Route::get('/citas/obtenerCitasDelDia', [CitaController::class, 'obtenerCitasDelDia'])->name('citas.obtenerCitasDelDia');
    Route::post('/citas/bloquear', [CitaController::class, 'bloquearFecha'])->name('citas.bloquear');
    Route::post('bloqueos', [BloqueoPeluqueroController::class, 'store'])->name('bloqueos.store');
    Route::post('bloqueos/desbloquear', [BloqueoPeluqueroController::class, 'desbloquear'])->name('bloqueos.desbloquear');
    Route::get('/bloqueos/horas-bloqueadas', [BloqueoPeluqueroController::class, 'horasBloqueadas'])->name('bloqueos.horas-bloqueadas');
});

// Rutas accesibles para el usuario administrador
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin/admin');
    })->name('admin');

    // Panel Admin
    Route::get('admin', [AdminController::class, 'mostrarDatos'])->name('admin.preview');
    Route::get('/admin/usuarios', [AdminController::class, 'usuarios'])->name('admin.usuarios');
    Route::get('/admin/citas', [AdminController::class, 'gestionarCitas'])->name('admin.citas');
    Route::get('/admin/servicios', [AdminController::class, 'listaServicios'])->name('admin.servicios');
    Route::get('/admin/productos', [AdminController::class, 'listaProductos'])->name('admin.productos');
    Route::get('/admin/bloqueos', [AdminController::class, 'gestionarBloqueos'])->name('admin.bloqueos');
    Route::get('/admin/pedidos', [AdminController::class, 'gestionarPedidos'])->name('admin.pedidos');

    // Rutas de CRUD de usuarios
    Route::post('/usuarios', [UserController::class, 'store'])->name('users.store');
    Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // Rutas de CRUD de servicios
    Route::get('/servicios/create', [ServicioController::class, 'create']);
    Route::post('/servicios', [ServicioController::class, 'store'])->name('servicios.store');
    Route::get('/servicios/{id}/edit', [ServicioController::class, 'edit']);
    Route::put('/servicios/{id}', [ServicioController::class, 'update'])->name('servicios.update');
    Route::delete('/servicios/{id}', [ServicioController::class, 'destroy'])->name('servicios.destroy');

    // Rutas de CRUD de productos
    Route::get('/productos/create', [ProductoController::class, 'create']);
    Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
    Route::get('/productos/{id}/edit', [ProductoController::class, 'edit']);
    Route::put('/productos/{id}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');

    // Rutas de citas - Admin
    Route::post('/admin/gestionar_citas', [CitaController::class, 'store'])->name('admin.citas.store');
    Route::get('/admin/gestionar_citas/{id}/edit', [CitaController::class, 'edit']);
    Route::put('/admin/gestionar_citas/{id}', [CitaController::class, 'update'])->name('admin.citas.update');
    Route::delete('/admin/gestionar_citas/{id}', [CitaController::class, 'destroy'])->name('admin.citas.destroy');
    Route::get('/admin/gestionar_citas/obtenerCitas', [CitaController::class, 'obtenerCitas'])->name('admin.citas.obtenerCitas');
    Route::get('/admin/gestionar_citas/buscar_usuarios', [CitaController::class, 'buscarUsuarios'])->name('admin.buscar_usuarios');
    Route::put('admin/gestionar_citas/{id}/actualizar-estado', [CitaController::class, 'actualizar_estado'])->name('citas.actualizar_estado');

    // Rutas de bloqueos - Admin
    Route::get('admin/bloqueos', [BloqueoPeluqueroController::class, 'index'])->name('admin.bloqueos');
    Route::post('admin/bloqueos', [BloqueoPeluqueroController::class, 'storeAdmin'])->name('admin.bloqueos.store');
    Route::put('/admin/bloqueos/{id}', [BloqueoPeluqueroController::class, 'update'])->name('bloqueos.update');
    Route::delete('/admin/bloqueos/{id}', [BloqueoPeluqueroController::class, 'destroy'])->name('bloqueos.destroy');
    Route::get('admin/bloqueos/horasBloqueadas', [BloqueoPeluqueroController::class, 'horasBloqueadas'])->name('bloqueos.horas_bloqueadas');

    // Rutas de pedidos - Admin
    Route::put('/pedidos/{id}', [PedidoController::class, 'update'])->name('pedidos.update');
    Route::delete('/pedidos/{id}', [PedidoController::class, 'destroy'])->name('pedidos.destroy');


});

// Ruta mailing
Route::post('/send-contact-email', [ContactoController::class, 'sendMail'])->name('contact.send');

// Obtener categorías de productos
Route::get('/categorias', [ProductoController::class, 'categorias'])->name('categorias');

Route::post('/completar-compra', [CarritoController::class, 'completarCompra'])->name('completarCompra');



// Autenticación
require __DIR__ . '/auth.php';

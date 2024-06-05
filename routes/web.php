<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BloqueoPeluqueroController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
}); */




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rutas de productos

// Rutas accesibles para usuarios no logueados

Route::middleware('comprobarRol')->group(function () {
    Route::get('/servicios', [ServicioController::class, 'index'])->name('servicios.servicios');
    Route::get('/productos', [ProductoController::class, 'index'])->name('productos.productos');
    Route::get('/quienes-somos', function () {
        return Inertia::render('QuienesSomos');
    })->name('quienes-somos');

    // Ruta de Landing Page

    Route::get('/', function () {
        return Inertia::render('Landing');
    })->name('landing');
});

// Login

Route::get('/landing', function () {
    return Inertia::render('landing', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('guest')->get('/login', function () {
    return view('login');
})->name('login');



// Rutas accesibles para el usuario logueado

Route::middleware('auth', 'verified', 'comprobarRol')->group(function () {
    // Rutas del carrito
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito');
    Route::post('/carrito/add/{producto}', [CarritoController::class, 'add'])->name('add');
    Route::post('/carrito/clear', [CarritoController::class, 'clear'])->name('clear');
    Route::post('/carrito/completar-compra', [CarritoController::class, 'completarCompra'])->name('completarCompra');
    Route::post('/carrito/decrementarCantidad/{carrito}', [CarritoController::class, 'decrementarCantidad'])->name('decrementarCantidad');
    Route::post('/carrito/incrementarCantidad/{carrito}', [CarritoController::class, 'incrementarCantidad'])->name('incrementarCantidad');
    
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
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/create', [PedidoController::class, 'create'])->name('pedidos.create');
    Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store');
    Route::get('/pedidos/{id}', [PedidoController::class, 'show'])->name('pedidos.show');
    Route::get('/pedidos/{id}/edit', [PedidoController::class, 'edit'])->name('pedidos.edit');
    Route::put('/pedidos/{id}', [PedidoController::class, 'update'])->name('pedidos.update');
    Route::delete('/pedidos/{id}', [PedidoController::class, 'destroy'])->name('pedidos.destroy');
    Route::put('/pedidos/{id}/restore', [PedidoController::class, 'restore'])->name('pedidos.restore');
    Route::delete('/pedidos/{id}/forceDelete', [PedidoController::class, 'forceDelete'])->name('pedidos.forceDelete');

    // Perfil del usuario
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

require __DIR__ . '/auth.php';

// Rutas accesibles para el usuario peluquero

Route::middleware('auth')->group(function () {
    Route::get('/peluquero/horas', [CitaController::class, 'gestionarHoras'])->name('peluquero.horas');
    Route::get('/peluquero/citas', [CitaController::class, 'gestionarCitas'])->name('peluquero.citas');
    Route::get('/peluquero', [CitaController::class, 'peluqueros'])->name('peluquero.peluquero');
    Route::post('/citas/aceptar/{id}', [CitaController::class, 'aceptarCita'])->name('citas.aceptar');
    Route::post('/citas/cancelar/{id}', [CitaController::class, 'cancelarCita'])->name('peluquero.citas.cancelar');
    Route::get('/citas/obtenerCitasDelDia', [CitaController::class, 'obtenerCitasDelDia'])->name('citas.obtenerCitasDelDia');
    Route::post('/citas/bloquear', [CitaController::class, 'bloquearFecha'])->name('citas.bloquear');
    Route::post('bloqueos', [BloqueoPeluqueroController::class, 'store'])->name('bloqueos.store')->middleware('peluquero');
    Route::post('bloqueos/desbloquear', [BloqueoPeluqueroController::class, 'desbloquear'])->name('bloqueos.desbloquear')->middleware('peluquero');
    Route::get('/bloqueos/horas-bloqueadas', [BloqueoPeluqueroController::class, 'horasBloqueadas'])->name('bloqueos.horas-bloqueadas');
});

// Rutas accesibles para el usuario administrador
Route::middleware('auth', 'admin')->group(function () {
    Route::get('/admin', function () {
        return view('admin/admin');
    })->name('admin');

    // Panel Admin
    Route::get('admin', [AdminController::class, 'mostrarDatos'])->name('admin.preview');

    // Rutas zona usuario - Listados
    Route::get('/admin', [AdminController::class, 'mostrarDatos'])->name('admin.admin');
    Route::get('/admin/usuarios', [AdminController::class, 'usuarios'])->name('admin.usuarios');
    Route::get('/admin/citas', [AdminController::class, 'gestionarCitas'])->name('admin.citas');
    Route::get('/admin/servicios', [AdminController::class, 'listaServicios'])->name('admin.servicios');
    Route::get('/admin/productos', [AdminController::class, 'listaProductos'])->name('admin.productos');
    Route::get('/admin/bloqueos', [AdminController::class, 'gestionarBloqueos'])->name('admin.bloqueos');


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
});


Route::get('/productos/create', [ProductoController::class, 'create']);
Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');

Route::get('/productos/{id}/edit', [ProductoController::class, 'edit']);
Route::put('/productos/{id}', [ProductoController::class, 'update'])
    ->name('productos.update');

Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');

Route::get('/categorias', [ProductoController::class, 'categorias'])->name('categorias'); // Obtener las categorías de los productos para luego mapearlas en el filtro

// Rutas de usuarios

Route::post('/usuarios', [UserController::class, 'store'])->name('users.store');
Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('users.destroy');


// Rutas de servicios

Route::get('/servicios/create', [ServicioController::class, 'create']);
Route::post('/servicios', [ServicioController::class, 'store'])->name('servicios.store');

Route::get('/servicios/{id}/edit', [ServicioController::class, 'edit']);
Route::put('/servicios/{id}', [ServicioController::class, 'update'])->name('servicios.update');

Route::delete('/servicios/{id}', [ServicioController::class, 'destroy'])->name('servicios.destroy');


// Ruta para enviar correo de contacto


Route::post('/send-contact-email', [ContactoController::class, 'sendMail'])->name('contact.send');


require __DIR__ . '/auth.php';




Route::get('/productos/create', [ProductoController::class, 'create']);
Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');

Route::get('/productos/{id}/edit', [ProductoController::class, 'edit']);
Route::put('/productos/{id}', [ProductoController::class, 'update'])
    ->name('productos.update');

Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');

Route::get('/categorias', [ProductoController::class, 'categorias'])->name('categorias'); // Obtener las categorías de los productos para luego mapearlas en el filtro

// Rutas de usuarios

Route::post('/usuarios', [UserController::class, 'store'])->name('users.store');
Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('users.destroy');

// Rutas de servicios

Route::get('/servicios/create', [ServicioController::class, 'create']);
Route::post('/servicios', [ServicioController::class, 'store'])->name('servicios.store');

Route::get('/servicios/{id}/edit', [ServicioController::class, 'edit']);
Route::put('/servicios/{id}', [ServicioController::class, 'update'])->name('servicios.update');

Route::delete('/servicios/{id}', [ServicioController::class, 'destroy'])->name('servicios.destroy');


// Ruta para enviar correo de contacto


Route::post('/send-contact-email', [ContactoController::class, 'sendMail'])->name('contact.send');


require __DIR__ . '/auth.php';

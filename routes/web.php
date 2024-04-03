<?php

use App\Http\Controllers\CarritoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

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
    Route::get('/productos', [ProductoController::class, 'index'])->name('productos');
    Route::get('/servicios', [ServicioController::class, 'index'])->name('servicios');
    Route::get('/quienes-somos', function () {
        return view('index');
    })->name('quienes-somos');
    
});

// Login

Route::middleware('guest')->get('/login', function () {
    return view('auth.login');
})->name('login');

// Ruta de Landing Page

Route::get('/', function () { // REVISAR ESTA RUTA PARA USUARIOS LOGUEADOS Y NO VERIFICADOS.
    return view('landing');
})->name('landing');

// Rutas accesibles para el usuario logueado

Route::middleware('auth', 'verified', 'comprobarRol')->group(function () {
    // Rutas del carrito
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito');
    Route::post('/carrito/add/{producto}', [CarritoController::class, 'add'])->name('add');
    Route::post('/carrito/clear', [CarritoController::class, 'clear'])->name('clear');

    Route::post('/carrito/decrementarCantidad/{carrito}', [CarritoController::class, 'decrementarCantidad'])->name('decrementarCantidad');
    Route::post('/carrito/incrementarCantidad/{carrito}', [CarritoController::class, 'incrementarCantidad'])->name('incrementarCantidad');

    // Rutas de citas del usuario
    Route::get('/citas', [CitaController::class, 'index']);
    Route::get('/citas/{id}/create', [CitaController::class, 'create']);
    Route::post('/citas', [CitaController::class, 'store'])->name('citas.store');

    // Perfil del usuario
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';

// Rutas accesibles para el usuario administrador

Route::middleware('auth', 'admin')->group(function() {
    Route::get('/admin', function () {
        return view('admin/admin');
    })->name('admin');

    // Panel Admin

    /* REVISTAR ESTA RUTA CON LA DEL ADMIN_LAYOUT */
    Route::get('admin', [AdminController::class, 'mostrarDatos'])->name('admin.preview');
    

    // Rutas zona usuario - Listados
    Route::get('/admin/usuarios', [AdminController::class, 'usuarios'])->name('usuarios');
    Route::get('/admin/gestionar_citas', [AdminController::class, 'gestionarCitas'])->name('citas');
    Route::get('/admin/lista_servicios', [AdminController::class, 'listaServicios'])->name('servicios');
    Route::get('/admin/lista_productos', [AdminController::class, 'listaProductos'])->name('productos');

    
});


Route::get('/productos/create', [ProductoController::class, 'create']);
Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');

Route::get('/productos/{id}/edit', [ProductoController::class, 'edit']);
Route::put('/productos/{id}', [ProductoController::class, 'update'])
    ->name('productos.update');
    
Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');

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


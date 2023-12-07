<?php

use App\Http\Controllers\CarritoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/productos', [ProductoController::class, 'index'])->name('productos');
Route::get('/productos/create', [ProductoController::class, 'create']);
Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');

Route::get('/productos/{id}/edit', [ProductoController::class, 'edit']);
Route::put('/productos/{id}', [ProductoController::class, 'update'])
    ->name('productos.update');
    
Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');


// Rutas de servicios

Route::get('/servicios', [ServicioController::class, 'index'])->name('servicios');
Route::get('/servicios/create', [ServicioController::class, 'create']);
Route::post('/servicios', [ServicioController::class, 'store'])->name('servicios.store');

Route::get('/servicios/{id}/edit', [ServicioController::class, 'edit']);
Route::put('/servicios/{id}', [ServicioController::class, 'update'])->name('servicios.update');

Route::delete('/servicios/{id}', [ServicioController::class, 'destroy'])->name('servicios.destroy');

// Rutas de usuarios

Route::get('/perfil', [UserController::class, 'index']);

// Rutas de citas

Route::get('/citas', [CitaController::class, 'index']);
Route::get('/citas/{id}/create', [CitaController::class, 'create']);
Route::post('/citas', [CitaController::class, 'store'])->name('citas.store');

Route::get('/', function () {
    return view('welcome');
});

// Ruta de Landing Page

Route::get('/', function () {
    return view('landing');
});

// Rutas del carrito

Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito');
Route::post('/carrito/add/{producto}', [CarritoController::class, 'add'])->name('add');
Route::post('/carrito/clear', [CarritoController::class, 'clear'])->name('clear');

Route::post('/carrito/decrementarCantidad/{carrito}', [CarritoController::class, 'decrementarCantidad'])->name('decrementarCantidad');
Route::post('/carrito/incrementarCantidad/{carrito}', [CarritoController::class, 'incrementarCantidad'])->name('incrementarCantidad');

//

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

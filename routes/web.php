<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController; // Importante [cite: 205]

// 1. RUTA DE INICIO (Te manda directo al CRUD)
Route::get('/', function () { 
    return redirect()->route('usuarios.index'); 
});

// 2. RUTA DEL CRUD (LIBRE PARA PRUEBAS)
// Asegúrate de que esta línea esté FUERA de cualquier Route::middleware
Route::resource('usuarios', UsuarioController::class); [cite: 206]

// 3. LOGIN Y DEMÁS (Déjalas abajo por ahora)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
    // ... el resto de tus rutas
});
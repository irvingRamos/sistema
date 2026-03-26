<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\AuthController;

/**
 * 1. INICIO Y LOGIN
 */
Route::get('/', function () { 
    return redirect()->route('login'); 
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/**
 * 2. RUTAS PROTEGIDAS POR AUTENTICACIÓN
 */
Route::middleware(['auth'])->group(function () {
    
    // Lista de productos (Lo ven admin y usuario normal)
    Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');

    /**
     * 3. RUTAS SOLO PARA ADMIN (PRÁCTICA 6)
     * Si entras como 'user', aquí es donde sale el ERROR 403.
     */
    Route::middleware(['checkRol:admin'])->group(function () {
        Route::get('/productos/create', [ProductoController::class, 'create'])->name('productos.create');
        Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
        Route::get('/productos/{id}/edit', [ProductoController::class, 'edit'])->name('productos.edit');
        Route::put('/productos/{id}', [ProductoController::class, 'update'])->name('productos.update');
        Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');
    });
});
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\User; 
use App\Notifications\ProductoCreado;
use App\Notifications\StockBajoDB;
use Illuminate\Support\Facades\Notification;

class ProductoController extends Controller
{
    /**
     * Lista de productos (Soluciona el error de index)
     */
    public function index()
    {
        $productos = Producto::paginate(10);
        return view('productos.index', compact('productos'));
    }

    /**
     * Formulario para crear nuevo producto
     */
    public function create()
    {
        return view('productos.create');
    }

    /**
     * Paso 3: Guardar y enviar notificación de creación
     */
    public function store(Request $request) 
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'stock'  => 'required|integer',
        ]);

        $producto = Producto::create($validated);

        // Notificar a administradores
        $admins = User::where('rol', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new ProductoCreado($producto));
        }

        return redirect()->route('productos.index')
            ->with('success', 'Producto registrado y admins notificados.');
    }

    /**
     * Detalle del producto (necesario para el link del Paso 2)
     */
    public function show($id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.show', compact('producto'));
    }

    /**
     * Formulario de edición
     */
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.edit', compact('producto'));
    }

    /**
     * Paso 6: Actualizar y enviar notificación de Stock Bajo
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'stock'  => 'required|integer',
        ]);

        $producto->update($validated);

        // Si el stock baja de 5, notificamos
        if ($producto->stock < 5) {
            $admins = User::where('rol', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new StockBajoDB($producto));
            }
        }

        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Eliminar producto
     */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado.');
    }
}
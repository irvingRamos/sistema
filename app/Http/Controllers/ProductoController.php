<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria; 
use Illuminate\Http\Request;
use App\Http\Requests\ProductoRequest; 
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    // 1. EL MÉTODO QUE TE FALTABA
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $productos = Producto::query()
            ->when($search, function($query, $search) {
                return $query->search($search);
            })
            ->paginate(10);

        return view('productos.index', compact('productos', 'search'));
    }

    // 2. MÉTODO CREATE
    public function create()
    {
        $categorias = Categoria::all();
        return view('productos.create', compact('categorias'));
    }

    // 3. MÉTODO STORE (Corregido)
    public function store(ProductoRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        Producto::create($data); 
        return redirect()->route('productos.index')
                         ->with('success', 'Producto creado exitosamente.');
    }

    // 4. MÉTODO EDIT
    public function edit(string $id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    // 5. MÉTODO UPDATE (Corregido)
    public function update(ProductoRequest $request, string $id)
    {
        $producto = Producto::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($data); 
        return redirect()->route('productos.index')
                         ->with('success', 'Producto actualizado correctamente.');
    }

    // 6. MÉTODO DESTROY
    public function destroy(string $id)
    {
        $producto = Producto::findOrFail($id);
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }
        $producto->delete();
        return redirect()->route('productos.index')
                         ->with('success', 'Producto eliminado.');
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Http\Resources\ProductoResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductoApiController extends Controller
{
    /**
     * GET /api/productos
     * Lista todos los productos con paginación de 10 en 10.
     * Requisito: Paso 4 del PDF de la Práctica 9.
     */
    public function index()
    {
        // Usamos el Resource para transformar la colección paginada
        // Esto resuelve el error "Class not found" al tener el 'use' arriba
        return ProductoResource::collection(Producto::paginate(10));
    }

    /**
     * POST /api/productos
     * Crea un nuevo producto. 
     * Requisito: Debe devolver código HTTP 201 (Created).
     */
    public function store(Request $request)
    {
        // Validación manual para capturar errores y enviarlos como JSON
        $validator = Validator::make($request->all(), [
            'nombre'       => 'required|string|max:255',
            'precio'       => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'descripcion'  => 'nullable|string',
            'url_imagen'   => 'nullable|url'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validación fallida',
                'errors' => $validator->errors()
            ], 422); // 422 Unprocessable Entity
        }

        $producto = Producto::create($request->all());

       
        return (new ProductoResource($producto))
                ->response()
                ->setStatusCode(201);
    }

    /**
     * GET /api/productos/{id}
     * Obtener el detalle de un producto específico.
     */
    public function show(Producto $producto)
    {
        return new ProductoResource($producto);
    }

   
    public function update(Request $request, Producto $producto)
    {
        $validator = Validator::make($request->all(), [
            'nombre'       => 'sometimes|string|max:255',
            'precio'       => 'sometimes|numeric|min:0',
            'stock'        => 'sometimes|integer|min:0',
            'url_imagen'   => 'nullable|url'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $producto->update($request->all());

        return response()->json([
            'message' => 'Producto actualizado con éxito',
            'data' => new ProductoResource($producto)
        ], 200);
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();

        return response()->json([
            'message' => 'Producto eliminado correctamente.'
        ], 200);
    }
}
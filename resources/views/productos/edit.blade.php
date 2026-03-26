<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto - Práctica 8</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; padding: 40px; }
        .form-container { max-width: 550px; margin: auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
        h2 { color: #2c3e50; text-align: center; margin-bottom: 25px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #34495e; }
        input, select, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
        
        /* Estilos para la imagen actual */
        .current-image { margin: 10px 0; padding: 10px; border: 1px dashed #ccc; border-radius: 8px; text-align: center; background: #fafafa; }
        .current-image img { max-width: 150px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .img-label { font-size: 0.85em; color: #7f8c8d; display: block; margin-bottom: 5px; }

        .btn-update { background: #27ae60; color: white; border: none; padding: 12px; width: 100%; border-radius: 6px; cursor: pointer; font-size: 16px; margin-top: 15px; font-weight: bold; }
        .btn-update:hover { background: #219150; }
        .btn-back { display: block; text-align: center; margin-top: 15px; color: #7f8c8d; text-decoration: none; font-size: 0.9em; }
        .error-msg { color: #e74c3c; font-size: 0.8em; margin-top: 4px; display: block; }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Editar Producto</h2>

        {{-- IMPORTANTE: enctype="multipart/form-data" es obligatorio para subir archivos --}}
        <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nombre del Producto</label>
                <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required>
                @error('nombre') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Categoría</label>
                <select name="categoria_id" required>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ (old('categoria_id', $producto->categoria_id) == $categoria->id) ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Precio</label>
                <input type="number" name="precio" step="0.01" value="{{ old('precio', $producto->precio) }}" required>
            </div>

            <div class="form-group">
                <label>Stock</label>
                <input type="number" name="stock" value="{{ old('stock', $producto->stock) }}" required>
            </div>

            <div class="form-group">
                <label>Descripción</label>
                <textarea name="descripcion" rows="3">{{ old('descripcion', $producto->descripcion) }}</textarea>
            </div>

            {{-- SECCIÓN DE IMAGEN (PRÁCTICA 8) --}}
            <div class="form-group">
                <label>Imagen del Producto</label>
                
                @if($producto->imagen)
                    <div class="current-image">
                        <span class="img-label">Imagen actual:</span>
                        <img src="{{ asset('storage/' . $producto->imagen) }}" alt="Imagen actual">
                    </div>
                @endif

                <input type="file" name="imagen" accept="image/*">
                <small style="color: #95a5a6;">Deje vacío si no desea cambiar la imagen.</small>
                @error('imagen') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn-update">Guardar Cambios</button>
            <a href="{{ route('productos.index') }}" class="btn-back">Volver al listado</a>
        </form>
    </div>

</body>
</html>
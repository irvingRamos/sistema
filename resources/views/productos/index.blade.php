<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos - Reportes</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f0f2f5; margin: 0; padding: 20px; }
        .container { max-width: 1100px; margin: auto; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        
        /* Cabecera */
        .header-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
        .user-info { font-size: 14px; color: #555; }
        .role-badge { background: #3498db; color: white; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; }
        .btn-logout { color: #e74c3c; text-decoration: none; font-weight: bold; border: 1px solid #e74c3c; padding: 5px 12px; border-radius: 6px; transition: 0.3s; }
        .btn-logout:hover { background: #e74c3c; color: white; }

        h1 { color: #2c3e50; font-size: 22px; margin: 15px 0; border-bottom: 2px solid #f1f3f5; padding-bottom: 10px; }

        /* --- NUEVOS ESTILOS PARA REPORTES (PRACTICA 11) --- */
        .reports-bar { display: flex; gap: 10px; margin-bottom: 15px; }
        .btn-report { padding: 8px 15px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 13px; display: inline-flex; align-items: center; transition: 0.3s; }
        .btn-pdf { background-color: #e74c3c; color: white; border: 1px solid #c0392b; }
        .btn-pdf:hover { background-color: #c0392b; }
        .btn-excel { background-color: #27ae60; color: white; border: 1px solid #219150; }
        .btn-excel:hover { background-color: #219150; }
        /* -------------------------------------------------- */

        /* Buscador y Nuevo */
        .actions-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; gap: 15px; }
        .btn-crear { background: #34495e; color: white; padding: 10px 18px; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 14px; white-space: nowrap; }
        
        .search-box { flex-grow: 1; display: flex; background: #f8f9fa; padding: 8px; border-radius: 8px; border: 1px solid #ddd; align-items: center; gap: 8px; }
        .search-input { border: none; background: transparent; padding: 8px; flex-grow: 1; outline: none; font-size: 14px; }
        .btn-search { background: #3498db; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .btn-clear { background: #adb5bd; color: white; text-decoration: none; padding: 8px 12px; border-radius: 5px; font-size: 13px; font-weight: bold; transition: 0.3s; }
        .btn-clear:hover { background: #6c757d; }

        /* Tabla */
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background-color: #34495e; color: white; padding: 12px; text-align: left; font-size: 13px; }
        td { padding: 12px; border-bottom: 1px solid #eee; font-size: 14px; color: #333; vertical-align: middle; }
        tr:hover { background-color: #fcfcfc; }
        
        .img-thumb { width: 50px; height: 50px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd; }
        .no-img { font-size: 11px; color: #95a5a6; font-style: italic; }

        .price { font-weight: bold; color: #27ae60; }
        .cat-tag { background: #f1f3f5; padding: 3px 8px; border-radius: 12px; font-size: 12px; color: #777; }

        /* Botones Acción */
        .link-edit { color: #3498db; text-decoration: none; font-weight: 600; margin-right: 10px; }
        .link-delete { color: #e74c3c; background: none; border: none; cursor: pointer; font-weight: 600; padding: 0; font-family: inherit; }

        /* Paginación */
        .pagination-container { margin-top: 30px; display: flex; flex-direction: column; align-items: center; gap: 10px; }
        .results-text { font-size: 13px; color: #7f8c8d; }
    </style>
</head>
<body>

<div class="container">
    <div class="header-top">
        <div class="user-info">
            Bienvenido, <strong>{{ auth()->user()->name }}</strong> 
            <span class="role-badge">{{ strtoupper(auth()->user()->rol) }}</span>
        </div>
        <a href="{{ route('logout') }}" class="btn-logout">Cerrar Sesión</a>
    </div>

    <h1>Gestión de Productos y Reportes</h1>

    {{-- BLOQUE DE BOTONES DE REPORTE (PRACTICA 11) --}}
    @auth
    <div class="reports-bar">
        <a href="{{ route('reportes.pdf') }}" class="btn-report btn-pdf">
            📄 Exportar PDF
        </a>
        <a href="{{ route('reportes.excel') }}" class="btn-report btn-excel">
            📊 Exportar Excel
        </a>
    </div>
    @endauth

    <div class="actions-bar">
        @if(auth()->user()->rol === 'admin')
            <a href="{{ route('productos.create') }}" class="btn-crear">+ Nuevo Producto</a>
        @endif
        
        <form action="{{ route('productos.index') }}" method="GET" class="search-box">
            <input type="text" name="search" class="search-input" placeholder="Buscar por nombre..." value="{{ $search ?? '' }}">
            <button type="submit" class="btn-search">Buscar</button>
            
            @if(request('search'))
                <a href="{{ route('productos.index') }}" class="btn-clear">Limpiar</a>
            @endif
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th width="40">ID</th>
                <th width="70">IMAGEN</th>
                <th>PRODUCTO</th>
                <th>CATEGORÍA</th>
                <th>PRECIO</th>
                @if(auth()->user()->rol === 'admin') <th width="150">ACCIONES</th> @endif
            </tr>
        </thead>
        <tbody>
            @forelse($productos as $producto)
            <tr>
                <td>{{ $producto->id }}</td>
                <td>
                    @if($producto->imagen)
                        <img src="{{ asset('storage/' . $producto->imagen) }}" class="img-thumb" alt="Miniatura">
                    @else
                        <span class="no-img">Sin foto</span>
                    @endif
                </td>
                <td><strong>{{ $producto->nombre }}</strong></td>
                <td><span class="cat-tag">{{ $producto->categoria->nombre ?? 'General' }}</span></td>
                <td><span class="price">${{ number_format($producto->precio, 2) }}</span></td>
                @if(auth()->user()->rol === 'admin')
                <td>
                    <a href="{{ route('productos.edit', $producto->id) }}" class="link-edit">Editar</a>
                    <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="link-delete" onclick="return confirm('¿Eliminar este producto?')">Eliminar</button>
                    </form>
                </td>
                @endif
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;">No se encontraron productos.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination-container">
        @if($productos->total() > 0)
            <div class="results-text">
                Mostrando del <b>{{ $productos->firstItem() }}</b> al <b>{{ $productos->lastItem() }}</b> de <b>{{ $productos->total() }}</b> productos.
            </div>
        @endif
        
        <div class="mini-pagination">
            {{ $productos->appends(['search' => $search ?? ''])->links() }}
        </div>
    </div>
</div>

</body>
</html>
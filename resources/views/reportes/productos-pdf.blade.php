<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body  { font-family: Arial, sans-serif; font-size: 12px; }
        h1    { color: #1A3A5C; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th    { background: #0D7C8C; color: #fff; padding: 6px 8px; }
        td    { padding: 5px 8px; border-bottom: 1px solid #ccc; }
        tr:nth-child(even) { background: #EBF4F6; }
    </style>
</head>
<body>
    <h1>Catálogo de Productos</h1>
    <p>Generado el: {{ now()->format('d/m/Y H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->nombre }}</td>
                <td>{{ $p->categoria->nombre ?? 'Sin categoria' }}</td>
                <td>${{ number_format($p->precio, 2) }}</td>
                <td>{{ $p->stock }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
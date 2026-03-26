@extends('layouts.app')

@section('content')
    <h1>Detalles del Usuario</h1>
    <div class="card shadow-sm">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $usuario->id }}</p>
            <p><strong>Nombre:</strong> {{ $usuario->nombre }}</p>
            <p><strong>Email:</strong> {{ $usuario->email }}</p>
            <p><strong>Creado el:</strong> {{ $usuario->created_at->format('d/m/Y H:i') }}</p>
            <hr>
            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Regresar</a>
            <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-warning">Editar</a>
        </div>
    </div>
@endsection
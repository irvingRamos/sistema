@extends('layouts.app')

@section('content')

<h1>Nuevo Usuario</h1>

<form action="{{ route('usuarios.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <input type="text" name="nombre" placeholder="Nombre" class="form-control" required>
    </div>

    <div class="mb-3">
        <input type="email" name="email" placeholder="Email" class="form-control" required>
    </div>

    <button class="btn btn-success">Guardar</button>
    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Volver</a>
</form>

@endsection
<!-- Inicio del Bloque de Notificaciones -->
@auth
    @php 
        // Obtenemos el conteo de notificaciones no leídas del usuario actual
        $unreadCount = auth()->user()->unreadNotifications->count(); 
    @php

    <li class="nav-item">
        <a class="nav-link" href="{{ route('notificaciones.index') }}" style="position: relative; display: flex; align-items: center;">
            <i class="fas fa-bell"></i> <!-- Si usas FontAwesome -->
            <span class="ml-1">Notificaciones</span>
            
            @if($unreadCount > 0)
                <span class="badge badge-danger" style="
                    background-color: #ff0000; 
                    color: white; 
                    border-radius: 50%; 
                    padding: 0.25rem 0.5rem; 
                    font-size: 0.7rem; 
                    position: absolute; 
                    top: -5px; 
                    right: -5px;
                    font-weight: bold;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
                ">
                    {{ $unreadCount }}
                </span>
            @endif
        </a>
    </li>
@endauth
<!-- Fin del Bloque de Notificaciones -->

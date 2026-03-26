<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Producto;

class ProductoCreado extends Notification
{
    use Queueable;

    /**
     * El constructor recibe el objeto del producto recién creado.
     */
    public function __construct(public Producto $producto) {}

    /**
     * Definimos que la notificación se guarde en la base de datos.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Definimos los datos que se guardarán en la columna 'data' (JSON).
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'mensaje'     => 'Se registró el producto: ' . $this->producto->nombre,
            'producto_id' => $this->producto->id,
            'precio'      => $this->producto->precio,
            'url'         => route('productos.show', $this->producto->id),
        ];
    }

    /**
     * Requerido para que Laravel procese la notificación correctamente.
     */
    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
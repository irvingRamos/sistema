<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Producto;

class StockBajoDB extends Notification
{
    use Queueable;

    // El constructor recibe el objeto producto
    public function __construct(public Producto $producto) {}

    // Canal de base de datos
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    // Datos que se guardan en la tabla
    public function toDatabase(object $notifiable): array
    {
        return [
            'mensaje'      => '⚠️ STOCK BAJO: El producto "' . $this->producto->nombre . '" tiene solo ' . $this->producto->stock . ' unidades.',
            'producto_id'  => $this->producto->id,
            'url'          => route('productos.edit', $this->producto->id),
        ];
    }

    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
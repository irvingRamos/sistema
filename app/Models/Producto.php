<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'categoria_id', 
        'precio',
        'stock',
        'descripcion',
        'imagen'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('nombre', 'LIKE', "%{$search}%")
                         ->orWhere('descripcion', 'LIKE', "%{$search}%");
        }
    }
}

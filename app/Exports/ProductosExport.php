<?php

namespace App\Exports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductosExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        // Traemos productos con su categoría para que no salga vacío
        return Producto::with('categoria')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Nombre del Producto', 'Categoría', 'Precio', 'Existencias'];
    }

    public function map($p): array
    {
        return [
            $p->id,
            $p->nombre,
            $p->categoria->nombre ?? 'Sin categoría',
            '$' . number_format($p->precio, 2),
            $p->stock
        ];
    }
}
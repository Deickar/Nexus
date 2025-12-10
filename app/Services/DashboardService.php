<?php

namespace App\Services;

use App\Models\Producto;
use App\Models\Pedido;
use App\Models\User;
use App\Models\Categoria;
use App\Models\Marca;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function obtenerEstadisticas()
    {
        return [
            'total_productos' => Producto::count(),
            'productos_activos' => Producto::where('estado', 'activo')->count(),
            'total_pedidos' => Pedido::count(),
            'pedidos_pendientes' => Pedido::where('estado', 'pendiente')->count(),
            'total_usuarios' => User::count(),
            'total_categorias' => Categoria::count(),
            'total_marcas' => Marca::count(),
            'ventas_totales' => Pedido::whereIn('estado', ['pagado', 'enviado', 'entregado'])->sum('monto_total'),
        ];
    }
    
    public function obtenerProductosStockBajo($limite = 10)
    {
        // Mantener Eloquent porque las vistas esperan objetos de modelo
        return Producto::with(['categoria', 'marca'])
            ->where('existencia', '<', $limite)
            ->where('estado', 'activo')
            ->get();
    }
    
    public function obtenerUltimosPedidos($cantidad = 10)
    {
        // Mantener Eloquent porque las vistas esperan objetos de modelo
        return Pedido::with(['usuario'])
            ->orderBy('fecha_creacion', 'desc')
            ->limit($cantidad)
            ->get();
    }
}

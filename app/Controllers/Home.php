<?php

namespace App\Controllers;

use App\Models\UsuariosModel;
use App\Models\ProductosModel;
use App\Models\DetalleVentaModel;
use App\Models\VentasModel;
use App\Models\CategoriasModel;



class Home extends BaseController
{
    protected $productosModel;
    protected $detalleVentaModel;
    protected $ventasModel;
    protected $categoriasModel;

    public function __construct()
    {
        $this->productosModel = new ProductosModel();
        $this->detalleVentaModel = new DetalleVentaModel();
        $this->ventasModel = new VentasModel();
        $this->categoriasModel = new CategoriasModel();
    }

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('dashboard'));
        }
        return view('login');
    }

    public function dashboard(): string
    {

        $total = $this->productosModel->totalProductos();
        $minimos = $this->productosModel->productoMinimo();
        $totalVendidos = $this->detalleVentaModel->totalProductosVendidos();
        $hoy = date('Y-m-d');
        $totalVentas = $this->ventasModel->totalDia($hoy);

        // agregar conteo de ventas del mes actual
        $currentYear  = date('Y');
        $currentMonth = date('m');
        $totalVentasMes = $this->ventasModel->totalMes($currentYear, $currentMonth);

        $totalCategorias = $this->categoriasModel->obtener();
        $datos = [
            'total' => $total,
            'totalVendidos' => $totalVendidos,
            'totalVentas' => $totalVentas,
            'totalVentasMes' => $totalVentasMes,
            'categorias' => count($totalCategorias),
            'minimos' => $minimos
        ];
        return view('header')
            . view('dashboard', [
                'title' => 'Panel Principal - Doña Nuria',
                'datos' => $datos
            ])
            . view('footer');
    }
}

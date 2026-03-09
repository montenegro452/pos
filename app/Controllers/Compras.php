<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;
use App\Controllers\BaseController;
use App\Models\ComprasModel;
use App\Models\TemporalCompraModel;
use App\Models\DetalleCompraModel;
use App\Models\ProductosModel;
use App\Models\ConfiguracionModel;

class Compras extends BaseController
{
	protected $compras, $temporal_compra, $detalle_compra, $productos, $configuracion;

	public function __construct()
	{
		$this->compras = new ComprasModel();
		$this->detalle_compra = new DetalleCompraModel();
		$this->configuracion = new ConfiguracionModel();
		helper(['form']);
	}

	public function index($activo = 1)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('compras_ver')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Categorias');
			return redirect()->to(base_url('dashboard'));
		}
		$compras = $this->compras->where('activo', $activo)->findAll();
		$data = ['titulo' => 'Compras', 'compras' => $compras];
		return view('header')
			. view('compras/index', $data)
			. view('footer');
	}

	public function nuevo()
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('compras_agregar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Categorias');
			return redirect()->to(base_url('dashboard'));
		}
		return view('header')
			. view('compras/nuevo')
			. view('footer');
	}

	public function guarda()
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('compras_agregar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Categorias');
			return redirect()->to(base_url('dashboard'));
		}
		$id_compra = $this->request->getPost('id_compra');
		$total = preg_replace('/[\$,]/', '', $this->request->getPost('total'));

		$session = session();
		$this->temporal_compra = new TemporalCompraModel();
		$resultadoCompra = $this->temporal_compra->porCompra($id_compra);

		$total = 0;
		foreach ($resultadoCompra as $row) {
			$total += floatval(str_replace(',', '.', $row['subtotal']));
		}

		$resultado_id = $this->compras->insertaCompra($id_compra, $total, $session->id_usuario);

		if ($resultado_id) {
			foreach ($resultadoCompra as $row) {
				$this->detalle_compra->save([
					'id_compra' => $resultado_id,
					'id_producto' => $row['id_producto'],
					'nombre' => $row['nombre'],
					'cantidad' => $row['cantidad'],
					'precio' => $row['precio']
				]);

				$this->productos = new ProductosModel();
				$this->productos->actualizarStock($row['id_producto'], $row['cantidad']);
			}
			$this->temporal_compra->eliminaCompra($id_compra);
		}
		return redirect()->to(base_url('compras/muestraCompraPdf/' . $resultado_id));
	}

	function muestraCompraPdf($id_compra)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('compras_ver')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Categorias');
			return redirect()->to(base_url('dashboard'));
		}
		$data['id_compra'] = $id_compra;
		return view('header')
			. view('compras/ver_compra_pdf', $data)
			. view('footer');
	}

	function generaCompraPdf($id_compra)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('compras_agregar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Categorias');
			return redirect()->to(base_url('dashboard'));
		}
		$datosCompra = $this->compras->where('id', $id_compra)->first();
		$detalleCompra = $this->detalle_compra->select('*')->where('id_compra', $id_compra)->findAll();
		$nombreTienda = $this->configuracion->select('valor')->where('nombre', 'tienda_nombre')->get()->getRow()->valor;
		$direccionTienda = $this->configuracion->select('valor')->where('nombre', 'tienda_direccion')->get()->getRow()->valor;

		$fecha = Time::parse($datosCompra['fecha_alta']);

		$pdf = new \FPDF('P', 'mm', 'letter');
		$pdf->AddPage();
		$pdf->SetMargins(10, 10, 10);
		$pdf->SetTitle('Compra');
		$pdf->AddFont('Roboto-Regular', '', 'Roboto-Regular.php');
		$pdf->AddFont('Roboto-Regular', 'B', 'Roboto-Bold.php');
		$pdf->AddFont('Roboto-Regular', 'L', 'Roboto-Light.php');

		$pdf->SetFont('Roboto-Regular', 'B', 10);
		$pdf->Cell(195, 5, "Entrada de Productos", 0, 1, 'C');

		$pdf->SetFont('Roboto-Regular', 'B', 9);
		$pdf->Image(base_url() . '/images/logo.png', 185, 10, 20, 10, 'PNG');
		$pdf->Cell(50, 5, utf8_decode($nombreTienda), 0, 1, 'L');
		$pdf->Cell(20, 5, utf8_decode('Dirección: '), 0, 0, 'L');
		$pdf->SetFont('Roboto-Regular', 'L', 9);
		$pdf->Cell(20, 5, utf8_decode($direccionTienda), 0, 1, 'L');
		$pdf->SetFont('Roboto-Regular', 'B', 9);
		$pdf->Cell(25, 5, 'Fecha y hora: ', 0, 0, 'L');
		$pdf->SetFont('Roboto-Regular', 'L', 9);
		$pdf->Cell(20, 5, $fecha->format('d/m/Y H:i:s'), 0, 1, 'L');

		$pdf->Ln();
		$pdf->SetFont('Roboto-Regular', 'B', 9);
		$pdf->SetFillColor(70, 89, 122);
		$pdf->SetTextColor(245, 245, 245);
		$pdf->Cell(196, 5, 'Detalle de Productos', 1, 1, 'C', 1);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->Cell(14, 5, 'No.', 1, 0, 'L');
		$pdf->Cell(25, 5, 'Codigo', 1, 0, 'L');
		$pdf->Cell(77, 5, 'Nombre', 1, 0, 'L');
		$pdf->Cell(25, 5, 'Precio', 1, 0, 'L');
		$pdf->Cell(25, 5, 'Cantidad', 1, 0, 'L');
		$pdf->Cell(30, 5, 'Importe', 1, 1, 'L');

		$pdf->SetFont('Roboto-Regular', 'L', 8);
		$contador = 1;
		foreach ($detalleCompra as $row) {
			$precio = floatval(str_replace(',', '.', $row['precio']));
			$importe = $precio * $row['cantidad'];

			$pdf->Cell(14, 5, $row['id'], 1, 0, 'L');
			$pdf->Cell(25, 5, utf8_decode($row['id_producto']), 1, 0, 'L');
			$pdf->Cell(77, 5, utf8_decode($row['nombre']), 1, 0, 'L');
			$pdf->Cell(25, 5, '$' . number_format($precio, 2), 1, 0, 'L');
			$pdf->Cell(25, 5, number_format($row['cantidad'], 2), 1, 0, 'L');
			$pdf->Cell(30, 5, '$' . number_format($importe, 2), 1, 1, 'R');
			$contador++;
		}
		$pdf->Ln();
		$pdf->SetFont('Roboto-Regular', 'B', 8);
		$pdf->Cell(0, 5, 'Total: $ ' . number_format($datosCompra['total'], 2), 0, 1, 'R');


		$this->response->setHeader('Content-Type', 'application/pdf');
		$pdf->Output("compra_pdf.pdf", "I");
	}
}

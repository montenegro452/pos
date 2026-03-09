<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;
use App\Controllers\BaseController;
use App\Models\VentasModel;
use App\Models\TemporalVentaModel;
use App\Models\DetalleVentaModel;
use App\Models\ProductosModel;
use App\Models\ConfiguracionModel;
use App\Models\CajasModel;
use App\Models\ArqueoCajaModel;
use PHPUnit\Framework\Attributes\Ticket;

class Ventas extends BaseController
{
	protected $ventas, $temporal_venta, $detalle_venta, $productos, $configuracion, $cajas, $arqueo;

	public function __construct()
	{
		$this->ventas = new VentasModel();
		$this->detalle_venta = new DetalleVentaModel();
		$this->configuracion = new ConfiguracionModel();
		$this->productos = new ProductosModel();
		$this->cajas = new CajasModel();
		$this->arqueo = new ArqueoCajaModel();
		helper('form');
	}

	public function index()
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('ventas_ver')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Ventas');
			return redirect()->to(base_url('dashboard'));
		}
		$datos = $this->ventas->obtener(1);
		$data = ['titulo' => 'Ventas', 'datos' => $datos];

		return view('header')
			. view('ventas/index', $data)
			. view('footer');
	}

	public function eliminados()
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('ventas_ver')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Ventas');
			return redirect()->to(base_url('dashboard'));
		}
		$datos = $this->ventas->obtener(0);
		$data = ['titulo' => 'Ventas eliminadas', 'datos' => $datos];

		return view('header')
			. view('ventas/eliminados', $data)
			. view('footer');
	}

	public function venta()
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('ventas_agregar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Ventas');
			return redirect()->to(base_url('dashboard'));
		}

		// Verificar si hay una caja abierta
		$session = session();
		if (!isset($session->id_caja) || empty($session->id_caja)) {
			session()->setFlashdata('msg_error', 'No tienes una caja asignada. Contacta al administrador.');
			return redirect()->to(base_url('dashboard'));
		}

		$arqueoAbierto = $this->arqueo->where(['id_caja' => $session->id_caja, 'estatus' => 1])->first();
		if (!$arqueoAbierto) {
			session()->setFlashdata('msg_error', 'No puedes realizar ventas sin tener una caja abierta. Abre la caja primero.');
			return redirect()->to(base_url('cajas'));
		}

		$data_header = ['title' => 'Sistema de Ventas - Caja'];
		$data = ['titulo' => 'Caja'];
		return view('header', $data_header)
			. view('ventas/caja', $data)
			. view('footer');
	}

	public function guarda()
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('ventas_agregar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Ventas');
			return redirect()->to(base_url('dashboard'));
		}

		$session = session();

		// Verificar si hay una caja abierta
		if (!isset($session->id_caja) || empty($session->id_caja)) {
			session()->setFlashdata('msg_error', 'No tienes una caja asignada. Contacta al administrador.');
			return redirect()->to(base_url('ventas/venta'));
		}

		$arqueoAbierto = $this->arqueo->where(['id_caja' => $session->id_caja, 'estatus' => 1])->first();
		if (!$arqueoAbierto) {
			session()->setFlashdata('msg_error', 'No puedes realizar ventas sin tener una caja abierta. Abre la caja primero.');
			return redirect()->to(base_url('ventas/venta'));
		}

		$id_venta = $this->request->getPost('id_venta');
		$forma_pago = $this->request->getPost('forma_pago');
		$id_cliente = $this->request->getPost('id_cliente');
		$total = preg_replace('/[\$,]/', '', $this->request->getPost('total'));

		$caja = $this->cajas->where('id', $session->id_caja)->first();
		$folio = $caja['folio'];
		$folio_formateado = str_pad($folio, 7, '0', STR_PAD_LEFT);

		if ($id_cliente == "") {
			$id_cliente = '2';
		}

		$resultado_id = $this->ventas->insertaVenta($folio_formateado, $total, $session->id_usuario, $session->id_caja, $id_cliente, $forma_pago);

		$this->temporal_venta = new TemporalVentaModel();
		if ($resultado_id) {
			$folio++;
			$this->cajas->update($session->id_caja, ['folio' => $folio]);
			$resultadoVenta = $this->temporal_venta->porVenta($id_venta);
			foreach ($resultadoVenta as $row) {
				$this->detalle_venta->save([
					'id_venta' => $resultado_id,
					'id_producto' => $row['id_producto'],
					'nombre' => $row['nombre'],
					'cantidad' => $row['cantidad'],
					'precio' => $row['precio']
				]);

				$this->productos = new ProductosModel();
				$this->productos->actualizarStock($row['id_producto'], $row['cantidad'], '-');
			}
			$this->temporal_venta->eliminaVenta($id_venta);
		}
		return redirect()->to(base_url('ventas/muestraTicket/' . $resultado_id));
	}

	function muestraTicket($id_venta)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('ventas_ver')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Ventas');
			return redirect()->to(base_url('dashboard'));
		}
		$data['id_venta'] = $id_venta;
		return view('header')
			. view('ventas/ver_ticket', $data)
			. view('footer');
	}

	function generaTicket($id_venta)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('ventas_ver')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Ventas');
			return redirect()->to(base_url('dashboard'));
		}
		$datosVenta = $this->ventas->where('id', $id_venta)->first();
		$detalleVenta = $this->detalle_venta->select('*')->where('id_venta', $id_venta)->findAll();
		$nombreTienda = $this->configuracion->select('valor')->where('nombre', 'tienda_nombre')->get()->getRow()->valor;
		$direccionTienda = $this->configuracion->select('valor')->where('nombre', 'tienda_direccion')->get()->getRow()->valor;
		$ticketLeyenda = $this->configuracion->select('valor')->where('nombre', 'tienda_leyenda')->get()->getRow()->valor;

		$fecha = Time::parse($datosVenta['fecha_alta']);

		$pdf = new \FPDF('P', 'mm', 'letter');
		$pdf->AddPage();
		$pdf->SetMargins(10, 10, 10);
		$pdf->SetTitle('Venta');
		$pdf->AddFont('Roboto-Regular', '', 'Roboto-Regular.php');
		$pdf->AddFont('Roboto-Regular', 'B', 'Roboto-Bold.php');
		$pdf->AddFont('Roboto-Regular', 'L', 'Roboto-Light.php');

		$pdf->SetFont('Roboto-Regular', 'B', 10);
		$pdf->Cell(195, 5, "Venta de Productos", 0, 1, 'C');

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
		$pdf->SetFont('Roboto-Regular', 'B', 9);
		$pdf->Cell(13, 5, 'Ticket:', 0, 0, 'L');
		$pdf->SetFont('Roboto-Regular', 'B', 9);
		$pdf->Cell(15, 5, $datosVenta['folio'], 0, 1, 'L');

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
		foreach ($detalleVenta as $row) {
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
		$pdf->Cell(0, 5, 'Total: $ ' . number_format($datosVenta['total'], 2), 0, 1, 'R');

		$pdf->Ln();
		$pdf->MultiCell(195, 4, $ticketLeyenda, 0, 'C', 0);


		$this->response->setHeader('Content-Type', 'application/pdf');
		$pdf->Output("ticket.pdf", "I");
	}

	public function eliminar($id)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('ventas_editar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Ventas');
			return redirect()->to(base_url('dashboard'));
		}
		// Obtener la venta antes de eliminarla para recuperar el folio y la caja
		$venta = $this->ventas->where('id', $id)->first();

		if ($venta) {
			$id_caja = $venta['id_caja'];

			// Obtener la caja y decrementar el folio
			$caja = $this->cajas->where('id', $id_caja)->first();

			if ($caja && $caja['folio'] > 0) {
				$folio_actual = $caja['folio'];
				$this->cajas->update($id_caja, ['folio' => $folio_actual - 1]);
			}
		}

		$productos = $this->detalle_venta->where('id_venta', $id)->findAll();

		foreach ($productos as $producto) {
			$this->productos->actualizarStock($producto['id_producto'], $producto['cantidad'], '+');
		}

		$this->ventas->update($id, ['activo' => 0]);

		return redirect()->to(base_url() . 'ventas');
	}
}

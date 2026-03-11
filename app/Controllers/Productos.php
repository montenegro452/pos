<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductosModel;
use App\Models\UnidadesModel;
use App\Models\CategoriasModel;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Productos extends BaseController
{
	protected $productos;
	protected $unidades;
	protected $categorias;
	protected $reglas;


	public function __construct()
	{
		$this->productos = new ProductosModel();
		$this->unidades = new UnidadesModel();
		$this->categorias = new CategoriasModel();

		helper(['form']);
		$this->reglas = [
			'codigo' => [
				'rules' => 'required|is_unique[productos.codigo]',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.',
					'is_unique' => 'El campo {field} debe ser unico.'
				]
			],

			'nombre' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.'
				]
			]
		];
	}

	public function index($activo = 1)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('productos_ver')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Productos');
			return redirect()->to(base_url('dashboard'));
		}
		$productos = $this->productos->where('activo', $activo)->orderBy('id', 'DESC')->findAll();
		$data = ['titulo' => 'Productos', 'datos' => $productos];
		echo view('header');
		echo view('productos/index', $data);
		echo view('footer');
	}

	public function eliminados($activo = 0)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('productos_ver')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Productos');
			return redirect()->to(base_url('dashboard'));
		}

		$productos = $this->productos->where('activo', $activo)->findAll();
		$data = ['titulo' => 'Productos eliminados', 'datos' => $productos];
		echo view('header');
		echo view('productos/eliminados', $data);
		echo view('footer');
	}

	public function nuevo()
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('productos_agregar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Productos');
			return redirect()->to(base_url('dashboard'));
		}
		$categorias = $this->categorias->where('activo', 1)->findAll();
		$unidades = $this->unidades->where('activo', 1)->findAll();
		$data = ['titulo' => 'Agregar producto', 'unidades' => $unidades, 'categorias' => $categorias];

		echo view('header');
		echo view('productos/nuevo', $data);
		echo view('footer');
	}

	public function insertar()
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('productos_agregar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Productos');
			return redirect()->to(base_url('dashboard'));
		}

		$codigo = $this->request->getPost('codigo');
		$activo = $this->request->getPost('activo');
		$nombre = $this->request->getPost('nombre');
		$precio_venta = $this->request->getPost('precio_venta');
		$precio_compra = $this->request->getPost('precio_compra');
		$stock_minimo = $this->request->getPost('stock_minimo');
		$inventariable = $this->request->getPost('inventariable');
		$existencias = $this->request->getPost('existencias');
		$id_unidad = $this->request->getPost('id_unidad');
		$id_categoria = $this->request->getPost('id_categoria');

		if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
			$this->productos->save([
				'codigo' => $codigo,
				'activo' => $activo,
				'nombre' => $nombre,
				'precio_venta' => $precio_venta,
				'precio_compra' => $precio_compra,
				'stock_minimo' => $stock_minimo,
				'inventariable' => $inventariable,
				'existencias' => $existencias,
				'id_unidad' => $id_unidad,
				'id_categoria' => $id_categoria
			]);

			$id = $this->productos->insertID();

			$validacion = $this->validate([
				'img_producto' => [
					'rules' => 'uploaded[img_producto]|mime_in[img_producto,image/jpg,image/jpeg,image/png]|max_size[img_producto,4096]',
					'errors' => [
						'uploaded' => 'Debes subir un producto para la tienda.',
						'mime_in' => 'El producto debe ser una imagen en formato PNG o JPG.',
						'max_size' => 'La foto del producto no debe exceder los 4MB de tamaño.'
					]
				]
			]);
			if ($validacion) {
				$ruta_logo = "images/productos/" . $id . ".jpg";
				if (file_exists($ruta_logo)) {
					unlink($ruta_logo);
				}
				$img = $this->request->getFile('img_producto');
				$img->move('./images/productos', $id . '.jpg');
			}

			session()->setFlashdata('msg_success', 'Producto ' . $nombre . ' Guardado');
			return redirect()->to(base_url('productos'));
		} else {
			$categorias = $this->categorias->where('activo', 1)->findAll();
			$unidades = $this->unidades->where('activo', 1)->findAll();
			$data = ['titulo' => 'Agregar producto', 'unidades' => $unidades, 'categorias' => $categorias, 'validation' => $this->validator];
			return view('header')
				. view('productos/nuevo', $data)
				. view('footer');
		}
	}


	public function editar($id)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('productos_editar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Productos');
			return redirect()->to(base_url('dashboard'));
		}
		$unidades = $this->unidades->where('activo', 1)->findAll();
		$categorias = $this->categorias->where('activo', 1)->findAll();
		$producto = $this->productos->where('id', $id)->first();
		$data = ['titulo' => 'Editar producto', 'unidades' => $unidades, 'categorias' => $categorias, 'producto' => $producto];

		echo view('header');
		echo view('productos/editar', $data);
		echo view('footer');
	}

	public function actualizar()
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('productos_editar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Productos');
			return redirect()->to(base_url('dashboard'));
		}
		$id = $this->request->getPost('id');
		$nombre = $this->request->getPost('nombre');

		$this->productos->update($id, [
			'codigo' => $this->request->getPost('codigo'),
			'nombre' => $nombre,
			'precio_venta' => $this->request->getPost('precio_venta'),
			'precio_compra' => $this->request->getPost('precio_compra'),
			'stock_minimo' => $this->request->getPost('stock_minimo'),
			'inventariable' => $this->request->getPost('inventariable'),
			'id_unidad' => $this->request->getPost('id_unidad'),
			'id_categoria' => $this->request->getPost('id_categoria'),
			'existencias' => $this->request->getPost('existencias')
		]);

		// Procesar carga de foto si se envía
		if (!empty($_FILES['img_producto']['name'])) {
			$validacion = $this->validate([
				'img_producto' => [
					'rules' => 'mime_in[img_producto,image/jpg,image/jpeg,image/png]|max_size[img_producto,4096]',
					'errors' => [
						'mime_in' => 'La foto debe ser en formato JPG o PNG.',
						'max_size' => 'La foto no debe exceder los 4MB de tamaño.'
					]
				]
			]);

			if ($validacion) {
				$ruta_foto = "images/productos/" . $id . ".jpg";
				if (file_exists($ruta_foto)) {
					unlink($ruta_foto);
				}
				$img = $this->request->getFile('img_producto');
				$img->move('./images/productos', $id . '.jpg');
			}
		}

		session()->setFlashdata('msg_success', 'Producto Guardado');
		return redirect()->to(base_url('productos'));
	}

	public function eliminar($id)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('productos_eliminar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Productos');
			return redirect()->to(base_url('dashboard'));
		}
		$this->productos->update($id, ['activo' => 0]);
		session()->setFlashdata('msg_success', 'Producto Eliminado');
		return redirect()->to(base_url('productos'));
	}

	public function reingresar($id)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('productos_editar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Productos');
			return redirect()->to(base_url('dashboard'));
		}
		$this->productos->update($id, ['activo' => 1]);
		session()->setFlashdata('msg_success', 'Producto Reingresado');
		return redirect()->to(base_url('productos'));
	}
	public function buscarPorCodigo($codigo)
	{
		$this->productos->select('*');
		$this->productos->where('codigo', $codigo);
		$this->productos->where('activo', 1);
		$datos = $this->productos->get()->getRow();

		$existe['existe'] = false;
		$res['datos'] = '';
		$error['error'] = '';

		if ($datos) {
			$res['datos'] = $datos;
			$res['existe'] = true;
			$res['error'] = '';
		} else {
			$res['error'] = "No existe el producto";
			$res['existe'] = false;
		}
		echo json_encode($res);
	}

	public function autocompleteData()
	{
		$returnData = array();
		$valor = $this->request->getGet('term');
		$productos = $this->productos->like('codigo', $valor)->where('activo', 1)->findAll();
		if (!empty($productos)) {
			foreach ($productos as $row) {
				$data['id'] = $row['id'];
				$data['value'] = $row['codigo'];
				$data['label'] = $row['codigo'] . ' - ' . $row['nombre'];
				array_push($returnData, $data);
			}
		}
		echo json_encode($returnData);
	}

	public function muestraCodigo()
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('productos_ver')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Productos');
			return redirect()->to(base_url('dashboard'));
		}
		return view('header')
			. view('productos/codigo_barras')
			. view('footer');
	}

	public function generaBarras()
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('productos_ver')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Productos');
			return redirect()->to(base_url('dashboard'));
		}
		$pdf = new \FPDF('P', 'mm', 'letter');
		$pdf->AddPage();
		$pdf->SetMargins(10, 10, 10);
		$pdf->SetTitle(mb_convert_encoding("Códigos de Barras", 'ISO-8859-1', 'UTF-8'));
		$pdf->SetFont('Arial', 'B', 12);

		$productos = $this->productos->where('activo', 1)->findAll();
		foreach ($productos as $producto) {
			$codigo = $producto['codigo'];
			$ruta_barcode = "./images/barcode/$codigo.png";

			$generaBarcode = new \barcode_genera();
			$generaBarcode->barcode(
				$ruta_barcode,
				$codigo,
				20,
				"horizontal",
				"code128",
				true
			);

			$pdf->Image($ruta_barcode);
		}

		$this->response->setHeader('Content-Type', 'application/pdf');
		$pdf->Output('Codigo.pdf', 'I');
	}

	public function mostrarMinimos()
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('productos_ver')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Productos');
			return redirect()->to(base_url('dashboard'));
		}
		return view('header')
			. view('productos/ver_minimos')
			. view('footer');
	}

	public function generaMinimosPdf()
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('productos_ver')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Productos');
			return redirect()->to(base_url('dashboard'));
		}
		$pdf = new \FPDF('P', 'mm', 'letter');
		$pdf->AddPage();
		$pdf->SetMargins(10, 10, 10);
		$pdf->SetTitle("Productos con Stock Minimo");
		$pdf->SetFont('Arial', 'B', 12);

		$pdf->Image(base_url('images/logo.png'), 10, 10, 30);
		$pdf->Cell(0, 5, mb_convert_encoding('Reporte de Productos con Stock Mínimo', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
		$pdf->Ln(15);
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(25, 5, mb_convert_encoding('Código', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
		$pdf->Cell(70, 5, mb_convert_encoding('Nombre', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
		$pdf->Cell(40, 5, mb_convert_encoding('Existencias', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
		$pdf->Cell(40, 5, mb_convert_encoding('Stock Mínimo', 'ISO-8859-1', 'UTF-8'), 1, 1, 'C');

		$pdf->SetFont('Arial', '', 10);

		$datosProductos = $this->productos->getproductoMinimo();
		foreach ($datosProductos as $producto) {
			$pdf->Cell(25, 5, $producto['codigo'], 1, 0, 'C');
			$pdf->Cell(70, 5, mb_convert_encoding($producto['nombre'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
			$pdf->Cell(40, 5, $producto['existencias'], 1, 0, 'C');
			$pdf->Cell(40, 5, $producto['stock_minimo'], 1, 1, 'C');
		}
		$this->response->setHeader('Content-Type', 'application/pdf');
		$pdf->Output('ProductoMinimo.pdf', 'I');
	}

	public function mostrarMinimosExcel()
	{
		$phpExcel = new Spreadsheet();
		$phpExcel->getProperties()->setCreator("Carlos Montenegro Garcia")
			->setTitle("Productos con Stock Mínimo")
			->setSubject("Reporte de Productos con Stock Mínimo")
			->setDescription("Reporte generado por el sistema POS");

		$hoja = $phpExcel->getActiveSheet();

		$drawings = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		$drawings->setName('Logo');
		$drawings->setDescription('Logo de la tienda');
		$drawings->setPath('./images/logo.png');
		$drawings->setHeight(50);
		$drawings->setCoordinates('A1');
		$drawings->setWorksheet($hoja);

		$hoja->mergeCells('A3:D3');
		$hoja->getStyle('A3')->getAlignment()->setHorizontal('center');
		$hoja->getStyle('A3')->getFont()->setSize(14)->setBold(true);
		$hoja->setCellValue('A3', 'Reporte de Productos con Stock Mínimo');
		$hoja->getStyle('A5:D5')->getAlignment()->setHorizontal('center');
		$hoja->getStyle('A5:D5')->getFont()->setBold(true);
		$hoja->setCellValue('A5', 'Codigo');
		$hoja->getColumnDimension('A')->setWidth(15);
		$hoja->setCellValue('B5', 'Nombre');
		$hoja->getColumnDimension('B')->setWidth(40);
		$hoja->setCellValue('C5', 'Existencias');
		$hoja->getColumnDimension('C')->setWidth(15);
		$hoja->setCellValue('D5', 'Stock Minimo');
		$hoja->getColumnDimension('D')->setWidth(20);

		$datosProductos = $this->productos->getproductoMinimo();

		$fila = 6;
		foreach ($datosProductos as $producto) {
			$hoja->getStyle('A' . $fila . ':D' . $fila)->getAlignment()->setHorizontal('right');
			$hoja->setCellValue('A' . $fila, $producto['codigo']);
			$hoja->setCellValue('B' . $fila, $producto['nombre']);
			$hoja->setCellValue('C' . $fila, $producto['existencias']);
			$hoja->setCellValue('D' . $fila, $producto['stock_minimo']);
			$fila++;
		}

		$ultimaFila = $fila - 1;
		$estiloBordes = [
			'borders' => [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['argb' => 'FF000000'],
				],
			],
		];
		$hoja->getStyle('A5:D' . $ultimaFila)->applyFromArray($estiloBordes);
		$hoja->setCellValueExplicit(
			'C' . $fila,
			'=SUM(C6:C' . $ultimaFila . ')',
			\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_FORMULA
		);

		$writer = new Xlsx($phpExcel);
		$writer->save("reportes/reporte_minimo.xlsx");
	}
}

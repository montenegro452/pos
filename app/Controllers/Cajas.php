<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CajasModel;
use App\Models\ArqueoCajaModel;
use App\Models\VentasModel;
use Config\Validation;

class Cajas extends BaseController
{
	protected $cajas, $arqueoModel, $ventasModel;
	protected $reglas;

	public function __construct()
	{
		$this->cajas = new CajasModel();
		$this->arqueoModel = new ArqueoCajaModel();
		$this->ventasModel = new VentasModel();
		$this->reglas = [
			'nombre' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.'
				]
			],

			'nombre_corto' => [
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
		if (!tienePermiso('cajas_ver')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Cajas');
			return redirect()->to(base_url('dashboard'));
		}
		$cajas = $this->cajas->where('activo', $activo)->findAll();
		$data = ['titulo' => 'Cajas', 'datos' => $cajas];
		return view('header')
			. view('cajas/index', $data)
			. view('footer');
	}

	public function nuevo()
	{
		$data = ['titulo' => 'Agregar caja'];
		return view('header')
			. view('cajas/nuevo', $data)
			. view('footer');
	}

	public function insertar()
	{
		$nombre = $this->request->getPost('nombre');

		if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
			$this->cajas->save([
				'nombre' => $nombre
			]);
			session()->setFlashdata('msg_success', 'Caja ' . $nombre . ' Guardada');
			return redirect()->to(base_url('cajas'));
		} else {
			$data = ['titulo' => 'Agregar caja', 'validation' => $this->validator];

			return view('header')
				. view('cajas/nuevo', $data)
				. view('footer');
		}
	}

	public function editar($id, $valid = null)
	{
		$cajas = $this->cajas->where('id', $id)->first();
		if ($valid != null) {
			$data = ['titulo' => 'Editar caja', 'datos' => $cajas, 'validation' => $valid];
		} else {
			$data = ['titulo' => 'Editar caja', 'datos' => $cajas];
		}

		return view('header')
			. view('cajas/editar', $data)
			. view('footer');
	}

	public function actualizar()
	{
		if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
			$this->cajas->update($this->request->getPost('id'), [
				'nombre' => $this->request->getPost('nombre'),
				'nombre_corto' => $this->request->getPost('nombre_corto')
			]);
			session()->setFlashdata('msg_success', 'Caja Guardada');
			return redirect()->to(base_url('cajas'));
		} else {
			return $this->editar($this->request->getPost('id'), $this->validator);
		}
	}

	public function eliminar($id)
	{
		$this->cajas->update($id, ['activo' => 0]);
		session()->setFlashdata('msg_success', 'Caja Eliminada');
		return redirect()->to(base_url('cajas'));
	}

	public function eliminados($activo = 0)
	{
		$cajas = $this->cajas->where('activo', $activo)->findAll();
		$data = ['titulo' => 'Cajas Eliminadas', 'datos' => $cajas];
		return view('header')
			. view('cajas/eliminados', $data)
			. view('footer');
	}

	public function reingresar($id = null)
	{
		if ($id === null) {
			$id = $this->request->getPost('id');
		}
		if ($id) {
			$this->cajas->update($id, ['activo' => 1]);
			// Mensaje para el usuario
			session()->setFlashdata('msg_success', 'Caja reingresada');
		}
		return redirect()->to(base_url('cajas'));
	}

	public function arqueo($idCaja)
	{
		$arqueos = $this->arqueoModel->getDatos($idCaja);
		$data = ['titulo' => 'Cierres de caja', 'datos' => $arqueos];

		return view('header')
			. view('cajas/arqueo', $data)
			. view('footer');
	}

	public function nuevo_arqueo()
	{
		$session = session();
		$existe = 0;
		$existe = $this->arqueoModel->where(['id_caja' => $session->id_caja, 'estatus' => 1])->countAllResults();

		if ($existe > 0) {
			session()->setFlashdata('msg_error', 'Ya existe un arqueo abierto para esta caja');
			return redirect()->to(base_url('cajas'));
		}

		if (strtolower($this->request->getMethod()) == "post") {
			$fecha = date('Y-m-d H:i:s');

			$this->arqueoModel->save([
				'id_caja' => $session->id_caja,
				'id_usuario' => $session->id_usuario,
				'fecha_apertura' => $fecha,
				'monto_inicial' => $this->request->getPost('monto_inicial'),
				'estatus' => 1
			]);

			session()->setFlashdata('msg_success', 'Caja abierta');
			return redirect()->to(base_url('cajas'));
		} else {
			$caja = $this->cajas->where('id', $session->id_caja)->first();
			$data = ['titulo' => 'Apertura de caja', 'caja' => $caja, 'session' => $session];
			return view('header')
				. view('cajas/nuevo_arqueo', $data)
				. view('footer');
		}
	}

	public function cerrar()
	{
		$session = session();

		if (strtolower($this->request->getMethod()) == "post") {
			$fecha = date('Y-m-d H:i:s');

			$this->arqueoModel->update($this->request->getPost('id_arqueo'), [
				'fecha_fin' => $fecha,
				'monto_final' => $this->request->getPost('monto_final'),
				'total_ventas' => $this->request->getPost('total_ventas'),
				'estatus' => 0
			]);

			session()->setFlashdata('msg_success', 'Caja cerrada correctamente');
			return redirect()->to(base_url('cajas'));
		} else {
			// Obtener total de ventas del día para esta caja
			$fecha = date('Y-m-d');
			$totalVentas = $this->ventasModel->where('id_caja', $session->id_caja)
				->where('activo', 1)
				->where("DATE(fecha_alta) =", $fecha)
				->selectSum('total')
				->get()
				->getRow();
			$montoTotal = $totalVentas ? $totalVentas->total : 0;

			// Contar número de ventas del día
			$numVentas = $this->ventasModel->where('id_caja', $session->id_caja)
				->where('activo', 1)
				->where("DATE(fecha_alta) =", $fecha)
				->countAllResults();

			$arqueo = $this->arqueoModel->where(['id_caja' => $session->id_caja, 'estatus' => 1])->first();
			$caja = $this->cajas->where('id', $session->id_caja)->first();
			$data = ['titulo' => 'Cierre de caja', 'caja' => $caja, 'session' => $session, 'arqueo' => $arqueo, 'monto' => $montoTotal, 'numVentas' => $numVentas];
			return view('header')
				. view('cajas/cerrar', $data)
				. view('footer');
		}
	}
}

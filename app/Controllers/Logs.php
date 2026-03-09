<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LogsModel;
use Config\Validation;

class Logs extends BaseController
{
	protected $logs;
	protected $reglas;

	public function __construct()
	{
		$this->logs = new LogsModel();
		helper(['form']);
		$this->reglas = [
			'nombre' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.'
				]
			],
		];
	}

	public function index($activo = 1)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('logs_ver')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Logs');
			return redirect()->to(base_url('dashboard'));
		}
		$logs = $this->logs->where('activo', $activo)->findAll();
		$data = ['titulo' => 'Logs', 'datos' => $logs];
		return view('header')
			. view('logs/index', $data)
			. view('footer');
	}

	public function insertar()
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('logs_ver')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Logs');
			return redirect()->to(base_url('dashboard'));
		}
		$nombre = $this->request->getPost('nombre');

		if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
			$this->logs->save([
				'nombre' => $nombre
			]);
			session()->setFlashdata('msg_success', 'Log ' . $nombre . ' Guardada');
			return redirect()->to(base_url('logs'));
		} else {
			$data = ['titulo' => 'Agregar log', 'validation' => $this->validator];

			return view('header')
				. view('logs/nuevo', $data)
				. view('footer');
		}
	}
}

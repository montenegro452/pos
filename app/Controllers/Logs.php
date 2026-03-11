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
	}

	public function index($activo = 1)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('logs_ver')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Logs');
			return redirect()->to(base_url('dashboard'));
		}
		$logs = $this->logs->orderBy('fecha', 'DESC')->findAll();
		$data = ['titulo' => 'Logs', 'datos' => $logs];
		return view('header')
			. view('logs/index', $data)
			. view('footer');
	}
}

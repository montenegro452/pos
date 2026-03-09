<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ConfiguracionModel;

class configuracion extends BaseController
{
	protected $configuracion;
	protected $reglas;

	public function __construct()
	{
		$this->configuracion = new ConfiguracionModel();
		helper(['form']);
		$this->reglas = [
			'tienda_nombre' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.'
				]
			],
			'tienda_email' => [
				'rules' => 'required|valid_email',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.',
					'valid_emal' => 'Debe poner un email válido'
				]
			],
			'tienda_telefono' => [
				'rules' => 'required|numeric',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.',
					'numeric' => 'El campo {field} debe ser un numero telefonico'
				]
			],
			'tienda_direccion' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.'
				]
			],
		];
	}

	public function index()
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('configuracion_ver')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Configuracion');
			return redirect()->to(base_url('dashboard'));
		}
		$nombre = $this->configuracion->where('nombre', 'tienda_nombre')->first();
		$email = $this->configuracion->where('nombre', 'tienda_email')->first();
		$telefono = $this->configuracion->where('nombre', 'tienda_telefono')->first();
		$direccion = $this->configuracion->where('nombre', 'tienda_direccion')->first();
		$leyenda = $this->configuracion->where('nombre', 'tienda_leyenda')->first();

		$data = [
			'titulo' => 'Configuracion',
			'nombre' => $nombre,
			'email' => $email,
			'telefono' => $telefono,
			'direccion' => $direccion,
			'leyenda' => $leyenda
		];
		return view('header')
			. view('configuracion/index', $data)
			. view('footer');
	}

	public function actualizar()
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('configuracion_editar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Configuracion');
			return redirect()->to(base_url('dashboard'));
		}
		if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
			$this->configuracion->whereIn('nombre', ['tienda_nombre'])->set([
				'valor' => $this->request->getPost('tienda_nombre')
			])->update();
			$this->configuracion->whereIn('nombre', ['tienda_email'])->set([
				'valor' => $this->request->getPost('tienda_email')
			])->update();
			$this->configuracion->whereIn('nombre', ['tienda_telefono'])->set([
				'valor' => $this->request->getPost('tienda_telefono')
			])->update();
			$this->configuracion->whereIn('nombre', ['tienda_direccion'])->set([
				'valor' => $this->request->getPost('tienda_direccion')
			])->update();
			$this->configuracion->whereIn('nombre', ['tienda_leyenda'])->set([
				'valor' => $this->request->getPost('tienda_leyenda')
			])->update();

			$validacion = $this->validate([
				'tienda_logo' => [
					'rules' => 'uploaded[tienda_logo]|mime_in[tienda_logo,image/png]|max_size[tienda_logo,4096]',
					'errors' => [
						'uploaded' => 'Debes subir un logotipo para la tienda.',
						'mime_in' => 'El logotipo debe ser una imagen en formato PNG.',
						'max_size' => 'El logotipo no debe exceder los 4MB de tamaño.'
					]
				]
			]);

			if ($validacion) {

				$ruta_logo = "images/logo.png";
				if (file_exists($ruta_logo)) {
					unlink($ruta_logo);
				}
				$img = $this->request->getFile('tienda_logo');
				$img->move('./images/', 'logo.png');
			}
			session()->setFlashdata('msg_success', 'Configuración Guardada');
			return redirect()->to(base_url('configuracion'));
		} else {
			$data = ['titulo' => 'Configuracion', 'validation' => $this->validator];
			return redirect()->to(base_url('configuracion'));
		}
	}
}

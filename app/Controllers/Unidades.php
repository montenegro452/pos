<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UnidadesModel;
use Config\Validation;

class Unidades extends BaseController
{
	protected $unidades;
	protected $reglas;

	public function __construct()
	{
		$this->unidades = new UnidadesModel();
		helper(['form']);
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
		if (!tienePermiso('unidades_ver')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Unidades');
			return redirect()->to(base_url('dashboard'));
		}
		$unidades = $this->unidades->where('activo', $activo)->findAll();
		$data = ['titulo' => 'Unidades', 'datos' => $unidades];
		$data_header = ['title' => 'Sistema de Ventas - Unidades'];
		return view('header', $data_header)
			. view('unidades/index', $data)
			. view('footer');
	}

	public function nuevo()
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('unidades_agregar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Unidades');
			return redirect()->to(base_url('dashboard'));
		}
		$data_header = ['title' => 'Sistema de Ventas - Agregar unidad'];
		$data = ['titulo' => 'Agregar unidad'];
		return view('header', $data_header)
			. view('unidades/nuevo', $data)
			. view('footer');
	}

	public function insertar()
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('unidades_agregar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Unidades');
			return redirect()->to(base_url('dashboard'));
		}
		$nombre = $this->request->getPost('nombre');
		$nombre_corto = $this->request->getPost('nombre_corto');

		if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
			$this->unidades->save([
				'nombre' => $nombre,
				'nombre_corto' => $nombre_corto
			]);
			session()->setFlashdata('msg_success', 'Unidad ' . $nombre . ' Guardada');
			return redirect()->to(base_url('unidades'));
		} else {
			$data = ['titulo' => 'Agregar unidad', 'validation' => $this->validator];

			return view('header')
				. view('unidades/nuevo', $data)
				. view('footer');
		}
	}

	public function editar($id, $valid = null)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('unidades_editar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Unidades');
			return redirect()->to(base_url('dashboard'));
		}
		$unidad = $this->unidades->where('id', $id)->first();
		if ($valid != null) {
			$data = ['titulo' => 'Editar unidad', 'datos' => $unidad, 'validation' => $valid];
		} else {
			$data = ['titulo' => 'Editar unidad', 'datos' => $unidad];
		}

		$data_header = ['title' => 'Sistema de Ventas - Editar unidad'];

		return view('header')
			. view('unidades/editar', $data)
			. view('footer');
	}

	public function actualizar()
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('unidades_editar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Unidades');
			return redirect()->to(base_url('dashboard'));
		}
		if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
			$this->unidades->update($this->request->getPost('id'), [
				'nombre' => $this->request->getPost('nombre'),
				'nombre_corto' => $this->request->getPost('nombre_corto')
			]);
			session()->setFlashdata('msg_success', 'Unidad Guardada');
			return redirect()->to(base_url('unidades'));
		} else {
			return $this->editar($this->request->getPost('id'), $this->validator);
		}
	}

	public function eliminar($id)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('unidades_eliminar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Unidades');
			return redirect()->to(base_url('dashboard'));
		}
		$this->unidades->update($id, ['activo' => 0]);
		session()->setFlashdata('msg_success', 'Unidad Eliminada');
		return redirect()->to(base_url('unidades'));
	}

	public function eliminados($activo = 0)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('unidades_editar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Unidades');
			return redirect()->to(base_url('dashboard'));
		}
		$unidades = $this->unidades->where('activo', $activo)->findAll();
		$data_header = ['title' => 'Sistema de Ventas - Unidades Eliminadas'];
		$data = ['titulo' => 'Unidades Eliminadas', 'datos' => $unidades];
		return view('header', $data_header)
			. view('unidades/eliminados', $data)
			. view('footer');
	}

	public function reingresar($id = null)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('unidades_editar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Unidades');
			return redirect()->to(base_url('dashboard'));
		}
		if ($id === null) {
			$id = $this->request->getPost('id');
		}
		if ($id) {
			$this->unidades->update($id, ['activo' => 1]);
			// Mensaje para el usuario
			session()->setFlashdata('msg_success', 'Unidad reingresada');
		}
		return redirect()->to(base_url('unidades'));
	}
}

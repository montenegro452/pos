<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoriasModel;

class categorias extends BaseController
{
	protected $categorias;
	protected $reglas;

	public function __construct()
	{
		$this->categorias = new CategoriasModel();
	}

	public function index($activo = 1)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('categorias_ver')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Categorias');
			return redirect()->to(base_url('dashboard'));
		}
		$categorias = $this->categorias->where('activo', $activo)->findAll();
		$data = ['titulo' => 'categorias', 'datos' => $categorias];
		return view('header')
			. view('categorias/index', $data)
			. view('footer');
	}

	public function nuevo()
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('categorias_agregar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Categorias');
			return redirect()->to(base_url('dashboard'));
		}
		$data = ['titulo' => 'Agregar categoria'];
		return view('header')
			. view('categorias/nuevo', $data)
			. view('footer');
	}

	public function insertar()
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('categorias_agregar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Categorias');
			return redirect()->to(base_url('dashboard'));
		}
		$nombre = $this->request->getPost('nombre');

		$this->categorias->save([
			'nombre' => $nombre
		]);
		session()->setFlashdata('msg_success', 'Categoria Creada');
		return redirect()->to(base_url('categorias'));
	}

	public function editar($id)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('categorias_editar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Categorias');
			return redirect()->to(base_url('dashboard'));
		}
		$categoria = $this->categorias->where('id', $id)->first();
		$data = ['titulo' => 'Editar categoria', 'datos' => $categoria];
		return view('header')
			. view('categorias/editar', $data)
			. view('footer');
	}

	public function actualizar()
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('categorias_editar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Categorias');
			return redirect()->to(base_url('dashboard'));
		}
		$this->categorias->update($this->request->getPost('id'), ['nombre' => $this->request->getPost('nombre')]);
		// Set a flash message to show a toast on the next page load
		session()->setFlashdata('msg_success', 'Categoria Guardada');
		return redirect()->to(base_url('categorias'));
	}

	public function eliminar($id)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('categorias_eliminar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Categorias');
			return redirect()->to(base_url('dashboard'));
		}
		$this->categorias->update($id, ['activo' => 0]);
		session()->setFlashdata('msg_success', 'Categoria Eliminada');
		return redirect()->to(base_url('categorias'));
	}

	public function eliminados($activo = 0)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('categorias_ver')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Categorias');
			return redirect()->to(base_url('dashboard'));
		}
		$categorias = $this->categorias->where('activo', $activo)->findAll();
		$data = ['titulo' => 'Categorias Eliminadas', 'datos' => $categorias];
		return view('header')
			. view('categorias/eliminados', $data)
			. view('footer');
	}

	public function reingresar($id = null)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('categorias_editar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Categorias');
			return redirect()->to(base_url('dashboard'));
		}
		if ($id === null) {
			$id = $this->request->getPost('id');
		}
		if ($id) {
			$this->categorias->update($id, ['activo' => 1]);
			// Mensaje para el usuario
			session()->setFlashdata('msg_acceso', 'Categoria reingresada');
		}
		return redirect()->to(base_url('categorias'));
	}
}

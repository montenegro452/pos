<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClientesModel;

class Clientes extends BaseController
{
	protected $clientes;
	protected $reglas;


	public function __construct()
	{
		$this->clientes = new ClientesModel();

		helper(['form']);
		$this->reglas = [
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
		if (!tienePermiso('clientes_ver')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Categorias');
			return redirect()->to(base_url('dashboard'));
		}
		$clientes = $this->clientes->where('activo', $activo)->findAll();
		$data = ['titulo' => 'Clientes', 'datos' => $clientes];
		echo view('header');
		echo view('clientes/index', $data);
		echo view('footer');
	}

	public function eliminados($activo = 0)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('clientes_ver')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Categorias');
			return redirect()->to(base_url('dashboard'));
		}

		$clientes = $this->clientes->where('activo', $activo)->findAll();
		$data = ['titulo' => 'Clientes eliminados', 'datos' => $clientes];
		echo view('header');
		echo view('clientes/eliminados', $data);
		echo view('footer');
	}

	public function nuevo()
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('clientes_agregar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Categorias');
			return redirect()->to(base_url('dashboard'));
		}
		$data = ['titulo' => 'Agregar cliente'];

		echo view('header');
		echo view('clientes/nuevo', $data);
		echo view('footer');
	}

	public function insertar()
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('clientes_agregar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Categorias');
			return redirect()->to(base_url('dashboard'));
		}
		$activo = $this->request->getPost('activo');
		$nombre = $this->request->getPost('nombre');
		$direccion = $this->request->getPost('direccion');
		$telefono = $this->request->getPost('telefono');
		$correo = $this->request->getPost('correo');

		if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
			$this->clientes->save([
				'activo' => $activo,
				'nombre' => $nombre,
				'direccion' => $direccion,
				'telefono' => $telefono,
				'correo' => $correo
			]);
			session()->setFlashdata('msg_success', 'Cliente ' . $nombre . ' Guardado');
			return redirect()->to(base_url('clientes'));
		} else {
			$data = ['titulo' => 'Agregar cliente', 'validation' => $this->validator];
			return view('header')
				. view('clientes/nuevo', $data)
				. view('footer');
		}
	}


	public function editar($id)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('clientes_editar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Categorias');
			return redirect()->to(base_url('dashboard'));
		}
		$cliente = $this->clientes->where('id', $id)->first();
		$data = ['titulo' => 'Editar cliente', 'cliente' => $cliente];

		echo view('header');
		echo view('clientes/editar', $data);
		echo view('footer');
	}

	public function actualizar()
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('clientes_editar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Categorias');
			return redirect()->to(base_url('dashboard'));
		}
		$this->clientes->update($this->request->getPost('id'), [
			'codigo' => $this->request->getPost('codigo'),
			'nombre' => $this->request->getPost('nombre'),
			'direccion' => $this->request->getPost('direccion'),
			'telefono' => $this->request->getPost('telefono'),
			'correo' => $this->request->getPost('correo')
		]);
		session()->setFlashdata('msg_success', 'Cliente Guardado');
		return redirect()->to(base_url('clientes'));
	}

	public function eliminar($id)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('clientes_eliminar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Categorias');
			return redirect()->to(base_url('dashboard'));
		}
		$this->clientes->update($id, ['activo' => 0]);
		session()->setFlashdata('msg_success', 'Cliente Eliminado');
		return redirect()->to(base_url('clientes'));
	}

	public function reingresar($id)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('clientes_editar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Categorias');
			return redirect()->to(base_url('dashboard'));
		}
		$this->clientes->update($id, ['activo' => 1]);
		session()->setFlashdata('msg_success', 'Cliente Reingresado');
		return redirect()->to(base_url('clientes'));
	}
	public function buscarPorCodigo($codigo)
	{
		$this->clientes->select('*');
		$this->clientes->where('codigo', $codigo);
		$this->clientes->where('activo', 1);
		$datos = $this->clientes->get()->getRow();

		$existe['existe'] = false;
		$res['datos'] = '';
		$error['error'] = '';

		if ($datos) {
			$res['datos'] = $datos;
			$res['existe'] = true;
		} else {
			$res['error'] = "No existe el cliente";
			$res['existe'] = false;
		}
		echo json_encode($res);
	}

	public function autocompleteData()
	{
		$returnData = array();
		$valor = $this->request->getGet('term');
		$clientes = $this->clientes->like('nombre', $valor)->where('activo', 1)->findAll();
		if (!empty($clientes)) {
			foreach ($clientes as $row) {
				$data['id'] = $row['id'];
				$data['value'] = $row['nombre'];
				array_push($returnData, $data);
			}
		}
		echo json_encode($returnData);
	}
}

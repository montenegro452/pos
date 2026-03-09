<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RolesModel;
use App\Models\PermisosModel;
use App\Models\RolesPermisosModel;

class Roles extends BaseController
{
	protected $roles, $permisos, $rolesPermisos;

	public function __construct()
	{
		$this->roles = new RolesModel();
		$this->permisos = new PermisosModel();
		$this->rolesPermisos = new RolesPermisosModel();
		helper(['form']);
	}

	public function index($activo = 1)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('roles_ver')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Roles');
			return redirect()->to(base_url('dashboard'));
		}
		$roles = $this->roles->where('activo', $activo)->findAll();
		$data = ['titulo' => 'Roles y Permisos', 'datos' => $roles];
		$data_header = ['title' => 'Sistema de Ventas - Roles'];

		return view('header', $data_header)
			. view('roles/index', $data)
			. view('footer');
	}

	public function nuevo()
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('roles_agregar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Roles');
			return redirect()->to(base_url('dashboard'));
		}
		$permisos = $this->permisos->where('activo', 1)->findAll();
		$data = ['titulo' => 'Agregar rol', 'permisos' => $permisos];
		$data_header = ['title' => 'Sistema de Ventas - Nuevo Rol'];

		return view('header', $data_header)
			. view('roles/nuevo', $data)
			. view('footer');
	}

	public function insertar()
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('roles_agregar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Roles');
			return redirect()->to(base_url('dashboard'));
		}
		$permisos = $this->permisos->where('activo', 1)->findAll();

		if ($this->request->getMethod() == "POST") {
			$nombre = $this->request->getPost('nombre');
			$permisos_seleccionados = $this->request->getPost('permisos') ?? [];

			// Validar que no existe el rol
			$rolExistente = $this->roles->where('nombre', $nombre)->first();
			if ($rolExistente) {
				session()->setFlashdata('msg_error', 'El rol ya existe');
				return redirect()->to(base_url('roles/nuevo'));
			}

			// Insertar rol
			$id_rol = $this->roles->insert([
				'nombre' => $nombre,
				'activo' => 1,
				'fecha_alta' => date('Y-m-d H:i:s')
			]);

			// Guardar permisos
			if (!empty($permisos_seleccionados)) {
				$this->rolesPermisos->guardarPermisosRol($id_rol, $permisos_seleccionados);
			}

			session()->setFlashdata('msg_success', 'Rol guardado correctamente');
			return redirect()->to(base_url('roles'));
		}

		$data = ['titulo' => 'Agregar rol', 'permisos' => $permisos, 'validation' => $this->validator];
		$data_header = ['title' => 'Sistema de Ventas - Nuevo Rol'];

		return view('header', $data_header)
			. view('roles/nuevo', $data)
			. view('footer');
	}

	public function editar($id, $valid = null)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('roles_editar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Roles');
			return redirect()->to(base_url('dashboard'));
		}
		$rol = $this->roles->where('id', $id)->first();
		$permisos = $this->permisos->where('activo', 1)->findAll();
		$permisosRol = $this->rolesPermisos->getPermisosRol($id);

		// Obtener solo los IDs de permisos del rol
		$permisos_asignados = array_column($permisosRol, 'id_permiso');

		if ($valid != null) {
			$data = ['titulo' => 'Editar rol', 'datos' => $rol, 'permisos' => $permisos, 'permisos_asignados' => $permisos_asignados, 'validation' => $valid];
		} else {
			$data = ['titulo' => 'Editar rol', 'datos' => $rol, 'permisos' => $permisos, 'permisos_asignados' => $permisos_asignados];
		}

		$data_header = ['title' => 'Sistema de Ventas - Editar Rol'];

		return view('header', $data_header)
			. view('roles/editar', $data)
			. view('footer');
	}

	public function actualizar()
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('roles_editar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Roles');
			return redirect()->to(base_url('dashboard'));
		}
		if ($this->request->getMethod() == "POST") {
			$id = $this->request->getPost('id');
			$nombre = $this->request->getPost('nombre');
			$permisos_seleccionados = $this->request->getPost('permisos') ?? [];

			// Actualizar rol
			$this->roles->update($id, [
				'nombre' => $nombre,
				'fecha_edit' => date('Y-m-d H:i:s')
			]);

			// Actualizar permisos
			$this->rolesPermisos->guardarPermisosRol($id, $permisos_seleccionados);

			session()->setFlashdata('msg_success', 'Rol actualizado correctamente');
			return redirect()->to(base_url('roles'));
		}

		return redirect()->to(base_url('roles'));
	}

	public function eliminar($id)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('roles_eliminar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Roles');
			return redirect()->to(base_url('dashboard'));
		}
		$this->roles->update($id, ['activo' => 0]);
		session()->setFlashdata('msg_success', 'Rol eliminado');
		return redirect()->to(base_url('roles'));
	}

	public function reingresar($id)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('roles_editar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Roles');
			return redirect()->to(base_url('dashboard'));
		}
		$this->roles->update($id, ['activo' => 1]);
		session()->setFlashdata('msg_success', 'Rol reingresado');
		return redirect()->to(base_url('roles/eliminados'));
	}

	public function eliminados()
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('roles_ver')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Roles');
			return redirect()->to(base_url('dashboard'));
		}
		$roles = $this->roles->where('activo', 0)->findAll();
		$data = ['titulo' => 'Roles Eliminados', 'datos' => $roles];
		$data_header = ['title' => 'Sistema de Ventas - Roles Eliminados'];

		return view('header', $data_header)
			. view('roles/eliminados', $data)
			. view('footer');
	}
}

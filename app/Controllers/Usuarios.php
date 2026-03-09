<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuariosModel;
use App\Models\CajasModel;
use App\Models\RolesModel;
use App\Models\LogsModel;
use App\Models\PermisosModel;
use App\Models\RolesPermisosModel;
use Config\Validation;

class Usuarios extends BaseController
{
	protected $usuarios, $cajas, $roles, $logs, $permisos, $rolesPermisos;
	protected $reglas, $reglasActualizar, $reglasLogin;

	public function __construct()
	{
		$this->usuarios = new UsuariosModel();
		$this->cajas = new CajasModel();
		$this->roles = new RolesModel();
		$this->logs = new LogsModel();
		$this->permisos = new PermisosModel();
		$this->rolesPermisos = new RolesPermisosModel();
		helper(['form']);
		$this->reglas = [
			'usuario' => [
				'rules' => 'required|is_unique[usuarios.usuario]',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.',
					'is_unique' => 'El campo {field} debe ser unico'
				]
			],

			'password' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.'
				]
			],

			'repassword' => [
				'rules' => 'required|matches[password]',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.',
					'matches' => 'Las contraseñas no coinciden'
				]
			],

			'nombre' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.'
				]
			],

			'id_caja' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.'
				]
			],

			'id_rol' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.'
				]
			]
		];

		$this->reglasActualizar = [
			'usuario' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.'
				]
			],

			'password' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.'
				]
			],

			'repassword' => [
				'rules' => 'required|matches[password]',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.',
					'matches' => 'Las contraseñas no coinciden'
				]
			],

			'nombre' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.'
				]
			],

			'id_caja' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.'
				]
			],

			'id_rol' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.'
				]
			]
		];

		$this->reglasLogin = [
			'usuario' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.'
				]
			],

			'password' => [
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
		if (!tienePermiso('usuarios_ver')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Usuarios');
			return redirect()->to(base_url('dashboard'));
		}
		$usuarios = $this->usuarios->where('activo', $activo)->findAll();
		$roles = $this->usuarios->where('activo', $activo)->findAll();
		$data = ['titulo' => 'Usuarios', 'datos' => $usuarios, 'roles' => $roles];
		$data_header = ['title' => 'Sistema de Ventas - Usuarios'];
		return view('header', $data_header)
			. view('usuarios/index', $data)
			. view('footer');
	}

	public function nuevo()
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('usuarios_agregar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Usuarios');
			return redirect()->to(base_url('dashboard'));
		}
		$cajas = $this->cajas->where('activo', 1)->findAll();
		$roles = $this->roles->where('activo', 1)->findAll();
		$permisos = $this->permisos->where('activo', 1)->findAll();

		$data = ['titulo' => 'Agregar usuario', 'cajas' => $cajas, 'roles' => $roles, 'permisos' => $permisos];
		$data_header = ['title' => 'Sistema de Ventas - Nuevo Usuario'];
		return view('header', $data_header)
			. view('usuarios/nuevo', $data)
			. view('footer');
	}

	public function insertar()
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('usuarios_agregar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Usuarios');
			return redirect()->to(base_url('dashboard'));
		}
		$cajas = $this->cajas->where('activo', 1)->findAll();
		$roles = $this->roles->where('activo', 1)->findAll();
		$permisos = $this->permisos->where('activo', 1)->findAll();
		$usuario = $this->request->getPost('usuario');
		$nombre = $this->request->getPost('nombre');
		$id_caja = $this->request->getPost('id_caja');
		$id_rol = $this->request->getPost('id_rol');
		$password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

		if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {

			$usuarioGuardado = $this->usuarios->save([
				'usuario' => $usuario,
				'nombre' => $nombre,
				'id_caja' => $id_caja,
				'id_rol' => $id_rol,
				'password' => $password
			]);

			// Guardar permisos del rol
			$permisosSeleccionados = $this->request->getPost('permisos');
			if ($permisosSeleccionados) {
				$this->rolesPermisos->guardarPermisosRol($id_rol, $permisosSeleccionados);
			}

			session()->setFlashdata('msg_success', 'Usuario ' . $nombre . ' Guardado');
			return redirect()->to(base_url('usuarios'));
		} else {
			$data = ['titulo' => 'Agregar usuario', 'cajas' => $cajas, 'roles' => $roles, 'permisos' => $permisos, 'validation' => $this->validator];

			return view('header')
				. view('usuarios/nuevo', $data)
				. view('footer');
		}
	}

	public function editar($id, $validator = null)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('usuarios_editar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Usuarios');
			return redirect()->to(base_url('dashboard'));
		}
		$cajas = $this->cajas->where('activo', 1)->findAll();
		$roles = $this->roles->where('activo', 1)->findAll();
		$unidad = $this->usuarios->where('id', $id)->first();

		// Obtener todos los permisos activos
		$todosPermisos = $this->permisos->where('activo', 1)->findAll();

		// Obtener permisos del rol del usuario
		$permisosRol = $this->permisos->getPermisosPorRol($unidad['id_rol']);
		$permisosRolIds = array_column($permisosRol, 'id');

		if ($validator != null) {
			$data = [
				'titulo' => 'Editar usuario',
				'datos' => $unidad,
				'validation' => $validator,
				'cajas' => $cajas,
				'roles' => $roles,
				'permisos' => $todosPermisos,
				'permisosRol' => $permisosRolIds
			];
		} else {
			$data = [
				'titulo' => 'Editar usuario',
				'datos' => $unidad,
				'cajas' => $cajas,
				'roles' => $roles,
				'permisos' => $todosPermisos,
				'permisosRol' => $permisosRolIds
			];
		}

		$data_header = ['title' => 'Sistema de Ventas - Editar Usuario'];
		return view('header', $data_header)
			. view('usuarios/editar', $data)
			. view('footer');
	}

	public function actualizar()
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('usuarios_editar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Usuarios');
			return redirect()->to(base_url('dashboard'));
		}

		if ($this->request->getMethod() == "POST" && $this->validate($this->reglasActualizar)) {
			$password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
			$id_rol = $this->request->getPost('id_rol');
			$permisos = $this->request->getPost('permisos');

			// Actualizar datos del usuario
			$this->usuarios->update($this->request->getPost('id'), [
				'usuario' => $this->request->getPost('usuario'),
				'nombre' => $this->request->getPost('nombre'),
				'password' => $password,
				'id_caja' => $this->request->getPost('id_caja'),
				'id_rol' => $id_rol
			]);

			// Guardar permisos del rol
			if ($permisos) {
				$this->rolesPermisos->guardarPermisosRol($id_rol, $permisos);
			} else {
				// Si no hay permisos seleccionados, eliminar todos
				$this->rolesPermisos->where('id_rol', $id_rol)->delete();
			}

			session()->setFlashdata('msg_success', 'Usuario Guardado');
			return redirect()->to(base_url('usuarios'));
		} else {
			return $this->editar($this->request->getPost('id'), $this->validator);
		}
	}

	public function eliminar($id)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('usuarios_eliminar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Usuarios');
			return redirect()->to(base_url('dashboard'));
		}
		$this->usuarios->update($id, ['activo' => 0]);
		session()->setFlashdata('msg_success', 'Usuario Eliminada');
		return redirect()->to(base_url('usuarios'));
	}

	public function eliminados($activo = 0)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('usuarios_ver')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Usuarios');
			return redirect()->to(base_url('dashboard'));
		}
		$usuarios = $this->usuarios->where('activo', $activo)->findAll();
		$data = ['titulo' => 'Usuarios Eliminadas', 'datos' => $usuarios];
		$data_header = ['title' => 'Sistema de Ventas - Usuarios Eliminados'];

		return view('header', $data_header)
			. view('usuarios/eliminados', $data)
			. view('footer');
	}

	public function reingresar($id = null)
	{
		// Verificar permiso
		helper('permisos');
		if (!tienePermiso('usuarios_editar')) {
			session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Usuarios');
			return redirect()->to(base_url('dashboard'));
		}
		if ($id === null) {
			$id = $this->request->getPost('id');
		}
		if ($id) {
			$this->usuarios->update($id, ['activo' => 1]);
			// Mensaje para el usuario
			session()->setFlashdata('msg_success', 'Usuario reingresado');
		}
		return redirect()->to(base_url('usuarios'));
	}

	public function valida()
	{
		if ($this->request->getMethod() == "POST" && $this->validate($this->reglasLogin)) {
			$usuario = $this->request->getPost('usuario');
			$password = $this->request->getPost('password');
			$datosUsuario = $this->usuarios->where('usuario', $usuario)->first();

			if ($datosUsuario != null) {
				if (password_verify($password, $datosUsuario['password'])) {
					// Obtener información del rol
					$datosRol = $this->roles->where('id', $datosUsuario['id_rol'])->first();

					$datosSesion = [
						'id_usuario' => $datosUsuario['id'],
						'usuario' => $datosUsuario['usuario'],
						'nombre' => $datosUsuario['nombre'],
						'id_caja' => $datosUsuario['id_caja'],
						'id_rol' => $datosUsuario['id_rol'],
						'nombre_rol' => $datosRol['nombre'] ?? '',
						'isLoggedIn' => true,
						'isLocked' => false
					];

					$ip = $_SERVER['REMOTE_ADDR'];
					$detalles = $_SERVER['HTTP_USER_AGENT'];
					$this->logs->save([
						'id_usuario' => $datosUsuario['id'],
						'evento' => 'Inicio de sesión',
						'ip' => $ip,
						'detalles' => 'Usuario inició sesión desde: ' . $detalles
					]);

					$session = session();
					$session->set($datosSesion);
					return redirect()->to(base_url('dashboard'));
				} else {
					session()->setFlashdata('msg_error', 'El usuario o la contraseña no es correcta.');
					echo view('login');
				}
			} else {
				session()->setFlashdata('msg_error', 'El usuario o la contraseña no es correcta.');
				echo view('login');
			}
		} else {
			$data = ['validation' => $this->validator];
			echo view('login', $data);
		}
	}

	public function logout()
	{
		$session = session();

		$ip = $_SERVER['REMOTE_ADDR'];
		$detalles = $_SERVER['HTTP_USER_AGENT'];
		$this->logs->save([
			'id_usuario' => $session->id_usuario,
			'evento' => 'Cierre de sesión',
			'ip' => $ip,
			'detalles' => 'Usuario finalizo la sesión desde: ' . $detalles
		]);
		$session->destroy();
		return redirect()->to(base_url());
	}

	public function lockscreen()
	{
		// Verifica si el usuario está logueado
		if (!session()->get('isLoggedIn')) {
			return redirect()->to(base_url());
		}
		// Marca la sesión como bloqueada
		session()->set('isLocked', true);
		$data = ['nombre' => session()->get('nombre')];
		return view('lockscreen', $data);
	}

	public function unlock()
	{
		if ($this->request->getMethod() == "POST") {
			$password = $this->request->getPost('password');
			$usuario = session()->get('usuario');

			// Obtén los datos del usuario actual
			$datosUsuario = $this->usuarios->where('usuario', $usuario)->first();

			if ($datosUsuario && password_verify($password, $datosUsuario['password'])) {
				// Desbloquea la sesión
				session()->remove('isLocked');
				return redirect()->to(base_url('dashboard'));
			} else {
				session()->setFlashdata('msg_error', 'La contraseña no es correcta.');
				return redirect()->to(base_url('usuarios/lockscreen'));
			}
		}
		return redirect()->to(base_url('usuarios/lockscreen'));
	}

	public function obtenerPermisosRol()
	{
		if (!$this->request->isAJAX()) {
			return $this->response->setStatusCode(403);
		}

		$id_rol = $this->request->getJSON()->id_rol ?? null;

		if (!$id_rol) {
			return $this->response->setJSON(['permisos' => []]);
		}

		// Obtener permisos del rol
		$permisosRol = $this->permisos->getPermisosPorRol($id_rol);
		$permisosIds = array_column($permisosRol, 'id');

		return $this->response->setJSON(['permisos' => $permisosIds]);
	}
}

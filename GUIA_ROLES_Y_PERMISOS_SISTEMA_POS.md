# SISTEMA COMPLETO DE ROLES Y PERMISOS

## Para tu Sistema POS - CodeIgniter 4

================================================================================

1. # ESTRUCTURA DE LA BASE DE DATOS (MIGRACIONES)

### 1.1 Crear tabla de permisos

Crea el archivo: app/Database/Migrations/2024-01-01-000014_CreatePermisosTable.php

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePermisosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nombre' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'descripcion' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'activo' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'fecha_alta' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'fecha_edit' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('permisos');
        
        // Insertar permisos iniciales
        $this->db->table('permisos')->insertBatch([
            ['nombre' => 'usuarios_ver', 'descripcion' => 'Ver usuarios', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'usuarios_agregar', 'descripcion' => 'Agregar usuarios', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'usuarios_editar', 'descripcion' => 'Editar usuarios', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'usuarios_eliminar', 'descripcion' => 'Eliminar usuarios', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'roles_ver', 'descripcion' => 'Ver roles', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'roles_agregar', 'descripcion' => 'Agregar roles', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'roles_editar', 'descripcion' => 'Editar roles', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'roles_eliminar', 'descripcion' => 'Eliminar roles', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'ventas_ver', 'descripcion' => 'Ver ventas', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'ventas_agregar', 'descripcion' => 'Realizar ventas', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'ventas_eliminar', 'descripcion' => 'Eliminar ventas', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'compras_ver', 'descripcion' => 'Ver compras', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'compras_agregar', 'descripcion' => 'Realizar compras', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'compras_eliminar', 'descripcion' => 'Eliminar compras', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'productos_ver', 'descripcion' => 'Ver productos', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'productos_agregar', 'descripcion' => 'Agregar productos', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'productos_editar', 'descripcion' => 'Editar productos', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'productos_eliminar', 'descripcion' => 'Eliminar productos', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'categorias_ver', 'descripcion' => 'Ver categorías', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'categorias_agregar', 'descripcion' => 'Agregar categorías', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'categorias_editar', 'descripcion' => 'Editar categorías', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'categorias_eliminar', 'descripcion' => 'Eliminar categorías', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'clientes_ver', 'descripcion' => 'Ver clientes', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'clientes_agregar', 'descripcion' => 'Agregar clientes', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'clientes_editar', 'descripcion' => 'Editar clientes', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'clientes_eliminar', 'descripcion' => 'Eliminar clientes', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'configuracion_ver', 'descripcion' => 'Ver configuración', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'configuracion_editar', 'descripcion' => 'Editar configuración', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'reportes_ver', 'descripcion' => 'Ver reportes', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'cajas_ver', 'descripcion' => 'Ver cajas', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'cajas_agregar', 'descripcion' => 'Agregar cajas', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'cajas_editar', 'descripcion' => 'Editar cajas', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'cajas_eliminar', 'descripcion' => 'Eliminar cajas', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
            ['nombre' => 'logs_ver', 'descripcion' => 'Ver logs del sistema', 'activo' => 1, 'fecha_alta' => date('Y-m-d H:i:s')],
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('permisos');
    }
}

### 1.2 Crear tabla de relación roles-permisos
Crea el archivo: app/Database/Migrations/2024-01-01-000015_CreateRolesPermisosTable.php

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRolesPermisosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_rol' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_permiso' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'fecha_alta' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_rol', 'roles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_permiso', 'permisos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('roles_permisos');
        
        // Asignar permisos por defecto al rol de Administrador (id_rol = 1)
        $permisosAdministrador = [];
        for ($i = 1; $i <= 34; $i++) {
            $permisosAdministrador[] = [
                'id_rol' => 1,
                'id_permiso' => $i,
                'fecha_alta' => date('Y-m-d H:i:s')
            ];
        }
        $this->db->table('roles_permisos')->insertBatch($permisosAdministrador);
        
        // Asignar permisos básicos al rol de Vendedor (id_rol = 2)
        $permisosVendedor = [
            ['id_rol' => 2, 'id_permiso' => 9, 'fecha_alta' => date('Y-m-d H:i:s')],  // ventas_ver
            ['id_rol' => 2, 'id_permiso' => 10, 'fecha_alta' => date('Y-m-d H:i:s')], // ventas_agregar
            ['id_rol' => 2, 'id_permiso' => 15, 'fecha_alta' => date('Y-m-d H:i:s')], // productos_ver
            ['id_rol' => 2, 'id_permiso' => 23, 'fecha_alta' => date('Y-m-d H:i:s')], // clientes_ver
            ['id_rol' => 2, 'id_permiso' => 24, 'fecha_alta' => date('Y-m-d H:i:s')], // clientes_agregar
        ];
        $this->db->table('roles_permisos')->insertBatch($permisosVendedor);
        
        // Asignar permisos básicos al rol de Almacenista (id_rol = 3)
        $permisosAlmacenista = [
            ['id_rol' => 3, 'id_permiso' => 12, 'fecha_alta' => date('Y-m-d H:i:s')], // compras_ver
            ['id_rol' => 3, 'id_permiso' => 13, 'fecha_alta' => date('Y-m-d H:i:s')], // compras_agregar
            ['id_rol' => 3, 'id_permiso' => 15, 'fecha_alta' => date('Y-m-d H:i:s')], // productos_ver
            ['id_rol' => 3, 'id_permiso' => 16, 'fecha_alta' => date('Y-m-d H:i:s')], // productos_agregar
            ['id_rol' => 3, 'id_permiso' => 17, 'fecha_alta' => date('Y-m-d H:i:s')], // productos_editar
            ['id_rol' => 3, 'id_permiso' => 19, 'fecha_alta' => date('Y-m-d H:i:s')], // categorias_ver
            ['id_rol' => 3, 'id_permiso' => 20, 'fecha_alta' => date('Y-m-d H:i:s')], // categorias_agregar
            ['id_rol' => 3, 'id_permiso' => 21, 'fecha_alta' => date('Y-m-d H:i:s')], // categorias_editar
        ];
        $this->db->table('roles_permisos')->insertBatch($permisosAlmacenista);
    }

    public function down()
    {
        $this->forge->dropTable('roles_permisos');
    }
}

================================================================================
2. MODELOS
================================================================================

### 2.1 Modelo de Permisos (app/Models/PermisosModel.php)

<?php

namespace App\Models;

use CodeIgniter\Model;

class PermisosModel extends Model
{
    protected $table      = 'permisos';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre', 'descripcion', 'activo'];

    protected $useTimestamps = false;
    protected $createdField  = 'fecha_alta';
    protected $updatedField  = 'fecha_edit';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
    // Obtener permisos por rol
    public function getPermisosPorRol($id_rol)
    {
        $builder = $this->db->table('roles_permisos rp');
        $builder->select('p.*');
        $builder->join('permisos p', 'rp.id_permiso = p.id');
        $builder->where('rp.id_rol', $id_rol);
        $builder->where('p.activo', 1);
        return $builder->get()->getResultArray();
    }
    
    // Verificar si un rol tiene un permiso específico
    public function tienePermiso($id_rol, $nombre_permiso)
    {
        $builder = $this->db->table('roles_permisos rp');
        $builder->select('p.*');
        $builder->join('permisos p', 'rp.id_permiso = p.id');
        $builder->where('rp.id_rol', $id_rol);
        $builder->where('p.nombre', $nombre_permiso);
        $builder->where('p.activo', 1);
        $result = $builder->get()->getRow();
        return $result != null;
    }
}

### 2.2 Modelo de Roles-Permisos (app/Models/RolesPermisosModel.php)

<?php

namespace App\Models;

use CodeIgniter\Model;

class RolesPermisosModel extends Model
{
    protected $table      = 'roles_permisos';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_rol', 'id_permiso'];

    protected $useTimestamps = false;
    protected $createdField  = 'fecha_alta';
    protected $updatedField  = 'fecha_edit';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
    // Guardar permisos para un rol
    public function guardarPermisosRol($id_rol, $permisos)
    {
        // Eliminar permisos actuales del rol
        $this->where('id_rol', $id_rol)->delete();
        
        // Insertar nuevos permisos
        $data = [];
        foreach ($permisos as $id_permiso) {
            $data[] = [
                'id_rol' => $id_rol,
                'id_permiso' => $id_permiso,
                'fecha_alta' => date('Y-m-d H:i:s')
            ];
        }
        
        return $this->insertBatch($data);
    }
    
    // Obtener permisos de un rol
    public function getPermisosRol($id_rol)
    {
        return $this->where('id_rol', $id_rol)->findAll();
    }
}

================================================================================
3. BIBLIOTECA DE PERMISOS
================================================================================

### 3.1 Biblioteca de Autorización (app/Libraries/Authorization.php)

<?php

namespace App\Libraries;

use App\Models\PermisosModel;
use App\Models\RolesPermisosModel;

class Authorization
{
    protected $permisosModel;
    protected $rolesPermisosModel;
    
    public function __construct()
    {
        $this->permisosModel = new PermisosModel();
        $this->rolesPermisosModel = new RolesPermisosModel();
    }
    
    /**
     * Verifica si el usuario actual tiene un permiso específico
     * @param string $permiso Nombre del permiso (ej: 'usuarios_agregar')
     * @return bool
     */
    public function hasPermission($permiso)
    {
        $id_rol = session()->get('id_rol');
        
        if (!$id_rol) {
            return false;
        }
        
        return $this->permisosModel->tienePermiso($id_rol, $permiso);
    }
    
    /**
     * Verifica si el usuario tiene alguno de los permisos especificados
     * @param array $permisos Array de nombres de permisos
     * @return bool
     */
    public function hasAnyPermission($permisos)
    {
        foreach ($permisos as $permiso) {
            if ($this->hasPermission($permiso)) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Verifica si el usuario tiene todos los permisos especificados
     * @param array $permisos Array de nombres de permisos
     * @return bool
     */
    public function hasAllPermissions($permisos)
    {
        foreach ($permisos as $permiso) {
            if (!$this->hasPermission($permiso)) {
                return false;
            }
        }
        return true;
    }
    
    /**
     * Obtiene todos los permisos del usuario actual
     * @return array
     */
    public function getUserPermissions()
    {
        $id_rol = session()->get('id_rol');
        
        if (!$id_rol) {
            return [];
        }
        
        return $this->permisosModel->getPermisosPorRol($id_rol);
    }
    
    /**
     * Verifica si el usuario es administrador
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasPermission('configuracion_editar');
    }
    
    /**
     * Verifica si el usuario es vendedor
     * @return bool
     */
    public function isVendedor()
    {
        return $this->hasPermission('ventas_agregar');
    }
    
    /**
     * Verifica si el usuario es almacenista
     * @return bool
     */
    public function isAlmacenista()
    {
        return $this->hasPermission('compras_agregar');
    }
}

================================================================================
4. HELPERS PERSONALIZADOS
================================================================================

### 4.1 Helper de permisos (app/Helpers/permisos_helper.php)

<?php

use App\Libraries\Authorization;

/**
 * Verifica si el usuario actual tiene un permiso específico
 * @param string $permiso Nombre del permiso
 * @return bool
 */
function tienePermiso($permiso)
{
    $auth = new Authorization();
    return $auth->hasPermission($permiso);
}

/**
 * Verifica si el usuario tiene alguno de los permisos
 * @param array $permisos Array de permisos
 * @return bool
 */
function tieneAlgunPermiso($permisos)
{
    $auth = new Authorization();
    return $auth->hasAnyPermission($permisos);
}

/**
 * Verifica si el usuario tiene todos los permisos
 * @param array $permisos Array de permisos
 * @return bool
 */
function tieneTodosPermisos($permisos)
{
    $auth = new Authorization();
    return $auth->hasAllPermissions($permisos);
}

/**
 * Obtiene todos los permisos del usuario actual
 * @return array
 */
function getPermisosUsuario()
{
    $auth = new Authorization();
    return $auth->getUserPermissions();
}

/**
 * Verifica si el usuario es administrador
 * @return bool
 */
function esAdministrador()
{
    $auth = new Authorization();
    return $auth->isAdmin();
}

/**
 * Verifica si el usuario es vendedor
 * @return bool
 */
function esVendedor()
{
    $auth = new Authorization();
    return $auth->isVendedor();
}

/**
 * Verifica si el usuario es almacenista
 * @return bool
 */
function esAlmacenista()
{
    $auth = new Authorization();
    return $auth->isAlmacenista();
}

================================================================================
5. ACTUALIZACIÓN DEL CONTROLADOR DE USUARIOS
================================================================================

### 5.1 Modificar el método valida() en app/Controllers/Usuarios.php

// Reemplaza el método valida() actual con este:

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

================================================================================
6. CONTROLADOR DE ROLES CON PERMISOS
================================================================================

### 6.1 Crear app/Controllers/Roles.php

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
        $roles = $this->roles->where('activo', $activo)->findAll();
        $data = ['titulo' => 'Roles y Permisos', 'datos' => $roles];
        $data_header = ['title' => 'Sistema de Ventas - Roles'];
        
        return view('header', $data_header)
            . view('roles/index', $data)
            . view('footer');
    }
    
    public function nuevo()
    {
        $permisos = $this->permisos->where('activo', 1)->findAll();
        $data = ['titulo' => 'Agregar rol', 'permisos' => $permisos];
        $data_header = ['title' => 'Sistema de Ventas - Nuevo Rol'];
        
        return view('header', $data_header)
            . view('roles/nuevo', $data)
            . view('footer');
    }
    
    public function insertar()
    {
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
        $this->roles->update($id, ['activo' => 0]);
        session()->setFlashdata('msg_success', 'Rol eliminado');
        return redirect()->to(base_url('roles'));
    }
    
    public function reingresar($id)
    {
        $this->roles->update($id, ['activo' => 1]);
        session()->setFlashdata('msg_success', 'Rol reingresado');
        return redirect()->to(base_url('roles/eliminados'));
    }
    
    public function eliminados()
    {
        $roles = $this->roles->where('activo', 0)->findAll();
        $data = ['titulo' => 'Roles Eliminados', 'datos' => $roles];
        $data_header = ['title' => 'Sistema de Ventas - Roles Eliminados'];
        
        return view('header', $data_header)
            . view('roles/eliminados', $data)
            . view('footer');
    }
}

================================================================================
7. ACTUALIZACIÓN DEL HEADER PARA MOSTRAR MENÚ SEGÚN PERMISOS
================================================================================

### 7.1 Modificar app/Views/header.php

Agrega esta verificación en cada sección del menú:

<!-- Ejemplo de menú con permisos -->
<?php 
// Cargar helper de permisos
helper('permisos');
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="<?= base_url('dashboard') ?>">Sistema POS</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <?php if (tienePermiso('ventas_ver')): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('ventas') ?>">Ventas</a>
            </li>
            <?php endif; ?>
            
            <?php if (tienePermiso('compras_ver')): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('compras') ?>">Compras</a>
            </li>
            <?php endif; ?>
            
            <?php if (tienePermiso('productos_ver')): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('productos') ?>">Productos</a>
            </li>
            <?php endif; ?>
            
            <?php if (tienePermiso('categorias_ver')): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('categorias') ?>">Categorías</a>
            </li>
            <?php endif; ?>
            
            <?php if (tienePermiso('clientes_ver')): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('clientes') ?>">Clientes</a>
            </li>
            <?php endif; ?>
            
            <?php if (tienePermiso('usuarios_ver')): ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                    Administración
                </a>
                <div class="dropdown-menu">
                    <?php if (tienePermiso('usuarios_ver')): ?>
                    <a class="dropdown-item" href="<?= base_url('usuarios') ?>">Usuarios</a>
                    <?php endif; ?>
                    
                    <?php if (tienePermiso('roles_ver')): ?>
                    <a class="dropdown-item" href="<?= base_url('roles') ?>">Roles y Permisos</a>
                    <?php endif; ?>
                    
                    <?php if (tienePermiso('cajas_ver')): ?>
                    <a class="dropdown-item" href="<?= base_url('cajas') ?>">Cajas</a>
                    <?php endif; ?>
                    
                    <?php if (tienePermiso('configuracion_ver')): ?>
                    <a class="dropdown-item" href="<?= base_url('configuracion') ?>">Configuración</a>
                    <?php endif; ?>
                    
                    <?php if (tienePermiso('logs_ver')): ?>
                    <a class="dropdown-item" href="<?= base_url('logs') ?>">Logs</a>
                    <?php endif; ?>
                </div>
            </li>
            <?php endif; ?>
        </ul>
        
        <!-- Información del usuario -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <span class="navbar-text text-white">
                    <?= session()->get('nombre') ?> (<?= session()->get('nombre_rol') ?>)
                </span>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('usuarios/lockscreen') ?>">
                    <i class="fas fa-lock"></i> Bloquear
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('usuarios/logout') ?>">
                    <i class="fas fa-sign-out-alt"></i> Salir
                </a>
            </li>
        </ul>
    </div>
</nav>

================================================================================ 8. VISTAS PARA ROLES
================================================================================

### 8.1 Nueva vista: app/Views/roles/nuevo.php

<?= view('header') ?>

<div class="container mt-4">
    <h2><?= $titulo ?></h2>
    
    <?php if (session()->getFlashdata('msg_error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('msg_error') ?></div>
    <?php endif; ?>
    
    <form method="post" action="<?= base_url('roles/insertar') ?>">
        <div class="form-group">
            <label for="nombre">Nombre del Rol</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        
        <h4>Permisos</h4>
        <div class="row">
            <?php foreach ($permisos as $permiso): ?>
            <div class="col-md-4 mb-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" 
                           name="permisos[]" 
                           value="<?= $permiso['id'] ?>" 
                           id="permiso_<?= $permiso['id'] ?>">
                    <label class="form-check-label" for="permiso_<?= $permiso['id'] ?>">
                        <?= $permiso['nombre'] ?>
                        <?php if ($permiso['descripcion']): ?>
                        <small class="text-muted">(<?= $permiso['descripcion'] ?>)</small>
                        <?php endif; ?>
                    </label>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="<?= base_url('roles') ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?= view('footer') ?>

### 8.2 Nueva vista: app/Views/roles/editar.php

<?= view('header') ?>

<div class="container mt-4">
    <h2><?= $titulo ?></h2>
    
    <form method="post" action="<?= base_url('roles/actualizar') ?>">
        <input type="hidden" name="id" value="<?= $datos['id'] ?>">
        
        <div class="form-group">
            <label for="nombre">Nombre del Rol</label>
            <input type="text" class="form-control" id="nombre" name="nombre" 
                   value="<?= $datos['nombre'] ?>" required>
        </div>
        
        <h4>Permisos</h4>
        <div class="row">
            <?php foreach ($permisos as $permiso): ?>
            <div class="col-md-4 mb-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" 
                           name="permisos[]" 
                           value="<?= $permiso['id'] ?>" 
                           id="permiso_<?= $permiso['id'] ?>"
                           <?= in_array($permiso['id'], $permisos_asignados) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="permiso_<?= $permiso['id'] ?>">
                        <?= $permiso['nombre'] ?>
                        <?php if ($permiso['descripcion']): ?>
                        <small class="text-muted">(<?= $permiso['descripcion'] ?>)</small>
                        <?php endif; ?>
                    </label>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="<?= base_url('roles') ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?= view('footer') ?>

### 8.3 Actualizar vista: app/Views/roles/index.php

<?= view('header') ?>

<div class="container mt-4">
    <h2><?= $titulo ?></h2>
    
    <?php if (session()->getFlashdata('msg_success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('msg_success') ?></div>
    <?php endif; ?>
    
    <a href="<?= base_url('roles/nuevo') ?>" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Nuevo Rol
    </a>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datos as $dato): ?>
            <tr>
                <td><?= $dato['id'] ?></td>
                <td><?= $dato['nombre'] ?></td>
                <td>
                    <a href="<?= base_url('roles/editar/' . $dato['id']) ?>" 
                       class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <a href="<?= base_url('roles/eliminar/' . $dato['id']) ?>" 
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('¿Está seguro de eliminar este rol?')">
                        <i class="fas fa-trash"></i> Eliminar
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <a href="<?= base_url('roles/eliminados') ?>" class="btn btn-secondary">
        Ver Roles Eliminados
    </a>
</div>

<?= view('footer') ?>

### 8.4 Nueva vista: app/Views/roles/eliminados.php

<?= view('header') ?>

<div class="container mt-4">
    <h2><?= $titulo ?></h2>
    
    <?php if (session()->getFlashdata('msg_success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('msg_success') ?></div>
    <?php endif; ?>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datos as $dato): ?>
            <tr>
                <td><?= $dato['id'] ?></td>
                <td><?= $dato['nombre'] ?></td>
                <td>
                    <a href="<?= base_url('roles/reingresar/' . $dato['id']) ?>" 
                       class="btn btn-sm btn-success">
                        <i class="fas fa-recycle"></i> Reingresar
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <a href="<?= base_url('roles') ?>" class="btn btn-secondary">
        Volver a Roles Activos
    </a>
</div>

<?= view('footer') ?>

================================================================================ 9. ACTUALIZACIÓN DE FILTROS DE AUTENTICACIÓN
================================================================================

### 9.1 Actualizar app/Filters/AuthFilter.php

<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url());
        }

        if (session()->get('isLocked')) {
            return redirect()->to(base_url('usuarios/lockscreen'));
        }
        
        // Verificar permisos si se proporcionan argumentos
        if ($arguments !== null && is_array($arguments)) {
            helper('permisos');
            foreach ($arguments as $permiso) {
                if (!tienePermiso($permiso)) {
                    // Redirigir a una página de acceso denegado
                    session()->setFlashdata('msg_error', 'No tienes permiso para acceder a esta sección');
                    return redirect()->to(base_url('dashboard'));
                }
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nada aquí
    }
}

================================================================================
10. CONFIGURACIÓN DE RUTAS
================================================================================

### 10.1 Agregar rutas en app/Config/Routes.php

// Rutas de Roles
$routes->get('/roles', 'Roles::index');
$routes->get('/roles/nuevo', 'Roles::nuevo');
$routes->post('/roles/insertar', 'Roles::insertar');
$routes->get('/roles/editar/(:num)', 'Roles::editar/$1');
$routes->post('/roles/actualizar', 'Roles::actualizar');
$routes->get('/roles/eliminar/(:num)', 'Roles::eliminar/$1');
$routes->get('/roles/reingresar/(:num)', 'Roles::reingresar/$1');
$routes->get('/roles/eliminados', 'Roles::eliminados');

================================================================================
11. CÓMO USAR EN LOS CONTROLADORES
================================================================================

### 11.1 Ejemplo: Proteger método en controlador de Ventas

<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VentasModel;

class Ventas extends BaseController
{
    public function index()
    {
        // Verificar permiso
        helper('permisos');
        if (!tienePermiso('ventas_ver')) {
            session()->setFlashdata('msg_error', 'No tienes permiso para ver ventas');
            return redirect()->to(base_url('dashboard'));
        }
        
        $ventas = $this->ventas->findAll();
        $data = ['titulo' => 'Ventas', 'datos' => $ventas];
        
        return view('header')
            . view('ventas/index', $data)
            . view('footer');
    }
    
    public function nuevo()
    {
        // Verificar permiso
        helper('permisos');
        if (!tienePermiso('ventas_agregar')) {
            session()->setFlashdata('msg_error', 'No tienes permiso para realizar ventas');
            return redirect()->to(base_url('dashboard'));
        }
        
        // Resto del código...
    }
    
    public function eliminar($id)
    {
        // Verificar permiso
        helper('permisos');
        if (!tienePermiso('ventas_eliminar')) {
            session()->setFlashdata('msg_error', 'No tienes permiso para eliminar ventas');
            return redirect()->to(base_url('dashboard'));
        }
        
        // Resto del código...
    }
}

### 11.2 Ejemplo: Proteger ruta completa con filtro

// En app/Config/Routes.php
$routes->group('ventas', ['filter' => 'auth:ventas_ver'], function($routes) {
    $routes->get('/', 'Ventas::index');
    $routes->get('nuevo', 'Ventas::nuevo');
    $routes->post('insertar', 'Ventas::insertar');
    $routes->get('eliminar/(:num)', 'Ventas::eliminar/$1');
});

================================================================================
12. ACTUALIZAR ARCHIVO DE CONFIGURACIÓN
================================================================================

### 12.1 Agregar en app/Config/Autoload.php

// En el array de helpers
public $helpers = ['url', 'form', 'permisos'];

================================================================================
13. ESTRUCTURA DE PERMISOS RECOMENDADOS
================================================================================

Permisos por módulo:

USUARIOS:
- usuarios_ver       - Ver lista de usuarios
- usuarios_agregar   - Crear nuevos usuarios  
- usuarios_editar    - Modificar usuarios existentes
- usuarios_eliminar  - Eliminar usuarios

ROLES:
- roles_ver          - Ver lista de roles
- roles_agregar      - Crear nuevos roles
- roles_editar       - Modificar roles y permisos
- roles_eliminar     - Eliminar roles

VENTAS:
- ventas_ver         - Ver lista de ventas
- ventas_agregar     - Realizar nuevas ventas
- ventas_eliminar    - Eliminar ventas

COMPRAS:
- compras_ver        - Ver lista de compras
- compras_agregar    - Realizar nuevas compras
- compras_eliminar   - Eliminar compras

PRODUCTOS:
- productos_ver      - Ver lista de productos
- productos_agregar  - Agregar nuevos productos
- productos_editar   - Modificar productos
- productos_eliminar - Eliminar productos

CATEGORÍAS:
- categorias_ver     - Ver lista de categorías
- categorias_agregar - Agregar nuevas categorías
- categorias_editar - Modificar categorías
- categorias_eliminar - Eliminar categorías

CLIENTES:
- clientes_ver       - Ver lista de clientes
- clientes_agregar  - Agregar nuevos clientes
- clientes_editar    - Modificar clientes
- clientes_eliminar  - Eliminar clientes

CONFIGURACIÓN:
- configuracion_ver   - Ver configuración
- configuracion_editar - Modificar configuración

CAJAS:
- cajas_ver          - Ver lista de cajas
- cajas_agregar      - Crear cajas
- cajas_editar       - Modificar cajas
- cajas_eliminar     - Eliminar cajas

LOGS:
- logs_ver           - Ver logs del sistema

================================================================================
14. RESUMEN DE IMPLEMENTACIÓN
================================================================================

Pasos para implementar:

1. EJECUTAR MIGRACIONES:
   - php spark migrate

2. CREAR MODELOS:
   - app/Models/PermisosModel.php
   - app/Models/RolesPermisosModel.php

3. CREAR BIBLIOTECA:
   - app/Libraries/Authorization.php

4. CREAR HELPER:
   - app/Helpers/permisos_helper.php

5. ACTUALIZAR AUTOLOAD:
   - app/Config/Autoload.php (agregar helper permisos)

6. ACTUALIZAR CONTROLADOR USUARIOS:
   - app/Controllers/Usuarios.php (método valida)

7. CREAR CONTROLADOR ROLES:
   - app/Controllers/Roles.php

8. CREAR/ACTUALIZAR VISTAS:
   - app/Views/roles/nuevo.php
   - app/Views/roles/editar.php
   - app/Views/roles/index.php
   - app/Views/roles/eliminados.php

9. ACTUALIZAR VISTAS:
   - app/Views/header.php (menú con permisos)

10. AGREGAR RUTAS:
    - app/Config/Routes.php

11. ACTUALIZAR CONTROLADORES:
    - Agregar verificación de permisos en cada método

================================================================================

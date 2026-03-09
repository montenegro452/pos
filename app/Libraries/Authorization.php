<?php

namespace App\Libraries;

use App\Models\PermisosModel;
use App\Models\RolesPermisosModel;

class Authorization
{
    protected $permisosModel, $rolesPermisosModel;

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

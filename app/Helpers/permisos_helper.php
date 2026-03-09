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

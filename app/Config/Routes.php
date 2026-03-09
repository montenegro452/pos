<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$crudControllers = [
    'productos' => 'Productos',
    'categorias'  => 'Categorias',
    'unidades'    => 'Unidades',
    'clientes'    => 'Clientes',
    'configuracion'    => 'Configuracion',
    'usuarios'  => 'Usuarios',
    'roles'  => 'Roles',
    'cajas'  => 'Cajas',
    'compras'  => 'Compras',
    'ventas'  => 'Ventas',
    'logs'  => 'Logs',
];

foreach ($crudControllers as $base => $controller) {
    defineCrudRoutes($routes, $base, $controller);
}

function defineCrudRoutes($routes, $base, $controller)
{
    $routes->group($base, function ($routes) use ($controller) {
        $routes->get('', $controller . '::index');
        $routes->get('nuevo', $controller . '::nuevo');
        $routes->post('insertar', $controller . '::insertar');
        $routes->get('editar/(:segment)', $controller . '::editar/$1');
        $routes->post('actualizar', $controller . '::actualizar');
        $routes->get('arqueo/(:num)', $controller . '::arqueo/$1');
        $routes->get('nuevo_arqueo', $controller . '::nuevo_arqueo');
        $routes->post('nuevo_arqueo', $controller . '::nuevo_arqueo');
        $routes->get('eliminar/(:num)', $controller . '::eliminar/$1');
        $routes->get('eliminados', $controller . '::eliminados');
        $routes->get('reingresar/(:num)', $controller . '::reingresar/$1');
        $routes->post('valida', $controller . '::valida');
        $routes->get('logout', $controller . '::logout');
        $routes->get('lockscreen', $controller . '::lockscreen');
        $routes->post('unlock', $controller . '::unlock');
        $routes->get('cerrar/(:num)', $controller . '::cerrar/$1');
        $routes->post('cerrar/(:num)', $controller . '::cerrar/$1');
        $routes->get('autocompleteData', $controller . '::autocompleteData');
        $routes->get('buscarPorCodigo/(:num)', $controller . '::buscarPorCodigo/$1');
        $routes->post('obtenerPermisosRol', $controller . '::obtenerPermisosRol');
    });
}

$routes->get('/', 'Home::login');
$routes->get('lockscreen', 'Home::lockscreen');
$routes->get('TemporalCompra/inserta/(:num)/(:num)/(:any)', 'TemporalCompra::inserta/$1/$2/$3');
$routes->get('elimina/(:num)/(:any)', 'TemporalCompra::elimina/$1/$2');
$routes->get('TemporalVenta/inserta/(:num)/(:num)/(:any)', 'TemporalVenta::inserta/$1/$2/$3');
$routes->get('TemporalVenta/elimina/(:num)/(:any)', 'TemporalVenta::elimina/$1/$2');
$routes->post('compras/guarda', 'Compras::guarda');
$routes->get('compras/ver_compra_pdf/(:num)', 'Compras::muestraCompraPdf/$1');
$routes->get('compras/muestraCompraPdf/(:num)', 'Compras::muestraCompraPdf/$1');
$routes->get('compras/generaCompraPdf/(:num)', 'Compras::generaCompraPdf/$1');
$routes->get('ventas/caja', 'Ventas::venta');
$routes->post('ventas/guarda', 'Ventas::guarda');
$routes->get('ventas/muestraTicket/(:num)', 'Ventas::muestraTicket/$1');
$routes->get('ventas/generaTicket/(:num)', 'Ventas::generaTicket/$1');
$routes->get('productos/generaBarras', 'Productos::generaBarras');
$routes->get('productos/muestraCodigo', 'Productos::muestraCodigo');
$routes->get('productos/mostrarMinimos', 'Productos::mostrarMinimos');
$routes->get('productos/mostrarMinimosExcel', 'Productos::mostrarMinimosExcel');
$routes->get('productos/generaMinimosPdf', 'Productos::generaMinimosPdf');
$routes->get('dashboard', 'Home::dashboard', ['filter' => 'auth']);

$routes->get('acceso_denegado', function () {
    return view('acceso_denegado');
});

$routes->set404Override(function () {
    return view('error_404');
});

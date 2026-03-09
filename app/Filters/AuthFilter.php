<?php

namespace App\Filters;

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
                    session()->setFlashdata('msg_error', 'No tienes permiso para acceder a esta sección');
                    redirect()->to(base_url('acceso_denegado'));
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

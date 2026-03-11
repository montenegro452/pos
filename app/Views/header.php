<?php
// Cargar helper de permisos
helper('permisos');
$user_session = session();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Carlos Montenegro Garcia">
  <meta name="csrf-token" content="<?= csrf_hash() ?>">
  <meta name="csrf-name" content="<?= csrf_token() ?>">
  <title><?= esc($title ?? 'Sistema de Ventas - Doña Nuria') ?></title>
  <link rel="stylesheet" href="<?= base_url(); ?>vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>vendors/base/vendor.bundle.base.css">
  <link rel="stylesheet" href="<?= base_url(); ?>vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="<?= base_url(); ?>css/style.css">
  <link rel="stylesheet" href="<?= base_url(); ?>js/jquery-ui/jquery-ui.min.css">
  <link rel="shortcut icon" href="<?= base_url(); ?>images/logo.png" />
  <script src="<?= base_url(); ?>js/jquery-3.7.1.js"></script>
  <script src="<?= base_url(); ?>vendors/chart.js/Chart.min.js"></script>
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="navbar-brand-wrapper d-flex justify-content-center">
        <div
          class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
          <a class="navbar-brand brand-logo" href="<?= base_url(); ?>"><img src="<?= base_url(); ?>images/logo.png" alt="logo" /></a>
          <a class="navbar-brand brand-logo-mini" href="<?= base_url(); ?>"><img src="<?= base_url(); ?>images/logo.png" alt="logo" /></a>
          <button
            class="navbar-toggler navbar-toggler align-self-center"
            type="button"
            data-toggle="minimize">
            <span class="mdi mdi-sort-variant"></span>
          </button>
        </div>
      </div>
      <div
        class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item dropdown mr-1">
            <a
              class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center"
              id="messageDropdown"
              href="#"
              data-toggle="dropdown">
              <i class="mdi mdi-message-text mx-0"></i>
              <span class="count"></span>
            </a>
            <div
              class="dropdown-menu dropdown-menu-right navbar-dropdown"
              aria-labelledby="messageDropdown">
              <p class="mb-0 font-weight-normal float-left dropdown-header">
                Mensajes
              </p>
              <a class="dropdown-item">
                <div class="item-thumbnail">
                  <img
                    src="<?= base_url(); ?>images/faces/face4.jpg"
                    alt="image"
                    class="profile-pic" />
                </div>
                <div class="item-content flex-grow">
                  <h6 class="ellipsis font-weight-normal">David Grey</h6>
                  <p class="font-weight-light small-text text-muted mb-0">
                    The meeting is cancelled
                  </p>
                </div>
              </a>
            </div>
          </li>
          <li class="nav-item nav-profile dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              data-toggle="dropdown"
              id="profileDropdown">
              <img src="<?= base_url(); ?>images/faces/face5.jpg" alt="profile" />
              <span class="nav-profile-name"><?= session()->get('nombre') ?> (<?= session()->get('nombre_rol') ?>)</span>
            </a>
            <div
              class="dropdown-menu dropdown-menu-right navbar-dropdown"
              aria-labelledby="profileDropdown">
              <?php if (tienePermiso('configuracion_ver')): ?>
                <a class="dropdown-item" href="<?= base_url('configuracion'); ?>">
                  <i class="mdi mdi-settings text-primary"></i>
                  Configuracion
                </a>
              <?php endif; ?>
              <a class="dropdown-item" href="<?= base_url('usuarios/lockscreen') ?>">
                <i class=" mdi mdi-lock text-primary"></i>
                Bloquear
              </a>
              <a class="dropdown-item" href="<?= base_url('usuarios/logout'); ?>">
                <i class="mdi mdi-logout text-primary"></i>
                Salir
              </a>
            </div>
          </li>
        </ul>
        <button
          class="navbar-toggler navbar-toggler-right d-lg-none align-self-center"
          type="button"
          data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url(); ?>">
              <i class="mdi mdi-home menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a
              class="nav-link"
              data-toggle="collapse"
              href="#ui-productos"
              aria-expanded="false"
              aria-controls="ui-productos">
              <i class="mdi mdi-basket menu-icon"></i>
              <span class="menu-title">Productos</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-productos">
              <ul class="nav flex-column sub-menu">
                <?php if (tienePermiso('productos_ver')): ?>
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url(); ?>productos">Productos</a>
                  </li>
                <?php endif; ?>
                <?php if (tienePermiso('categorias_ver')): ?>
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url(); ?>categorias">Categorias</a>
                  </li>
                <?php endif; ?>
                <?php if (tienePermiso('unidades_ver')): ?>
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url(); ?>unidades">Unidades</a>
                  </li>
                <?php endif; ?>
              </ul>
            </div>
          </li>
          <?php if (tienePermiso('inventario_ver')): ?>
            <li class="nav-item">
              <a
                class="nav-link"
                data-toggle="collapse"
                href="#ui-inventario"
                aria-expanded="false"
                aria-controls="ui-inventario">
                <i class="mdi mdi-truck-delivery menu-icon"></i>
                <span class="menu-title">Inventario</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="ui-inventario">
                <ul class="nav flex-column sub-menu">
                  <?php if (tienePermiso('inventario_agregar')): ?>
                    <li class="nav-item">
                      <a class="nav-link" href="<?= base_url(); ?>inventario/nuevo">Agregar al inventario</a>
                    </li>
                  <?php endif; ?>
                  <?php if (tienePermiso('inventario_agregar')): ?>
                    <li class="nav-item">
                      <a class="nav-link" href="<?= base_url(); ?>inventario">Inventario</a>
                    </li>
                  <?php endif; ?>
                </ul>
              </div>
            </li>
          <?php endif; ?>
          <?php if (tienePermiso('cajas_agregar')): ?>
            <li class="nav-item">
              <a class="nav-link" href="<?= base_url(); ?>ventas/caja">
                <i class="mdi mdi-shopping menu-icon"></i>
                <span class="menu-title">Caja</span>
              </a>
            </li>
          <?php endif; ?>
          <?php if (tienePermiso('ventas_ver')): ?>
            <li class="nav-item">
              <a class="nav-link" href="<?= base_url(); ?>ventas">
                <i class="mdi mdi-basket-unfill menu-icon"></i>
                <span class="menu-title">Ventas</span>
              </a>
            </li>
          <?php endif; ?>
          <?php if (tienePermiso('reportes_ver')): ?>
            <li class="nav-item">
              <a
                class="nav-link"
                data-toggle="collapse"
                href="#ui-reportes"
                aria-expanded="false"
                aria-controls="ui-reportes">
                <i class=" mdi mdi-format-list-bulleted menu-icon"></i>
                <span class="menu-title">Reportes</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="ui-reportes">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url(); ?>productos/mostrarMinimos">Reportes Mínimos</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url(); ?>productos/mostrarMinimosExcel">Reportes Mínimos Excel</a>
                  </li>
                </ul>
              </div>
            </li>
          <?php endif; ?>
          <?php if (tienePermiso('configuracion_ver') || tienePermiso('configuracion_editar')): ?>
            <li class="nav-item">
              <a
                class="nav-link"
                data-toggle="collapse"
                href="#ui-config"
                aria-expanded="false"
                aria-controls="ui-config">
                <i class="mdi mdi-settings menu-icon"></i>
                <span class="menu-title">Administración</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="ui-config">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url(); ?>configuracion">Configuración</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url(); ?>roles">Roles</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url(); ?>logs">Logs</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url(); ?>cajas">Cajas</a>
                  </li>
                </ul>
              </div>
            </li>
          <?php endif; ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url(); ?>clientes">
              <i class="mdi mdi-account-multiple menu-icon"></i>
              <span class="menu-title">Clientes</span>
            </a>
          </li>
          <?php if (tienePermiso('usuarios_ver')): ?>
            <li class="nav-item">
              <a
                class="nav-link"
                data-toggle="collapse"
                href="#auth"
                aria-expanded="false"
                aria-controls="auth">
                <i class="mdi mdi-account menu-icon"></i>
                <span class="menu-title">Usuarios</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="auth">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url(); ?>usuarios"> Usuarios</a>
                  </li>
                  <!--<li class="nav-item">
                  <a class="nav-link" href="pages/samples/login-2.html">
                    Login 2
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="pages/samples/register.html">
                    Register
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="pages/samples/register-2.html">
                    Register 2
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="pages/samples/lock-screen.html">
                    Lockscreen
                  </a>
                </li>-->
                </ul>
              </div>
            </li>
          <?php endif; ?>
        </ul>
      </nav>
      <!-- partial -->
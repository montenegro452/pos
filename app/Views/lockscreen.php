<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Reingresar - Sistema de Ventas</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>vendors/base/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>images/favicon.png" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth lock-full-bg">
                <div class="row w-100">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-transparent text-left p-5 text-center">
                            <img src="<?php echo base_url(); ?>images/faces/face17.jpg" class="lock-profile-img" alt="img">
                            <h4 style="color: white;">Hola, <?= esc($nombre ?? 'Usuario') ?>!</h4>
                            <form class="pt-5" action="<?= base_url('usuarios/unlock') ?>" method="post">
                                <div class="form-group">
                                    <label style="color: white;">Ingresa tu contraseña para desbloquear.</label>
                                    <input type="password" class="form-control text-center" id="password" name="password" placeholder="Contraseña" autocomplete="off" autofocus>
                                </div>
                                <div class="mt-5">
                                    <button class="btn btn-block btn-success btn-lg font-weight-medium" href="<?php echo base_url(); ?>" type="submit">Desbloquear</button>
                                </div>
                                <div class="mt-3 text-center">
                                    <a href="<?= base_url('usuarios/logout') ?>" class="auth-link text-white">Inicie usando un usuario diferente</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="<?php echo base_url(); ?>vendors/base/vendor.bundle.base.js"></script>
    <script src="<?= base_url(); ?>js/sweetalert2@11.js"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="<?php echo base_url(); ?>js/off-canvas.js"></script>
    <script src="<?php echo base_url(); ?>js/hoverable-collapse.js"></script>
    <script src="<?php echo base_url(); ?>js/template.js"></script>
    <!-- endinject -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const errorMsg = '<?= addslashes(session()->getFlashdata('msg_error')) ?>';
            if (errorMsg) {
                Swal.fire({
                    title: 'Error',
                    html: errorMsg,
                    icon: 'error'
                });
            }
        });
    </script>
</body>

</html>
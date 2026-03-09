<?php
$user_session = session();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Carlos Montenegro Garcia">
    <title>Doña Nuria - Login</title>
    <link rel="stylesheet" href="<?= base_url(); ?>vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>vendors/base/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?= base_url(); ?>css/style.css">
    <link rel="shortcut icon" href="<?= base_url(); ?>images/logo.png" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
                <div class="row flex-grow">
                    <div class="col-lg-6 d-flex align-items-center justify-content-center">
                        <div class="auth-form-transparent text-left p-3">
                            <div class="brand-logo">
                                <img src="<?= base_url(); ?>images/logo.png" alt="logo">
                            </div>
                            <h4>Bienvenid@!</h4>
                            <h6 class="font-weight-light">Es un placer verlo!</h6>
                            <form class="pt-3" method="POST" action="<?php echo base_url(); ?>usuarios/valida">
                                <?php if (isset($validation)) { ?>
                                    <div class="alert alert-danger">
                                        <?php echo $validation->listErrors(); ?>
                                    </div>
                                <?php } ?>
                                <div class="form-group">
                                    <label>Usuario</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="mdi mdi-account-outline text-primary"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control form-control-lg border-left-0" id="usuario" name="usuario" placeholder="Usuario">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="mdi mdi-lock-outline text-primary"></i>
                                            </span>
                                        </div>
                                        <input type="password" class="form-control form-control-lg border-left-0" id="password" name="password" placeholder="Contraseña">
                                    </div>
                                </div>
                                <div class="my-3">
                                    <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit">Entrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 login-half-bg d-flex flex-row">
                        <p class="text-white font-weight-medium text-center flex-grow align-self-end">Diseñada por Carlos Montenegro Garcia &copy; <?= date('Y'); ?></p>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <script src="<?= base_url(); ?>vendors/base/vendor.bundle.base.js"></script>
    <script src="<?= base_url(); ?>js/off-canvas.js"></script>
    <script src="<?= base_url(); ?>js/hoverable-collapse.js"></script>
    <script src="<?= base_url(); ?>js/template.js"></script>
    <script src="<?= base_url(); ?>js/sweetalert2@11.js"></script>

    <?php if (session()->getFlashdata('msg_error')): ?>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      Swal.fire({
        title: 'Errores',
        html: '<?= addslashes(session()->getFlashdata('msg_error')) ?>',
        icon: 'error'
      });
    });
  </script>
<?php endif; ?>
</body>

</html>
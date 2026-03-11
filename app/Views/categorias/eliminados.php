<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title"><?php echo $titulo ?></h4>
            <div>
            </div>
            <div class="table-responsive">
              <?php if (empty($datos)): ?>
                <a href="<?php echo base_url(); ?>categorias" class="mdi mdi-arrow-left btn btn-sm btn-primary btn-icon-text">Regresar</a>
                <br>
                <br>
                <div class="alert alert-info" role="alert">
                  No hay categorias eliminadas.
                </div>
              <?php else: ?>
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Nombre</th>
                      <th>Nombre corto</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($datos as $dato): ?>
                      <tr>
                        <td><?= $dato['id'] ?></td>
                        <td><?= $dato['nombre'] ?></td>
                        <td>
                          <a href="#" data-href="<?= base_url('categorias/reingresar/' . $dato['id']) ?>" data-confirm="¿Desea reingresar esta categoria?" data-confirm-title="Reingresar categoria" class="btn btn-success">
                            <i class="mdi mdi-arrow-up-bold menu-icon"></i>Reingresar
                          </a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- content-wrapper ends -->
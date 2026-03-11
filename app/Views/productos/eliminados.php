<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title"><?php echo $titulo ?></h4>
            <div class="table-responsive">
              <?php if (empty($datos)): ?>
                <a href="<?php echo base_url(); ?>productos" class="mdi mdi-arrow-left btn btn-sm btn-primary btn-icon-text">Regresar</a>
                <br>
                <br>
                <div class="alert alert-info" role="alert">
                  No hay productos eliminados.
                </div>
              <?php else: ?>
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>
                        Id
                      </th>
                      <th>
                        Código
                      </th>
                      <th>
                        Nombre
                      </th>
                      <th>
                        Precio
                      </th>
                      <th>
                        Existencias
                      </th>
                      <th>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($datos as $dato) {
                    ?>
                      <tr>
                        <td><?php echo $dato['id']; ?></td>
                        <td><?php echo $dato['codigo']; ?></td>
                        <td><?php echo $dato['nombre']; ?></td>
                        <td><?php echo $dato['precio_venta']; ?></td>
                        <td><?php echo $dato['existencias']; ?></td>
                        <td><a href="#" data-href="<?php echo base_url() . '/productos/reingresar/' . $dato['id']; ?>" data-confirm="¿Desea reingresar este producto?" data-confirm-title="Reingresar producto" data-placement="top" title="Reingresar registro" class="btn btn-success"><i class="mdi mdi-arrow-up-bold menu-icon"></i> Reingresar</a></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
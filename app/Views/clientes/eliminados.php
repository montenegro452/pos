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
                <a href="<?php echo base_url(); ?>clientes" class="btn btn-primary">Regresar</a>
                <br>
                <br>
                <div class="alert alert-info" role="alert">
                  No hay clientes eliminados.
                </div>
              <?php else: ?>
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>
                        Id
                      </th>
                      <th>
                        Nombre
                      </th>
                      <th>
                        Direccion
                      </th>
                      <th>
                        Telefono
                      </th>
                      <th>
                        Correo
                      </th>
                      <th>
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
                        <td><?php echo $dato['nombre']; ?></td>
                        <td><?php echo $dato['direccion']; ?></td>
                        <td><?php echo $dato['telefono']; ?></td>
                        <td><?php echo $dato['correo']; ?></td>
                        <td><a href="#" data-href="<?php echo base_url() . '/clientes/reingresar/' . $dato['id']; ?>"
                            data-confirm="¿Desea reingresar este cliente?" data-confirm-title="Reingresar cliente"
                            data-placement="top" title="Reingresar registro" class="btn btn-success">
                            <i class="mdi mdi-arrow-up-bold menu-icon"></i> Reingresar</a></td>
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
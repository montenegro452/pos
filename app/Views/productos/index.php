      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title"><?php echo $titulo ?></h4>
                  <div>
                    <p>
                      <a href="<?php echo base_url(); ?>productos/nuevo" class="btn btn-primary btn-icon-text">
                        <i class="mdi mdi-file-check btn-icon-prepend"></i>Agregar</a>
                      <a href="<?php echo base_url(); ?>productos/eliminados" class="btn btn-dark btn-icon-text">
                        <i class="mdi mdi-window-close btn-icon-prepend"></i>Eliminados</a>
                      <a href="<?php echo base_url(); ?>productos/muestraCodigo" class="btn btn-success btn-icon-text">
                        <i class="mdi mdi-barcode  btn-icon-prepend"></i>Codigos de Barra</a>
                    </p>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
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
                            Imagen
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
                            <td><?php echo $dato['codigo']; ?></td>
                            <td><?php echo $dato['nombre']; ?></td>
                            <td><?php echo $dato['precio_venta']; ?></td>
                            <td><?php echo $dato['existencias']; ?></td>
                            <td><img src="<?= file_exists('images/productos/' . $dato['id'] . '.jpg') ? base_url('images/productos/' . $dato['id'] . '.jpg') : base_url('images/no_foto.png'); ?>" class="img-responsive" width="200" /></td>
                            <td><a href="<?php echo base_url() . 'productos/editar/' . $dato['id']; ?>" class="btn btn-warning btn-icon-text"><i class="mdi mdi-lead-pencil btn-icon-prepend"></i>Editar</a></td>
                            <td><a href="#" data-href="<?php echo base_url() . 'productos/eliminar/' . $dato['id']; ?>" data-confirm="¿Desea eliminar este producto?" data-confirm-title="Eliminar producto" data-placement="top" title="Eliminar registro" class="btn btn-danger btn-icon-text"><i class="mdi mdi-window-close btn-icon-prepend"></i>Eliminar</a></td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
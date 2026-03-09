<?php

use CodeIgniter\I18n\Time;
?>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title"><?php echo $titulo ?></h4>
            <div>
              <p>
                <a href="<?php echo base_url(); ?>ventas" class="btn btn-primary btn-icon-text">
                  <i class="mdi mdi-file-check btn-icon-prepend"></i>Ventas</a>
              </p>
            </div>
            <div class="table-responsive">
              <?php if (empty($datos)) { ?>
                <div class="alert alert-info" role="alert">
                  No hay ventas eliminadas.
                </div>
              <?php } else { ?>
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>
                        Fecha
                      </th>
                      <th>
                        Folio
                      </th>
                      <th>
                        Cliente
                      </th>
                      <th>
                        Total
                      </th>
                      <th>
                        Cajero
                      </th>
                      <th>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($datos as $dato) {
                    ?>
                      <tr>
                        <?php $fecha = Time::parse($dato['fecha_alta']);                                            ?>
                        <td><?php echo $fecha->format('d/m/Y H:i:s'); ?></td>
                        <td><?php echo $dato['folio']; ?></td>
                        <td><?php echo $dato['cliente']; ?></td>
                        <td><?php echo '$' . number_format($dato['total'], 2); ?></td>
                        <td><?php echo $dato['cajero']; ?></td>
                        <td><a href="<?php echo base_url() . 'ventas/muestraTicket/' . $dato['id']; ?>" class="btn btn-warning btn-icon-text"><i class="mdi mdi-format-list-bulleted btn-icon-prepend"></i>Ticket</a></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- content-wrapper ends -->
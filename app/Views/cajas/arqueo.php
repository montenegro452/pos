<?php

use CodeIgniter\I18n\Time;
?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo $titulo; ?></h4>
                        <div>
                            <p>
                                <a href="<?php echo base_url(); ?>cajas/nuevo_arqueo" class="btn btn-primary btn-icon-text">
                                    <i class="mdi mdi-file-check btn-icon-prepend"></i>Agregar</a>
                                <a href="<?php echo base_url(); ?>cajas/eliminados" class="btn btn-dark btn-icon-text">
                                    <i class="mdi mdi-window-close btn-icon-prepend"></i>Eliminados</a>
                            </p>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            Id
                                        </th>
                                        <th>
                                            Fecha apertura
                                        </th>
                                        <th>
                                            Fecha cierre
                                        </th>
                                        <th>
                                            Monto inicial
                                        </th>
                                        <th>
                                            Monto final
                                        </th>
                                        <th>
                                            Total ventas
                                        </th>
                                        <th>
                                            Estatus
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($datos as $dato) {
                                    ?>
                                        <tr>
                                            <td><?php echo $dato['id']; ?></td>
                                            <?php $fecha = Time::parse($dato['fecha_apertura']);
                                            ?>
                                            <td><?php echo $fecha->format('d/m/Y H:i:s'); ?></td>
                                            <td><?php echo $dato['fecha_fin']; ?></td>
                                            <td><?php echo $dato['monto_inicial']; ?></td>
                                            <td><?php echo $dato['monto_final']; ?></td>
                                            <td><?php echo $dato['total_ventas']; ?></td>
                                            <?php if ($dato['estatus'] == 1) { ?>
                                                <td>Abierta</td>
                                                <td><a href="#" data-href="<?= base_url() . 'cajas/cerrar/' .
                                                                                $dato['id']; ?>"
                                                        data-confirm-title="Cerrar Caja"
                                                        data-confirm="¿Está seguro que desea cerrar esta caja?"
                                                        title="Cerrar Caja" class="btn btn-danger"><i class="mdi mdi-lock"></i></a></td>
                                            <?php } else { ?>
                                                <td>Cerrada</td>
                                                <td><a href="#" data-href="<?= base_url() . 'cajas/eliminar' . $dato['id']; ?>"
                                                        data-toggle="modal" data-target="#add-new" data-placement="top" title="Eliminar registro"
                                                        class="btn btn-success"><i class="mdi mdi-printer"></i></a></td>
                                            <?php } ?>
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
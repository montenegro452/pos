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
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="MisTablas">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            Id
                                        </th>
                                        <th scope="col">
                                            Folio
                                        </th>
                                        <th scope="col">
                                            Total
                                        </th>
                                        <th scope="col">
                                            Fecha
                                        </th>
                                        <th scope="col">

                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($inventario as $invent) {
                                    ?>
                                        <tr>
                                            <td><?php echo $invent['id']; ?></td>
                                            <td><?php echo $invent['folio']; ?></td>
                                            <td><?php echo floatval(str_replace(',', '.', $invent['total'])); ?></td>
                                            <?php $fecha = Time::parse($invent['fecha_alta']);
                                            ?>
                                            <td><?php echo $fecha->format('d/m/Y H:i:s'); ?></td>
                                            <td><a href="<?php echo base_url() . 'inventario/muestraCompraPdf/' .
                                                                $invent['id']; ?>" class="btn btn-sm btn-primary btn-icon-text"><i class="mdi mdi-file-pdf btn-icon-prepend"></i>Ver ticket</a></td>
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
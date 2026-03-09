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
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            Id
                                        </th>
                                        <th>
                                            Folio
                                        </th>
                                        <th>
                                            Total
                                        </th>
                                        <th>
                                            Fecha
                                        </th>
                                        <th>

                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($compras as $compra) {
                                    ?>
                                        <tr>
                                            <td><?php echo $compra['id']; ?></td>
                                            <td><?php echo $compra['folio']; ?></td>
                                            <td><?php echo floatval(str_replace(',', '.', $compra['total'])); ?></td>
                                            <?php $fecha = Time::parse($compra['fecha_alta']);
                                            ?>
                                            <td><?php echo $fecha->format('d/m/Y H:i:s'); ?></td>
                                            <td><a href="<?php echo base_url() . 'compras/muestraCompraPdf/' . $compra['id']; ?>" class="btn btn-primary btn-icon-text"><i class="mdi mdi-file-pdf btn-icon-prepend"></i></a></td>
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
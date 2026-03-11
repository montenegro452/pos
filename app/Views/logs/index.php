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
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="MisTablas">
                                <thead>
                                    <tr>
                                        <th>
                                            Id
                                        </th>
                                        <th>
                                            Usuario
                                        </th>
                                        <th>
                                            Evento
                                        </th>
                                        <th>
                                            Fecha
                                        </th>
                                        <th>
                                            IP
                                        </th>
                                        <th>
                                            Detalles
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($datos as $dato) {
                                    ?>
                                        <tr>
                                            <td><?php echo $dato['id']; ?></td>
                                            <td><?php echo $dato['id_usuario']; ?></td>
                                            <td><?php echo $dato['evento']; ?></td>
                                            <?php $fecha = Time::parse($dato['fecha']); ?>
                                            <td><?php echo $fecha->format('d/m/Y H:i:s'); ?></td>
                                            <td><?php echo $dato['ip']; ?></td>
                                            <td><?php echo $dato['detalles']; ?></td>
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
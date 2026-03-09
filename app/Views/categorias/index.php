<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo $titulo ?></h4>
                        <div>
                            <p>
                                <a href="<?php echo base_url(); ?>categorias/nuevo" class="btn btn-primary btn-icon-text">
                                    <i class="mdi mdi-file-check btn-icon-prepend"></i>Agregar</a>
                                <a href="<?php echo base_url(); ?>categorias/eliminados" class="btn btn-dark btn-icon-text">
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
                                            Nombre
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
                                            <td><a href="<?php echo base_url() . 'categorias/editar/' . $dato['id']; ?>" class="btn btn-warning btn-icon-text"><i class="mdi mdi-lead-pencil btn-icon-prepend"></i>Editar</a></td>
                                            <td><a href="#" data-href="<?php echo base_url() . 'categorias/eliminar/' . $dato['id']; ?>"
                                                    data-confirm="¿Desea eliminar esta categoria?" data-confirm-title="Eliminar categoria"
                                                    class="btn btn-danger btn-icon-text"><i class="mdi mdi-window-close btn-icon-prepend"></i>Eliminar</a></td>
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
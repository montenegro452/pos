<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><?php

                                                use Faker\Provider\Base;

                                                echo $titulo ?></h4>
                        <?php if (isset($validation)) { ?>
                            <div class="alert alert-danger">
                                <?php echo $validation->listErrors(); ?>
                            </div>
                        <?php } ?>
                        <form method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>configuracion/actualizar">
                            <?php csrf_field(); ?>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <label>Nombre de la tienda</label>
                                        <input class="form-control" type="text" name="tienda_nombre" id="tienda_nombre" value="<?= $nombre['valor']; ?>">
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <label>Email de la tienda</label>
                                        <input class="form-control" type="text" name="tienda_email" id="tienda_email" value="<?= $email['valor']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <label>Telefono de la tienda</label>
                                        <input class="form-control" type="text" name="tienda_telefono" id="tienda_telefono" value="<?= $telefono['valor']; ?>">
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <label>Direcion de la tienda</label>
                                        <input class="form-control" type="text" name="tienda_direccion" id="tienda_direccion" value="<?= $direccion['valor']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <label for="tienda_leyenda">Leyenda del Ticket</label>
                                        <input class="form-control" name="tienda_leyenda"
                                            id="tienda_leyenda" value="<?= $leyenda['valor']; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <label>Logotipo</label>
                                        <br>
                                        <img src="<?= base_url('images/logo.png'); ?>" class="img-responsive" width="100" />
                                        <br>
                                        <input type="file" id="tienda_logo" name="tienda_logo" accept="image/png" />
                                        <p class="text-danger">Cargar imagen en formato png 150x150 pixeles.</p>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
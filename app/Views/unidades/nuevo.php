<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title"><?php echo $titulo ?></h4>
            <?php if (isset($validation)) { ?>
              <div class="alert alert-danger">
                <?php echo $validation->listErrors(); ?>
              </div>
            <?php } ?>
            <form method="POST" action="<?php echo base_url(); ?>unidades/insertar">
              <?php csrf_field(); ?>
              <div class="form-group">
                <div class="row">
                  <div class="col-12 col-sm-6">
                    <label>Nombre</label>
                    <input class="form-control" type="text" name="nombre" id="nombre">
                  </div>
                  <div class="col-12 col-sm-6">
                    <label>Nombre corto</label>
                    <input class="form-control" type="text" name="nombre_corto" id="nombre_corto">
                  </div>
                </div>
              </div>
              <a href="<?php echo base_url(); ?>unidades" class="btn btn-primary">Regresar</a>
              <button type="submit" class="btn btn-success">Guardar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
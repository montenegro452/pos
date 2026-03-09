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
            <form method="POST" action="<?php echo base_url(); ?>clientes/insertar" data-confirm="¿Desea guardar el nuevo cliente?" data-confirm-title="Guardar cliente">
              <input class="form-control" type="hidden" name="activo" id="activo" value="1">
              <div class="form-group">
                <div class="row">
                  <div class="col-12 col-sm-6">
                    <label>Nombre</label>
                    <input class="form-control" type="text" name="nombre" id="nombre">
                  </div>
                  <div class="col-12 col-sm-6">
                    <label>Direccion</label>
                    <input class="form-control" type="text" name="direccion" id="direccion">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-12 col-sm-6">
                    <label>Telefono</label>
                    <input class="form-control" type="text" name="telefono" id="telefono">
                  </div>
                  <div class="col-12 col-sm-6">
                    <label>Correo</label>
                    <input class="form-control" type="text" name="correo" id="correo">
                  </div>
                </div>
              </div>
              <a href="<?php echo base_url(); ?>clientes" class="btn btn-primary">Regresar</a>
              <button type="submit" class="btn btn-success">Guardar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
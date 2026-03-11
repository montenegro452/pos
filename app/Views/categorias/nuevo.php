<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title"><?php echo $titulo ?></h4>
            <form method="POST" action="<?php echo base_url(); ?>categorias/insertar" autocompletar="off" data-confirm="¿Desea guardar la nueva categoria?" data-confirm-title="Guardar categoria">
              <?php csrf_field(); ?>
              <div class="form-group">
                <div class="row">
                  <div class="col-12 col-sm-6">
                    <label>Nombre</label>
                    <input class="form-control" type="text" name="nombre" id="nombre" autofocus required>
                  </div>
                </div>
              </div>
              <a href="<?php echo base_url(); ?>categorias" class="mdi mdi-arrow-left btn btn-sm btn-primary btn-icon-text">Regresar</a>
              <button type="submit" class="mdi mdi-content-save btn btn-sm btn-success btn-icon-text">Guardar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> <!-- content-wrapper ends -->
</div>
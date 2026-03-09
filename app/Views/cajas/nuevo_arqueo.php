<?php

use CodeIgniter\I18n\Time;
?>
<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title"><?php echo $titulo ?></h4>
            <form method="POST" action="<?php echo base_url(); ?>cajas/nuevo_arqueo" autocompletar="off">
              <div class="form-group">
                <div class="row">
                  <div class="col-12 col-sm-6">
                    <label>Numero de caja</label>
                    <input class="form-control" type="text" name="numero_caja" id="numero_caja"
                      value="<?= isset($caja['numero_caja']) ? $caja['numero_caja'] : '' ?>" disabled autofocus required>
                  </div>
                  <div class="col-12 col-sm-6">
                    <label>Nombre</label>
                    <input class="form-control" type="text" name="nombre" id="nombre"
                      value="<?= isset($caja['nombre']) ? $caja['nombre'] : '' ?>" disabled autofocus required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-12 col-sm-6">
                    <label>Monto Inicial</label>
                    <input class="form-control" type="number" name="monto_inicial" id="monto_inicial"
                      value="<?= isset($caja['monto_inicial']) ? $caja['monto_inicial'] : '' ?>" autofocus required>
                  </div>
                  <div class="col-12 col-sm-6">
                    <label>Folio Inicial</label>
                    <input class="form-control" type="text" name="folio_inicial" id="folio_inicial"
                      value="<?= isset($caja['folio']) ? $caja['folio'] : '' ?>" autofocus required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-12 col-sm-6">
                    <label>Fecha</label>
                    <input class="form-control" type="date" name="fecha" id="fecha"
                      value="<?= date('Y-m-d'); ?>" autofocus required>
                  </div>
                  <div class="col-12 col-sm-6">
                    <label>Hora</label>
                    <input class="form-control" type="time" name="hora" id="hora"
                      value="<?= date('H:i:s'); ?>" autofocus required>
                  </div>
                </div>
              </div>
              <a href="<?= base_url(); ?>cajas" class="btn btn-primary">Regresar</a>
              <button type="submit" class="btn btn-success">Guardar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> <!-- content-wrapper ends -->
</div>
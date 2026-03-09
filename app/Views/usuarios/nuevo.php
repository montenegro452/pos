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
            <form method="POST" action="<?php echo base_url(); ?>usuarios/insertar">
              <?php csrf_field(); ?>
              <div class="form-group">
                <div class="row">
                  <div class="col-12 col-sm-6">
                    <label>Usuario</label>
                    <input class="form-control" type="text" name="usuario" id="usuario" value="<?= set_value('usuario'); ?>">
                  </div>
                  <div class="col-12 col-sm-6">
                    <label>Nombre</label>
                    <input class="form-control" type="text" name="nombre" id="nombre" value="<?= set_value('nombre'); ?>">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-12 col-sm-6">
                    <label>Password</label>
                    <input class="form-control" type="password" name="password" id="password" placeholder="Password">
                  </div>
                  <div class="col-12 col-sm-6">
                    <label>Confirmar Password</label>
                    <input class="form-control" type="password" name="repassword" id="repassword" placeholder="Confirmar Password">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-12 col-sm-6">
                    <label>Cajas</label>
                    <select class="form-control" id="id_caja" name="id_caja" required>
                      <option value="">Seleccionar caja</option>
                      <?php foreach ($cajas as $caja) { ?>
                        <option value="<?php echo $caja['id']; ?>"><?php echo $caja['nombre'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="col-12 col-sm-6">
                    <label>Roles</label>
                    <select class="form-control" id="id_rol" name="id_rol" required onchange="cargarPermisosRol(this.value)">
                      <option value="">Seleccionar rol</option>
                      <?php foreach ($roles as $rol) { ?>
                        <option value="<?php echo $rol['id']; ?>"><?php echo $rol['nombre'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label><strong>Permisos del Rol</strong></label>
                <div class="row" id="contenedor-permisos">
                  <?php if (!empty($permisos)) { ?>
                    <?php foreach ($permisos as $permiso) { ?>
                      <div class="col-12 col-sm-6 col-md-4 permiso-item" data-id-rol="">
                        <div class="form-check">
                          <input type="checkbox" class="form-check-input" id="permiso_<?php echo $permiso['id']; ?>"
                            name="permisos[]" value="<?php echo $permiso['id']; ?>">
                          <label class="form-check-label" for="permiso_<?php echo $permiso['id']; ?>">
                            <?php echo $permiso['descripcion']; ?>
                          </label>
                        </div>
                      </div>
                    <?php } ?>
                  <?php } else { ?>
                    <div class="col-12">
                      <p class="text-muted">No hay permisos disponibles</p>
                    </div>
                  <?php } ?>
                </div>
              </div>
              <a href="<?php echo base_url(); ?>usuarios" class="btn btn-primary">Regresar</a>
              <button type="submit" class="btn btn-success">Guardar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    function cargarPermisosRol(idRol) {
      const checkboxes = document.querySelectorAll('.form-check-input');

      if (!idRol) {
        checkboxes.forEach(checkbox => {
          checkbox.checked = false;
        });
        return;
      }

      fetch('<?= base_url('usuarios/obtenerPermisosRol') ?>', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: JSON.stringify({
            id_rol: idRol
          })
        })
        .then(response => response.json())
        .then(data => {
          checkboxes.forEach(checkbox => {
            checkbox.checked = false;
          });

          if (data.permisos && Array.isArray(data.permisos)) {
            data.permisos.forEach(permisoId => {
              const checkbox = document.getElementById('permiso_' + permisoId);
              if (checkbox) {
                checkbox.checked = true;
              }
            });
          }
        })
        .catch(error => console.error('Error:', error));
    }
  </script>
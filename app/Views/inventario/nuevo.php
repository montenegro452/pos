<?php
$id_compra = uniqid();
?>

<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <form method="POST" id="form_compra" name="form_compra" action="<?php echo base_url(); ?>compras/guarda">
              <div class="form-group">
                <div class="row">
                  <div class="col-12 col-sm-4">
                    <input type="hidden" id="id_producto" name="id_producto" />
                    <input type="hidden" id="id_compra" name="id_compra" value="<?php echo $id_compra; ?>" />
                    <label>Código</label>
                    <input class="form-control" type="text" name="codigo" id="codigo" autofocus
                      placeholder="Escribe el codigo y presiona Enter" onkeyup="buscarProducto(event, this, this.value)">
                    <label for="codigo" id="resultado_error" style="color: red;"></label>
                  </div>
                  <div class="col-12 col-sm-4">
                    <label>Nombre del producto</label>
                    <input class="form-control" type="text" name="nombre" id="nombre" disabled>
                  </div>
                  <div class="col-12 col-sm-4">
                    <label>Cantidad</label>
                    <input class="form-control" type="text" name="cantidad" id="cantidad">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-12 col-sm-4">
                    <label>Precio de compra</label>
                    <input class="form-control" type="text" name="precio_compra" id="precio_compra" disabled>
                  </div>
                  <div class="col-12 col-sm-4">
                    <label>Subtotal</label>
                    <input class="form-control" type="text" name="subtotal" id="subtotal" disabled>
                  </div>
                  <div class="col-12 col-sm-4">
                    <br>
                    <label><br>&nbsp;</label>
                    <button id="agregar_producto" name="agregar_producto" type="button" class="btn btn-sm btn-primary btn-icon-text"
                      onclick="agregarProducto(id_producto.value, cantidad.value, '<?php echo $id_compra; ?>')">
                      <i class="mdi mdi-cart-plus btn-icon-prepend"></i>Agregar Producto</button>
                  </div>
                </div>
              </div>
              <div class="row">
                <table id="tablaProductos" class="table table-hover table-striped table-sm table-resposive tablaProductos" width="100%">
                  <thead class="thead-dark">
                    <th>#</th>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th width="1%"></th>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6 offset-md-6">
                  <label style="font-weight: bold; font-size: 30px; text-align: center;">Total $</label>
                  <input type="text" id="total" name="total" size="7" readonly="true" value="0.00"
                    style="font-weight: bold; font-size: 30px; text-align: center;" />
                  <button type="button" id="completa_compra" class="btn btn-sm btn-success btn-icon-text"><i class="mdi mdi-cart btn-icon-prepend"></i>Completar Compra</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      $("#completa_compra").click(function() {
        let nFilas = $("#tablaProductos tbody tr").length;
        if (nFilas > 0) {
          $("#form_compra").submit();
        } else {
          Swal.fire({
            title: 'Error',
            text: 'Agrega al menos un producto a la compra',
            icon: 'error',
            confirmButtonText: 'OK'
          });
        }
      });
    });

    function buscarProducto(e, tagCodigo, codigo) {
      var enterKey = 13;

      if (codigo != '') {
        if (e.which == enterKey) {
          $.ajax({
            url: '<?= base_url(); ?>productos/buscarPorCodigo/' + codigo,
            dataType: 'json',
            success: function(resultado) {
              if (resultado == 0) {
                $(tagCodigo).val('');
              } else {
                $("#resultado_error").html(resultado.error);

                if (resultado.existe) {
                  $("#resultado_error").html('');
                  $("#id_producto").val(resultado.datos.id);
                  $("#nombre").val(resultado.datos.nombre);
                  $("#cantidad").val(1);
                  $("#precio_compra").val(resultado.datos.precio_compra);
                  $("#subtotal").val(resultado.datos.precio_compra);
                  $("#cantidad").focus();
                } else {
                  $("#id_producto").val('');
                  $("#nombre").val('');
                  $("#cantidad").val('');
                  $("#precio_compra").val('');
                  $("#subtotal").val('');
                }
              }
            }
          });
        }
      }
    }

    function agregarProducto(id_producto, cantidad, id_compra) {
      if (id_producto != null && id_producto != 0 && cantidad > 0) {
        $.ajax({
          url: '<?= base_url(); ?>TemporalCompra/inserta/' + id_producto + '/' + cantidad + '/' + id_compra,
          success: function(resultado) {
            if (resultado == 0) {

            } else {
              var data = JSON.parse(resultado);
              if (data.error == '') {
                $("#tablaProductos tbody").empty();
                $("#tablaProductos tbody").append(data.datos);
                $("#total").val(data.total);
                $("#id_producto").val('');
                $("#nombre").val('');
                $("#codigo").val('');
                $("#cantidad").val('');
                $("#precio_compra").val('');
                $("#subtotal").val('');
              }
            }
          }
        });
      }
    }

    function eliminaProducto(id_producto, id_compra) {
      $.ajax({
        url: '<?= base_url(); ?>elimina/' + id_producto + '/' + id_compra,
        success: function(resultado) {
          var data = JSON.parse(resultado);
          if (data.error == '') {
            $("#tablaProductos tbody").empty();
            $("#tablaProductos tbody").append(data.datos);
            $("#total").val(data.total);
          }
        }
      });
    }
  </script>
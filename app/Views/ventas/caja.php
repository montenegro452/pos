<?php $idVentaTemp = uniqid(); ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo $titulo ?></h4>
                        <form id="form_venta" name="form_venta" class="form-horizontal" method="POST" action="<?php echo base_url(); ?>ventas/guarda" autocomplete="off">
                            <input type="hidden" id="id_venta" name="id_venta" value="<?= $idVentaTemp; ?>" />
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="ui-widget">
                                            <label>Cliente:</label>
                                            <input type="hidden" id="id_cliente" name="id_cliente" value="" />
                                            <input type="text" class="form-control" id="cliente"
                                                placeholder="Escribe el nombre del cliente" value=""
                                                onkeyup="" autocomplete="off" required />
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <label>Forma de Pago:</label>
                                        <select id="forma_pago" name="forma_pago" class="form-control" required>
                                            <option value="001">Efectivo</option>
                                            <option value="002">Transferencia</option>
                                            <option value="003">Divisa</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12 col-sm-4">
                                        <input type="hidden" id="id_producto" name="id_producto" />
                                        <label>Código de barras:</label>
                                        <input class="form-control" type="text" name="codigo" id="codigo" autofocus
                                            placeholder="Escribe el codigo" onkeyup="agregarProducto(event, this.value, 1, '<?= $idVentaTemp; ?>')" />
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="codigo" id="resultado_error" style="color: red"></label>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <label style="font-weight: bold; font-size: 30px; text-align: center;">Total $</label>
                                        <input type="text" id="total" name="total" size="7" readonly="true" value="0.00"
                                            style="font-weight: bold; font-size: 30px; text-align: center;" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="button" id="completa_venta" class="btn btn-success btn-icon-text">
                                    <i class="mdi mdi-cart btn-icon-prepend"></i>Completar Venta</button>
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
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $("#cliente").autocomplete({
                source: "<?= base_url(); ?>clientes/autocompleteData",
                minLength: 3,
                select: function(event, ui) {
                    event.preventDefault();
                    $("#id_cliente").val(ui.item.id);
                    $("#cliente").val(ui.item.value);
                    // Limpiar tabla de productos al cambiar de cliente
                    $("#tablaProductos tbody").empty();
                    $("#total").val("0.00");
                    $("#codigo").focus();
                }
            });
        });

        $(function() {
            $("#codigo").autocomplete({
                source: "<?= base_url(); ?>productos/autocompleteData",
                minLength: 1,
                select: function(event, ui) {
                    event.preventDefault();
                    $("#codigo").val(ui.item.value);
                    setTimeout(
                        function() {
                            e = jQuery.Event("keypress");
                            e.which = 13;
                            agregarProducto(e, ui.item.id, 1, '<?= $idVentaTemp; ?>');
                        }
                    )
                }
            });
        });

        function agregarProducto(e, id_producto, cantidad, id_venta) {
            let enterKey = 13;
            let codigo = $('#codigo').val();
            if (codigo != '') {
                if (e.which == enterKey) {
                    if (id_producto != null && id_producto != 0 && cantidad > 0) {
                        $.ajax({
                            url: '<?= base_url(); ?>TemporalVenta/inserta/' + id_producto + '/' + cantidad + '/' + id_venta,
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
                                        $("#precio_venta").val('');
                                        $("#subtotal").val('');
                                    }
                                }
                            }
                        });
                    }
                }
            }
        }

        function eliminaProducto(id_producto, id_venta) {
            $.ajax({
                url: '<?= base_url(); ?>TemporalVenta/elimina/' + id_producto + '/' + id_venta,
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

        $(function() {
            $("#completa_venta").click(function() {
                let nFilas = $("#tablaProductos tr").length;
                if (nFilas < 2) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Agrega al menos un producto a la venta',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                } else {
                    $("#form_venta").submit();
                }
            });
        });
    </script>
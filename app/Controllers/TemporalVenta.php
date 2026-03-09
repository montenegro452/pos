<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TemporalVentaModel;
use App\Models\ProductosModel;

class TemporalVenta extends BaseController
{
    protected $temporal_venta, $productos;

    public function __construct()
    {
        $this->temporal_venta = new TemporalVentaModel();
        $this->productos = new ProductosModel();
    }

    public function inserta($id_producto, $cantidad, $id_venta)
    {
        // Verificar permiso
        helper('permisos');
        if (!tienePermiso('ventas_agregar')) {
            session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Ventas');
            return redirect()->to(base_url('dashboard'));
        }
        $error = "";

        $producto = $this->productos->where('id', $id_producto)->first();

        if ($producto) {
            $datosExiste = $this->temporal_venta->porIdProductoVenta($id_producto, $id_venta);
            if ($datosExiste) {
                $cantidad = $datosExiste->cantidad + $cantidad;
                $subtotal = $cantidad * floatval(str_replace(',', '.', $datosExiste->precio));
                if (!$this->temporal_venta->update($datosExiste->id, [
                    'cantidad' => $cantidad,
                    'subtotal' => $subtotal
                ])) {
                    $error = "Error al actualizar el producto.";
                }
            } else {
                $subtotal = $cantidad * floatval(str_replace(',', '.', $producto['precio_venta']));

                if (!$this->temporal_venta->save([
                    'folio' => $id_venta,
                    'id_producto' => $id_producto,
                    'codigo' => $producto['codigo'],
                    'nombre' => $producto['nombre'],
                    'cantidad' => $cantidad,
                    'precio' => $producto['precio_venta'],
                    'subtotal' => $subtotal
                ])) {
                    $error = "Error al guardar el producto.";
                }
            }
        } else {
            $error = "El producto no existe.";
        }
        $res = ['datos' => $this->cargaProductos($id_venta)];
        $res['total'] = number_format($this->totalProductos($id_venta), 2, '.', ',');
        $res['error'] = $error;
        echo json_encode($res);
    }

    public function cargaProductos($id_venta)
    {
        $resultado = $this->temporal_venta->porVenta($id_venta);
        $fila = '';
        $numFila = 0;

        foreach ($resultado as $row) {
            $numFila++;
            $precio = floatval(str_replace(',', '.', $row['precio']));
            $subtotal = floatval(str_replace(',', '.', $row['subtotal']));
            $fila .= "<tr id='fila" . $numFila . "'>";
            $fila .= "<td>" . $numFila . "</td>";
            $fila .= "<td>" . $row['codigo'] . "</td>";
            $fila .= "<td>" . $row['nombre'] . "</td>";
            $fila .= "<td>$" . number_format($precio, 2) . "</td>";
            $fila .= "<td>" . $row['cantidad'] . "</td>";
            $fila .= "<td>$" . number_format($subtotal, 2) . "</td>";
            $fila .= "<td><a onclick=\"eliminaProducto(" . $row['id_producto'] . ", '" . $id_venta . "')\" class='borrar'>
            <span class='mdi mdi-trash-can btn-icon-prepend'></span></a></td>";
            $fila .= "</tr>";
        }
        return $fila;
    }

    public function totalProductos($id_venta)
    {
        $resultado = $this->temporal_venta->porVenta($id_venta);
        $total = 0;

        foreach ($resultado as $row) {
            $total += $row['subtotal'];
        }
        return $total;
    }

    public function elimina($id_producto, $id_venta)
    {
        // Verificar permiso
        helper('permisos');
        if (!tienePermiso('ventas_eliminar')) {
            session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Ventas');
            return redirect()->to(base_url('dashboard'));
        }
        $error = "";

        $datosExiste = $this->temporal_venta->porIdProductoVenta($id_producto, $id_venta);
        if ($datosExiste) {
            if (!$this->temporal_venta->delete($datosExiste->id)) {
                $error = "Error al eliminar el producto.";
            }
        } else {
            $error = "El producto no existe en la venta.";
        }
        $res = ['datos' => $this->cargaProductos($id_venta)];
        $res['total'] = number_format($this->totalProductos($id_venta), 2, '.', ',');
        $res['error'] = $error;
        echo json_encode($res);
    }
}

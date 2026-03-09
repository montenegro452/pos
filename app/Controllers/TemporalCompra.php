<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TemporalCompraModel;
use App\Models\ProductosModel;

class TemporalCompra extends BaseController
{
    protected $temporal_compra, $productos;

    public function __construct()
    {
        $this->temporal_compra = new TemporalCompraModel();
        $this->productos = new ProductosModel();
    }

    public function inserta($id_producto, $cantidad, $id_compra)
    {
        // Verificar permiso
        helper('permisos');
        if (!tienePermiso('compras_ver')) {
            session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Compras');
            return redirect()->to(base_url('dashboard'));
        }
        $error = "";

        $producto = $this->productos->where('id', $id_producto)->first();

        if ($producto) {
            $datosExiste = $this->temporal_compra->porIdProductoCompra($id_producto, $id_compra);
            if ($datosExiste) {
                $cantidad = $datosExiste->cantidad + $cantidad;
                $subtotal = $cantidad * floatval(str_replace(',', '.', $datosExiste->precio));
                if (!$this->temporal_compra->update($datosExiste->id, [
                    'cantidad' => $cantidad,
                    'subtotal' => $subtotal
                ])) {
                    $error = "Error al actualizar el producto.";
                }
            } else {
                $subtotal = $cantidad * floatval(str_replace(',', '.', $producto['precio_compra']));

                if (!$this->temporal_compra->save([
                    'folio' => $id_compra,
                    'id_producto' => $id_producto,
                    'codigo' => $producto['codigo'],
                    'nombre' => $producto['nombre'],
                    'cantidad' => $cantidad,
                    'precio' => $producto['precio_compra'],
                    'subtotal' => $subtotal
                ])) {
                    $error = "Error al guardar el producto.";
                }
            }
        } else {
            $error = "El producto no existe.";
        }
        $res = ['datos' => $this->cargaProductos($id_compra)];
        $res['total'] = number_format($this->totalProductos($id_compra), 2, '.', ',');
        $res['error'] = $error;
        echo json_encode($res);
    }

    public function cargaProductos($id_compra)
    {
        $resultado = $this->temporal_compra->porCompra($id_compra);
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
            $fila .= "<td><a onclick=\"eliminaProducto(" . $row['id_producto'] . ", '" . $id_compra . "')\" class='borrar'>
            <span class='mdi mdi-trash-can btn-icon-prepend'></span></a></td>";
            $fila .= "</tr>";
        }
        return $fila;
    }

    public function totalProductos($id_compra)
    {
        $resultado = $this->temporal_compra->porCompra($id_compra);
        $total = 0;

        foreach ($resultado as $row) {
            $total += $row['subtotal'];
        }
        return $total;
    }

    public function elimina($id_producto, $id_compra)
    {
        // Verificar permiso
        helper('permisos');
        if (!tienePermiso('compras_eliminar')) {
            session()->setFlashdata('msg_acceso', 'No tienes permiso para el modulo Compras');
            return redirect()->to(base_url('dashboard'));
        }
        $error = "";

        $datosExiste = $this->temporal_compra->porIdProductoCompra($id_producto, $id_compra);
        if ($datosExiste) {
            if (!$this->temporal_compra->delete($datosExiste->id)) {
                $error = "Error al eliminar el producto.";
            }
        } else {
            $error = "El producto no existe en la compra.";
        }
        $res = ['datos' => $this->cargaProductos($id_compra)];
        $res['total'] = number_format($this->totalProductos($id_compra), 2, '.', ',');
        $res['error'] = $error;
        echo json_encode($res);
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class TemporalCompraModel extends Model
{
	protected $table      = 'temporal_compra';
	protected $primaryKey = 'id';

	protected $useAutoIncrement = true;

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['folio', 'id_producto', 'codigo', 'nombre', 'cantidad', 'precio', 'subtotal'];

	protected $useTimestamps = false;
	protected $createdField  = 'fecha_alta';
	protected $updatedField  = 'fecha_edit';
	protected $deletedField  = 'deleted_at';

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = false;

	public function porIdProductoCompra($id_producto, $folio)
	{
		$this->select('*');
		$this->where('id_producto', $id_producto);
		$this->where('folio', $folio);
		$this->where('id_producto', $id_producto);
		$datos = $this->get()->getRow();
		return $datos;
	}

	public function porCompra($folio)
	{
		$this->select('*');
		$this->where('folio', $folio);
		$datos = $this->findAll();
		return $datos;
	}

	public function eliminarProductoCompra($id_producto, $id_compra)
	{
		$datosExiste = $this->temporal_compra->porIdProductoCompra($id_producto, $id_compra);

		if($datosExiste){
			if($datosExiste->cantidad > 1){
				$cantidad = $datosExiste->cantidad - 1;
				$subtotal = $cantidad * floatval(str_replace(',', '.', $datosExiste->precio));
				return $this->update($datosExiste->id, [
					'cantidad' => $cantidad,
					'subtotal' => $subtotal
				]);
			} else {
				return $this->delete($datosExiste->id);
			}
		}
		$res = ['datos' => $this->cargaProductos($id_compra)];
        $res['total'] = number_format($this->totalProductos($id_compra), 2, '.', ',');
        $res['error'] = '';
        echo json_encode($res);
	}

	public function eliminaCompra($folio)
	{
		return $this->where('folio', $folio)->delete();
	}
}

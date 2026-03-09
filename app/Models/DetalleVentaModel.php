<?php

namespace App\Models;

use CodeIgniter\Model;

class DetalleVentaModel extends Model
{
	protected $table      = 'detalle_venta';
	protected $primaryKey = 'id';

	protected $useAutoIncrement = true;

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['id_venta', 'id_producto', 'nombre', 'cantidad', 'precio'];

	protected $useTimestamps = true;
	protected $createdField  = 'fecha_alta';
	protected $updatedField  = '';

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = false;

	public function insertaVenta($id_venta, $id_producto, $nombre, $cantidad, $precio)
	{
		$this->insert([
			'id_venta' => $id_venta,
			'id_producto' => $id_producto,
			'nombre' => $nombre,
			'cantidad' => $cantidad,
			'precio' => $precio
		]);

		return $this->insertID();
	}

	public function totalProductosVendidos()
	{
		return $this->selectSum('cantidad')->get()->getRow()->cantidad ?? 0;
	}
}

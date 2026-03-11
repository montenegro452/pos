<?php

namespace App\Models;

use CodeIgniter\Model;

class InventarioModel extends Model
{
	protected $table      = 'inventario';
	protected $primaryKey = 'id';

	protected $useAutoIncrement = true;

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['folio', 'total', 'id_usuario', 'activo', 'id_producto', 'movimiento'];

	protected $useTimestamps = false;
	protected $createdField  = 'fecha_alta';
	protected $updatedField  = false;

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = false;

	public function insertaCompra($id_compra, $total, $id_usuario)
	{
		$this->insert([
			'folio' => $id_compra,
			'total' => $total,
			'id_usuario' => $id_usuario
		]);
		return $this->insertID();
	}
}

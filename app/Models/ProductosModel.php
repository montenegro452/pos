<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductosModel extends Model
{
	protected $table      = 'productos';
	protected $primaryKey = 'id';


	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = [
		'codigo',
		'nombre',
		'precio_venta',
		'precio_compra',
		'existencias',
		'stock_minimo',
		'inventariable',
		'id_unidad',
		'id_categoria',
		'activo',
		'foto'
	];

	protected $useTimestamps = true;
	protected $createdField  = 'fecha_alta';
	protected $updatedField  = 'fecha_modifica';
	protected $deletedField  = 'deleted_at';

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = false;

	public function actualizarStock($id_producto, $cantidad, $operador = '+')
	{
		$this->set('existencias', "existencias $operador $cantidad", FALSE);
		$this->where('id', $id_producto);
		$this->update();
	}

	public function totalProductos()
	{
		return $this->countAllResults();
	}

	public function productoMinimo()
	{
		$consulta = "stock_minimo >= existencias AND inventariable = 1 AND activo = 1";
		$this->where($consulta);
		$sql = $this->countAllResults();
		return $sql;
	}

	public function getproductoMinimo()
	{
		$consulta = "stock_minimo >= existencias AND inventariable = 1 AND activo = 1";
		return $this->where($consulta)->findAll();
	}
}

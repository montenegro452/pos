<?php

namespace App\Models;

use CodeIgniter\Model;

class VentasModel extends Model
{
	protected $table      = 'ventas';
	protected $primaryKey = 'id';

	protected $useAutoIncrement = true;

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['folio', 'total', 'id_usuario', 'id_caja', 'id_cliente', 'forma_pago', 'activo'];

	protected $useTimestamps = true;
	protected $createdField  = 'fecha_alta';
	protected $updatedField  = '';

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = false;

	public function insertaVenta($folio, $total, $id_usuario, $id_caja, $id_cliente, $forma_pago)
	{
		$this->insert([
			'folio' => $folio,
			'total' => $total,
			'id_usuario' => $id_usuario,
			'id_caja' => $id_caja,
			'id_cliente' => $id_cliente,
			'forma_pago' => $forma_pago
		]);

		return $this->insertID();
	}

	public function obtener($activo = 1)
	{
		$this->select('ventas.*, u.usuario AS cajero, c.nombre AS cliente');
		$this->join('usuarios AS u', 'ventas.id_usuario = u.id');
		$this->join('clientes AS c', 'ventas.id_cliente = c.id');
		$this->where('ventas.activo', $activo);
		$this->orderBy('ventas.fecha_alta', 'DESC');
		$datos = $this->findAll();
		return $datos;
	}

	public function totalDia($fecha)
	{
		return $this->where('activo', 1)
			->where("DATE(fecha_alta) = ", $fecha)
			->countAllResults();
	}

	/**
	 * Cuenta la cantidad de ventas de un mes específico.
	 *
	 * @param int|string $year Año (ej. 2026)
	 * @param int|string $month Mes (1-12, con cero inicial si lo desea)
	 * @return int Número de registros que coinciden
	 */
	public function totalMes($year, $month)
	{
		// asegurarnos de tener dos dígitos para el mes
		$month = str_pad($month, 2, '0', STR_PAD_LEFT);
		return $this->where('activo', 1)
			->where("YEAR(fecha_alta) = ", $year)
			->where("MONTH(fecha_alta) = ", $month)
			->countAllResults();
	}
}

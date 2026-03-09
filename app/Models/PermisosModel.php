<?php

namespace App\Models;

use CodeIgniter\Model;

class PermisosModel extends Model
{
    protected $table      = 'permisos';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre', 'descripcion', 'activo'];

    protected $useTimestamps = false;
    protected $createdField  = 'fecha_alta';
    protected $updatedField  = 'fecha_edit';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    // Obtener permisos por rol
    public function getPermisosPorRol($id_rol)
    {
        $builder = $this->db->table('roles_permisos rp');
        $builder->select('p.*');
        $builder->join('permisos p', 'rp.id_permiso = p.id');
        $builder->where('rp.id_rol', $id_rol);
        $builder->where('p.activo', 1);
        return $builder->get()->getResultArray();
    }

    // Verificar si un rol tiene un permiso específico
    public function tienePermiso($id_rol, $nombre_permiso)
    {
        $builder = $this->db->table('roles_permisos rp');
        $builder->select('p.*');
        $builder->join('permisos p', 'rp.id_permiso = p.id');
        $builder->where('rp.id_rol', $id_rol);
        $builder->where('p.nombre', $nombre_permiso);
        $builder->where('p.activo', 1);
        $result = $builder->get()->getRow();
        return $result != null;
    }
}

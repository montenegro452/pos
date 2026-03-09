<?php

namespace App\Models;

use CodeIgniter\Model;

class RolesPermisosModel extends Model
{
    protected $table      = 'roles_permisos';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_rol', 'id_permiso'];

    protected $useTimestamps = false;
    protected $createdField  = 'fecha_alta';
    protected $updatedField  = 'fecha_edit';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    // Guardar permisos para un rol
    public function guardarPermisosRol($id_rol, $permisos)
    {
        // Eliminar permisos actuales del rol
        $this->where('id_rol', $id_rol)->delete();

        // Insertar nuevos permisos
        $data = [];
        foreach ($permisos as $id_permiso) {
            $data[] = [
                'id_rol' => $id_rol,
                'id_permiso' => $id_permiso,
                'fecha_alta' => date('Y-m-d H:i:s')
            ];
        }

        return $this->insertBatch($data);
    }

    // Obtener permisos de un rol
    public function getPermisosRol($id_rol)
    {
        return $this->where('id_rol', $id_rol)->findAll();
    }
}

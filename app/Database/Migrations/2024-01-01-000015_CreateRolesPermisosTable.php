<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRolesPermisosTable extends Migration
{
    public function up()
    {
        // Asignar permisos por defecto al rol de Administrador (id_rol = 1)
        $permisosAdministrador = [];
        for ($i = 1; $i <= 34; $i++) {
            $permisosAdministrador[] = [
                'id_rol' => 1,
                'id_permiso' => $i,
                'fecha_alta' => date('Y-m-d H:i:s')
            ];
        }
        $this->db->table('roles_permisos')->insertBatch($permisosAdministrador);

        // Asignar permisos básicos al rol de Vendedor (id_rol = 2)
        $permisosVendedor = [
            ['id_rol' => 2, 'id_permiso' => 9, 'fecha_alta' => date('Y-m-d H:i:s')],  // ventas_ver
            ['id_rol' => 2, 'id_permiso' => 10, 'fecha_alta' => date('Y-m-d H:i:s')], // ventas_agregar
            ['id_rol' => 2, 'id_permiso' => 15, 'fecha_alta' => date('Y-m-d H:i:s')], // productos_ver
            ['id_rol' => 2, 'id_permiso' => 23, 'fecha_alta' => date('Y-m-d H:i:s')], // clientes_ver
            ['id_rol' => 2, 'id_permiso' => 24, 'fecha_alta' => date('Y-m-d H:i:s')], // clientes_agregar
        ];
        $this->db->table('roles_permisos')->insertBatch($permisosVendedor);

        // Asignar permisos básicos al rol de Almacenista (id_rol = 3)
        $permisosAlmacenista = [
            ['id_rol' => 3, 'id_permiso' => 12, 'fecha_alta' => date('Y-m-d H:i:s')], // compras_ver
            ['id_rol' => 3, 'id_permiso' => 13, 'fecha_alta' => date('Y-m-d H:i:s')], // compras_agregar
            ['id_rol' => 3, 'id_permiso' => 15, 'fecha_alta' => date('Y-m-d H:i:s')], // productos_ver
            ['id_rol' => 3, 'id_permiso' => 16, 'fecha_alta' => date('Y-m-d H:i:s')], // productos_agregar
            ['id_rol' => 3, 'id_permiso' => 17, 'fecha_alta' => date('Y-m-d H:i:s')], // productos_editar
            ['id_rol' => 3, 'id_permiso' => 19, 'fecha_alta' => date('Y-m-d H:i:s')], // categorias_ver
            ['id_rol' => 3, 'id_permiso' => 20, 'fecha_alta' => date('Y-m-d H:i:s')], // categorias_agregar
            ['id_rol' => 3, 'id_permiso' => 21, 'fecha_alta' => date('Y-m-d H:i:s')], // categorias_editar
        ];
        $this->db->table('roles_permisos')->insertBatch($permisosAlmacenista);
    }

    public function down()
    {
        $this->forge->dropTable('roles_permisos');
    }
}

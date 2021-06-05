<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Array de permisos
        $permission = array('Administracion',
                            'Usuarios',
                            'Roles',
                            'Permisos',
                            'bitacora',
                            'Actividades',
                            'Tecnicos',
                            'Clientes',
                            'index_cliente',
                            'create_cliente',
                            'edit_cliente',
                            'destroy_cliente',
                            'Configuracion',
                            'Ordenes',
                            'create_orden',
                            'edit_orden',
                            'destroy_orden');

        //creando rol administrador
        $rol_admin = Role::create(['name' => 'Administrador']);
        
        //creando los permisos 
        foreach ($permission as $value) {
            Permission::create(['name' => $value]);
        }

        //asignando los permisos al rol administrador
        $rol_admin->givePermissionTo('Administracion');
        $rol_admin->givePermissionTo('Roles');

        //Asignando rol administrador al primer usuario creado
        $user=User::find(1);
        $user->assignRole('Administrador');


    }
}

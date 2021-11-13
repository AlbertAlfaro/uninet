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
        $permission = array(
                            'Administracion',
                            'Configuracion',
                            'Clientes',
                            'Abonos',
                            'Reportes',
                            'Facturacion',
                            'Productos',
                            'Usuarios',
                            'Roles',
                            'Permisos',
                            'bitacora',
                            'Actividades',
                            'Tecnicos',
                            'Correlativo',
                            'correlativo_edit',
                            'Cobradores',
                            'create_cobrador',
                            'edit_cobrador',
                            'destroy_cobrador',
                            'Sucursales',
                            'create_sucursal',
                            'edit_sucursal',
                            'destroy_sucursal',
                            'Velocidades',
                            'create_velocidad',
                            'edit_velocidad',
                            'destroy_velocidad',
                            'index_cliente',
                            'create_cliente',
                            'edit_cliente',
                            'destroy_cliente',
                            'contrato_cliente',
                            'contrato_activo',
                            'contrato_vista',
                            'contrato_create',
                            'contrato_store',
                            'Ordenes',
                            'create_orden',
                            'edit_orden',
                            'destroy_orden',
                            'Suspensiones',
                            'create_suspension',
                            'edit_suspension',
                            'destroy_suspension',
                            'Reconexiones',
                            'create_reconexion',
                            'edit_reconexion',
                            'destroy_reconexion',
                            'Traslados',
                            'create_traslado',
                            'edit_traslado',
                            'destroy_traslado',
                            'estado_cuenta',
                            'estado_cuenta_pdf',
                            'abonos_pendientes',
                            'abonos_pendientes_pdf',
                            'reporte_cliente',
                            'destroy_factura',
                            'create_producto',
                            'edit_producto',
                            'destroy_producto',
                            'backup',
                            'reporte_factura',
                            'anular_factura',
                            'carga_datos',
                            'gen_cargo_cliente'
                        );

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

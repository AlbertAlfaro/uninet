<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
//use Illuminate\Support\Facades\DB;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usuario= new User();
        $usuario->id_rol="1";
        $usuario->name="admin";
        $usuario->email="admin@admin.com";
        $usuario->password='$2y$10$ts5B2Rloa7RX5KNjbO1T7uTNbqbHDswybaA4/ZNd1z5N9xMkZJIUK';
        $usuario->id_sucursal="1";
        $usuario->save();
        
        
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departamentos = array(
                                'Ahuachapán',
                                'Cabañas',
                                'Chalatenango',
                                'Cuscatlán',
                                'La Libertad',
                                'La Paz',
                                'La Unión',
                                'Morazán',
                                'San Miguel',
                                'San Salvador',
                                'San Vicente',
                                'Santa Ana',
                                'Sonsonate',
                                'Usulután',
                                
        );
        foreach ($departamentos as $value) {
            
            DB::table('departamentos')->insert([
                'nombre' => $value
            ]);

        }
    }
}

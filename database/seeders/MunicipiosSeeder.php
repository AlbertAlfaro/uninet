<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MunicipiosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $municipios = array(
                            'Ahuachapán',
                            'Apaneca',
                            'Atiquizaya',
                            'Concepción de Ataco',
                            'El Refugio',
                            'Guaymango',
                            'Jujutla',
                            'San Francisco Menéndez',
                            'San Lorenzo',
                            'San Pedro Puxtla',
                            'Tacuba',
                            'Turín',
                            
                            'Cinquera',
                            'Dolores',
                            'Guacotecti',
                            'Ilobasco',
                            'Jutiapa',
                            'San Isidro',
                            'Sensuntepeque',
                            'Tejutepeque',
                            'Victoria',

                            'Agua Caliente',
                            'Arcatao',
                            'Azacualpa',
                            'Chalatenango',
                            'Citalá',
                            'Comalapa',
                            'Concepción Quezaltepeque',
                            'Dulce Nombre de María',
                            'El Carrizal',
                            'El Paraíso',
                            'La Laguna',
                            'La Palma',
                            'La Reina',
                            'Las Vueltas',
                            'Nombre de Jesús',
                            'Nueva Concepción',
                            'Nueva Trinidad',
                            'Ojos de Agua',
                            'Potonico',
                            'San Antonio de la Cruz',
                            'San Antonio Los Ranchos',
                            'San Fernando',
                            'San Francisco Lempa',
                            'San Francisco Morazán',
                            'San Ignacio',
                            'San Isidro Labrador',
                            'San José Cancasque',
                            'San José Las Flores',
                            'San Luis del Carmen',
                            'San Miguel de Mercedes',
                            'San Rafael',
                            'Santa Rita',
                            'Tejutla',

                            'Candelaria',
                            'Cojutepeque',
                            'El Carmen',
                            'El Rosario',
                            'Monte San Juan',
                            'Oratorio de Concepción',
                            'San Bartolomé Perulapía',
                            'San Cristóbal',
                            'San José Guayabal',
                            'San Pedro Perulapán',
                            'San Rafael Cedros',
                            'San Ramón',
                            'Santa Cruz Analquito',
                            'Santa Cruz Michapa',
                            'Suchitoto',
                            'Tenancingo',

                            'Antiguo Cuscatlán',
                            'Chiltiupán',
                            'Ciudad Arce',
                            'Colón',
                            'Comasagua',
                            'Huizúcar',
                            'Jayaque',
                            'Jicalapa',
                            'La Libertad',
                            'Nuevo Cuscatlán',
                            'Opico',
                            'Quezaltepeque',
                            'Sacacoyo',
                            'San José Villanueva',
                            'San Matías',
                            'San Pablo Tacachico',
                            'Santa Tecla',
                            'Talnique',
                            'Tamanique',
                            'Teotepeque',
                            'Tepecoyo',
                            'Zaragoza',

                            'Cuyultitán',
                            'El Rosario',
                            'Jerusalén',
                            'Mercedes La Ceiba',
                            'Olocuilta',
                            'Paraíso de Osorio',
                            'San Antonio Masahuat',
                            'San Emigdio',
                            'San Francisco Chinameca',
                            'San Juan Nonualco',
                            'San Juan Talpa',
                            'San Juan Tepezontes',
                            'San Luis La Herradura',
                            'San Luis Talpa',
                            'San Miguel Tepezontes',
                            'San Pedro Masahuat',
                            'San Pedro Nonualco',
                            'San Rafael Obrajuelo',
                            'Santa María Ostuma',
                            'Santiago Nonualco',
                            'Tapalhuaca',
                            'Zacatecoluca',

                            'Anamorós',
                            'Bolívar',
                            'Concepción de Oriente',
                            'Conchagua',
                            'El Carmen',
                            'El Sauce',
                            'Intipucá',
                            'La Unión',
                            'Lislique',
                            'Meanguera del Golfo',
                            'Nueva Esparta',
                            'Pasaquina',
                            'Polorós',
                            'San Alejo',
                            'San José',
                            'Santa Rosa de Lima',
                            'Yayantique',
                            'Yucuaiquín',

                            'Arambala',
                            'Cacaopera',
                            'Chilanga',
                            'Corinto',
                            'Delicias de Concepción',
                            'El Divisadero',
                            'El Rosario',
                            'Gualococti',
                            'Guatajiagua',
                            'Joateca',
                            'Jocoaitique',
                            'Jocoro',
                            'Lolotiquillo',
                            'Meanguera',
                            'Osicala',
                            'Perquín',
                            'San Carlos',
                            'San Fernando',
                            'San Francisco Gotera',
                            'San Isidro',
                            'San Simón',
                            'Sensembra',
                            'Sociedad',
                            'Torola',
                            'Yamabal',
                            'Yoloaiquín',

                            'Carolina',
                            'Chapeltique',
                            'Chinameca',
                            'Chirilagua',
                            'Ciudad Barrios',
                            'Comacarán',
                            'El Tránsito',
                            'Lolotique',
                            'Moncagua',
                            'Nueva Guadalupe',
                            'Nuevo Edén de San Juan',
                            'Quelepa',
                            'San Antonio',
                            'San Gerardo',
                            'San Jorge',
                            'San Luis de la Reina',
                            'San Miguel',
                            'San Rafael Oriente',
                            'Sesori',
                            'Uluazapa',

                            'Aguilares',
                            'Apopa',
                            'Ayutuxtepeque',
                            'Cuscatancingo',
                            'Delgado',
                            'El Paisnal',
                            'Guazapa',
                            'Ilopango',
                            'Mejicanos',
                            'Nejapa',
                            'Panchimalco',
                            'Rosario de Mora',
                            'San Marcos',
                            'San Martín',
                            'San Salvador',
                            'Santiago Texacuangos',
                            'Santo Tomás',
                            'Soyapango',
                            'Tonacatepeque',

                            'Apastepeque',
                            'Guadalupe',
                            'San Cayetano Istepeque',
                            'San Esteban Catarina',
                            'San Ildefonso',
                            'San Lorenzo',
                            'San Sebastián',
                            'San Vicente',
                            'Santa Clara',
                            'Santo Domingo',
                            'Tecoluca',
                            'Tepetitán',
                            'Verapaz',

                            'Candelaria de la Frontera',
                            'Chalchuapa',
                            'Coatepeque',
                            'El Congo',
                            'El Porvenir',
                            'Masahuat',
                            'Metapán',
                            'San Antonio Pajonal',
                            'San Sebastián Salitrillo',
                            'Santa Ana',
                            'Santa Rosa Guachipilín',
                            'Santiago de la Frontera',
                            'Texistepeque',

                            'Acajutla',
                            'Armenia',
                            'Caluco',
                            'Cuisnahuat',
                            'Izalco',
                            'Juayúa',
                            'Nahuizalco',
                            'Nahulingo',
                            'Salcoatitán',
                            'San Antonio del Monte',
                            'San Julián',
                            'Santa Catarina Masahuat',
                            'Santa Isabel Ishuatán',
                            'Santo Domingo',
                            'Sonsonate',
                            'Sonzacate',

                            'Alegría',
                            'Berlín',
                            'California',
                            'Concepción Batres',
                            'El Triunfo',
                            'Ereguayquín',
                            'Estanzuelas',
                            'Jiquilisco',
                            'Jucuapa',
                            'Jucuarán',
                            'Mercedes Umaña',
                            'Nueva Granada',
                            'Ozatlán',
                            'Puerto El Triunfo',
                            'San Agustín',
                            'San Buenaventura',
                            'San Dionisio',
                            'San Francisco Javier',
                            'Santa Elena',
                            'Santa María',
                            'Santiago de María',
                            'Tecapán',
                            'Usulután',
                          
        );
        $x=1;
        foreach ($municipios as $value) {

            //Anuachapan
            if($x<=12){

                DB::table('municipios')->insert([
                    'id_departamento' => 1,
                    'nombre' => $value
                ]);
            }
            //Cabañas
            if($x>12 && $x<=21){

                DB::table('municipios')->insert([
                    'id_departamento' => 2,
                    'nombre' => $value
                ]);
            }
            //chalatenando
            if($x>21 && $x<=54){

                DB::table('municipios')->insert([
                    'id_departamento' => 3,
                    'nombre' => $value
                ]);
            }

            //Cuscatlan
            if($x>54 && $x<=70){

                DB::table('municipios')->insert([
                    'id_departamento' => 4,
                    'nombre' => $value
                ]);
            }
            //La libertad
            if($x>70 && $x<=92){

                DB::table('municipios')->insert([
                    'id_departamento' => 5,
                    'nombre' => $value
                ]);
            }

            //La paz
            if($x>92 && $x<=114){

                DB::table('municipios')->insert([
                    'id_departamento' => 6,
                    'nombre' => $value
                ]);
            }

            //La union
            if($x>114 && $x<=132){

                DB::table('municipios')->insert([
                    'id_departamento' => 7,
                    'nombre' => $value
                ]);
            }
            //Morazan
            if($x>132 && $x<=158){

                DB::table('municipios')->insert([
                    'id_departamento' => 8,
                    'nombre' => $value
                ]);
            }

            //San Miguel
            if($x>158 && $x<=178){

                DB::table('municipios')->insert([
                    'id_departamento' => 9,
                    'nombre' => $value
                ]);
            }

            //San Salvador
            if($x>178 && $x<=197){

                DB::table('municipios')->insert([
                    'id_departamento' => 10,
                    'nombre' => $value
                ]);
            }

            //San vicente
            if($x>197 && $x<=210){

                DB::table('municipios')->insert([
                    'id_departamento' => 11,
                    'nombre' => $value
                ]);
            }

            //Santa Ana
            if($x>210 && $x<=223){

                DB::table('municipios')->insert([
                    'id_departamento' => 12,
                    'nombre' => $value
                ]);
            }

            //Sonsonate
            if($x>223 && $x<=239){

                DB::table('municipios')->insert([
                    'id_departamento' => 13,
                    'nombre' => $value
                ]);
            }

            //Usulutan
            if($x>239 && $x<=262){

                DB::table('municipios')->insert([
                    'id_departamento' => 14,
                    'nombre' => $value
                ]);
            }

            $x++;
        }
       
    }
}

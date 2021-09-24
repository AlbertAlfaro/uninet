<?php

namespace App\Console\Commands;

use App\Http\Controllers\BitacoraController;
use App\Models\Backups;
use Illuminate\Console\Command;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class DailyBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:drive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera un backup de la base de datos,lo guarda en el servidor y google drive';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        function listarArchivos( $path ){
            // Abrimos la carpeta que nos pasan como parámetro
            $dir = opendir($path);
            // Leo todos los ficheros de la carpeta
            while ($elemento = readdir($dir)){
                // Tratamos los elementos . y .. que tienen todas las carpetas
                if( $elemento != "." && $elemento != ".."){
                    // Si es una carpeta
                    if( is_dir($path.$elemento) ){
                        // Muestro la carpeta
                        //echo "<p><strong>CARPETA: ". $elemento ."</strong></p>";
                    // Si es un fichero
                    } else {
                        // Muestro el fichero
                        //echo "<br />". $elemento;
                        $nombre=$elemento;
                    }
                }
            }
            return $nombre;
        }
        $fecha=date('Y-m-d');
        Artisan::call('backup:run --only-db'); 
        $nombre=listarArchivos(storage_path()."/laravel-backups/Laravel");
        $backup= new Backups();
        $backup->fecha=$fecha;
        $backup->nombre=$nombre;
        $backup->enlace="/laravel-backups/Laravel/".$nombre;
        $backup->save();
        Storage::disk('google')->put($nombre, file_get_contents(storage_path()."/laravel-backups/Laravel/".$nombre));

        //$obj_controller_bitacora=new BitacoraController();
        //$obj_controller_bitacora->create_mensaje('Backup creado');
        
    }
}

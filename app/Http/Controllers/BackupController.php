<?php

namespace App\Http\Controllers;

use App\Models\Backups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function index(){
        $backups = Backups::all();
        return view('backups.index',compact('backups'));

    }

    public function create(){

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
        flash()->success("Copia de seguridad creada exitosamente!")->important();

        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Backup creado');
        Storage::disk('google')->put($nombre, file_get_contents(storage_path()."/laravel-backups/Laravel/".$nombre));


        return redirect()->route('backup.index');

    }

    public function download($id){

        $ruta = Backups::find($id);
        $pathToFile = storage_path().$ruta->enlace;
        return response()->download($pathToFile);

    }

    public function destroy($id){

        $backup=Backups::find($id);
        $backup_path = storage_path().$backup->enlace;
        unlink($backup_path);
        Backups::destroy($id);
        flash()->success("Copia de seguridad eliminada exitosamente!")->important();
        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Backup id:'.$id.' eliminado');
        return redirect()->route('backup.index');

    }
}

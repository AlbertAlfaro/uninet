<?php

namespace App\Console\Commands;

use App\Models\Abono;
use App\Models\Internet;
use App\Models\Tv;
use DateTime;
use Illuminate\Console\Command;

class GenCobros extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cobros:genCobro';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera los cobros de clientes';

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
        $dia_actual = date('j');
        $fecha_actual = date('Y-m-d');
        $fecha_vence = strtotime ( '+10 day' , strtotime ( $fecha_actual ) ) ;
        $fecha_vence = date ( 'Y-m-d' , $fecha_vence );
        $mes_servicio = strtotime ( '-30 day' , strtotime ( $fecha_actual ) ) ;
        $mes_servicio = date ( 'Y-m-d' , $mes_servicio );
        $internet = Internet::where('dia_gene_fact',$dia_actual)->where('activo',1)->get();
        $tv = Tv::where('dia_gene_fact',$dia_actual)->where('activo',1)->get();

        $primer_fac_inter = new DateTime();
        $primer_fac_tv = new DateTime();

        $fecha_fa = new DateTime($mes_servicio);

        foreach ($internet as $value) {
            $primer_fac_inter = new DateTime($value->fecha_primer_fact);
            if($primer_fac_inter<=$fecha_fa){

                $abono = new Abono();
                $abono->id_cliente = $value->id_cliente;
                $abono->tipo_servicio = 1;
                $abono->mes_servicio = $mes_servicio;
                $abono->cargo = $value->cuota_mensual;
                $abono->abono = 0.00;
                $abono->fecha_vence = $fecha_vence;
                $abono->anulado = 0;
                $abono->pagado = 0;
                $abono->save();
            }
        
        }
        foreach ($tv as $value) {
            $primer_fac_tv = new DateTime($value->fecha_primer_fact);
            if($primer_fac_tv<=$fecha_fa){

                $abono = new Abono();
                $abono->id_cliente = $value->id_cliente;
                $abono->tipo_servicio = 2;
                $abono->mes_servicio = $mes_servicio;
                $abono->cargo = $value->cuota_mensual;
                $abono->abono = 0.00;
                $abono->fecha_vence = $fecha_vence;
                $abono->anulado = 0;
                $abono->pagado = 0;
                $abono->save();
            }
    
    }
    }
}

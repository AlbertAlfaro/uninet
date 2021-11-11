<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Internet extends Model
{
    use HasFactory;
    protected $dates = ['fecha_instalacion','contrato_vence','fecha_primer_fact'];
    protected $fillable = ['id_cliente', 'numero_contrato','fecha_instalacion','fecha_primer_fact','cuota_mensual','dia_gene_fact','contrato_vence','periodo','velocidad','onu','onu_wifi','cable_red','router','identificador','activo'];


    public function get_cliente()
    {
        return $this->hasOne('App\Models\Cliente','id', 'id_cliente');
    }
    /*psuboss */
}

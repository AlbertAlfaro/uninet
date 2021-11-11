<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abono extends Model
{
    use HasFactory;

    protected $dates = ['mes_servicio','fecha_aplicado','fecha_vence']; 
    protected $fillable = ['id', 'id_factura','id_cliente','id_cobrador','id_usuario','recibo','tipo_servicio','numero_documento','tipo_documento','tipo_pago','mes_servicio','fecha_aplicado','fecha_vence','cargo','abono','cesc_cargo','cesc_abono','precio','anulado','pagado'];

    public function get_cliente()
    {
        return $this->hasOne('App\Models\Cliente','id','id_cliente');
    }
}

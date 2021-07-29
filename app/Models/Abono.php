<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abono extends Model
{
    use HasFactory;
    protected $dates = ['mes_servicio','fecha_aplicado','fecha_vence'];
    protected $table = 'abonos';
    public function get_cliente()
    {
        return $this->hasOne('App\Models\Cliente','id','id_cliente');
    }
}

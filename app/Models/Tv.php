<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tv extends Model
{
    use HasFactory;
    protected $dates = ['fecha_instalacion','contrato_vence','fecha_primer_fact'];

    public function get_cliente()
    {
        return $this->hasOne('App\Models\Cliente','id', 'id_cliente');
    }
}

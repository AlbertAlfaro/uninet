<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    public function get_cliente(){

        return $this->hasOne('App\Models\Cliente','id', 'id_cliente');

    }
    public function get_cobrador(){

        return $this->hasOne('App\Models\Cobrador','id', 'id_cobrador');

    }
}

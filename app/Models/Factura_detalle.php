<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura_detalle extends Model
{
    use HasFactory;

    public function get_producto()
    {
        return $this->hasOne('App\Models\Producto','id', 'id_producto');
    }


}

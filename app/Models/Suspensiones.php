<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suspensiones extends Model
{
    use HasFactory;
    protected $dates = ['fecha_trabajo'];
    public function get_cliente()
    {
        return $this->hasOne('App\Models\Cliente','id','id_cliente');
    }
}

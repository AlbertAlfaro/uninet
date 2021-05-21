<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    use HasFactory;
    protected $table = 'bitacora';

    public function usuario()
    {
        return $this->hasOne('App\Models\User','id', 'id');
    }
}

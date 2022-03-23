<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'cliente';
    public $timestamps = false;
    protected $fillable = [
        'cnpj', 'nome', 'dt_fundacao'
    ];
}

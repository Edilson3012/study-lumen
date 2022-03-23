<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendedor  extends Model
{
    protected $table = 'vendedor';
    public $timestamps = false;
    protected $fillable = [
        'nome_completo',  'nome_abreviado', 'dt_admissao'
    ];

    public function Carteira()
    {
        return $this->belongsTo(Carteira::class);
    }
}

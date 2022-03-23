<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carteira extends Model
{
    protected $table = 'carteira';
    public $timestamps = false;
    protected $fillable = [
        'id_vendedor', 'id_cliente'
    ];

    public function vendedor()
    {
        return $this->hasMany(Vendedor::class);
    }

    public static function getCarteiraVendedor($id)
    {
        $query = Self::where('id_vendedor', $id)
            ->join('vendedor as v', 'v.id', 'id_vendedor')
            ->join('cliente as c', 'c.id', 'id_cliente')
            ->select('carteira.id', 'id_vendedor', 'id_cliente', 'nome');
        return $query->paginate();
    }

    public static function getClienteCarteira($idCliente)
    {
        return Self::where('id_cliente', $idCliente)->first();
    }

    public static function getQtdClientesCarteira($idVendedor)
    {
        return Self::where('id_vendedor', $idVendedor)->count();
    }

    public static function verificarCarteira($idVendedor, $idCliente)
    {
        $query = Self::where('id_vendedor', $idVendedor)
            ->Orwhere('id_cliente', $idCliente);

        $data = $query->get();
        return !empty($data) ? $data : null;
    }
}

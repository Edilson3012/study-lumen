<?php

namespace App\Http\Controllers;

use App\Models\Carteira;
use App\Models\Cliente;
use App\Models\Vendedor;
use Illuminate\Http\Request;

class CarteiraController extends Controller
{
    private $repository;
    private $vendedor;
    private $cliente;

    public function __construct(Carteira $carteira, Vendedor $vendedor, Cliente $cliente)
    {
        $this->repository = $carteira;
        $this->vendedor = $vendedor;
        $this->cliente = $cliente;
    }

    public function index()
    {
        $dataCarteira = $this->repository->paginate();

        foreach ($dataCarteira as $key => $val) {
            $vendedor = $this->vendedor->find($val['id_vendedor']);
            $dataCarteira[$key]['vendedor'] = $vendedor->nome_completo;

            $cliente = $this->cliente->find($val['id_cliente']);
            $dataCarteira[$key]['cliente'] = $cliente->nome;
        }

        return response()->json($dataCarteira);
    }

    public function store(Request $request)
    {
        $carteira = $request->except('_token');

        if (!$vendedor = $this->vendedor->find($carteira['id_vendedor']))
            return response()->json(['status' => 'error', 'msg' => 'Vendedor não encontrado.']);

        if (!$cliente = $this->cliente->find($carteira['id_cliente']))
            return response()->json(['status' => 'error', 'msg' => 'Cliente não encontrado.']);

        $qtdClientes = $this->repository->getQtdClientesCarteira($vendedor['id']);
        if($qtdClientes == 50){
            return response()->json(['status' => 'error', 'msg' => 'Este vendedor atingiu o limite de 50 clientes.']);
        }

        if ($this->repository->getClienteCarteira($cliente['id']))
            return response()->json(['status' => 'error', 'msg' => 'Este cliente já possui um vendedor.']);

        $this->repository->create($carteira);

        $msg = [
            "status" => 'success',
            "message" => "Carteira salvo com sucesso!"
        ];

        return response()->json($msg);
    }

    public function vendedor($id)
    {
        if (!$vendedor = $this->vendedor->find($id))
            return response()->json(['status' => 'error', 'msg' => 'Vendedor não encontrado.']);

        $carteira =  $this->repository->getCarteiraVendedor($id);

        return response()->json($carteira);
    }
}

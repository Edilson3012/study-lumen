<?php

namespace App\Http\Controllers;

use App\Models\Vendedor;
use Illuminate\Http\Request;

class VendedoresController extends Controller
{
    private $repository;

    public function __construct(Vendedor $vendedor)
    {
        $this->repository = $vendedor;
    }

    public function index()
    {
        $dataVendedor = $this->repository->paginate();
        return response()->json($dataVendedor);
    }

    public function show($id)
    {
        if(!$vendedor = $this->repository->find($id))
            return response()->json(['status' => 'error', 'msg' => 'Vendedor não encontrado.']);

        return response()->json($vendedor);
    }

    public function store(Request $request)
    {
        $dataVendedor = $request->except('_token');

        $this->repository->create($dataVendedor);

        $msg = [
            "status" => 'success',
            "message" => "Cliente salvo com sucesso!"
        ];

        return response()->json($msg);
    }

    public function update(Request $request, $id)
    {
        if (!$vendedor = $this->repository->find($id))
            return response()->json(['status' => 'error', 'msg' => 'Cliente não encontrado.']);

        $dataVendedor['cnpj'] = $request->cnpj;
        $dataVendedor['nome'] = $request->nome;
        $dataVendedor['dt_fundacao'] = $request->dt_fundacao;

        $vendedor->update($dataVendedor);

        return response()->json(['msg' => 'success', 'message' => 'Cliente alterado com sucesso.']);
    }

    public function destroy($id)
    {
        if (!$vendedor = $this->repository->find($id))
            return response()->json(['status' => 'error', 'msg' => 'Cliente não encontrado.']);

        $delete = $vendedor->delete();

        if ($delete == 1) {
            $status = 'success';
            $message = "Cliente excluído com sucesso!";
        } else {
            $status = 'error';
            $message = "Cliente não encontrado... :\)";
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }
}

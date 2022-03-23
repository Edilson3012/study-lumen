<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    private $repository;

    public function __construct(Cliente $cliente)
    {
        $this->repository = $cliente;
    }

    public function index()
    {
        $dataCliente = $this->repository->paginate();
        return response()->json($dataCliente);
    }

    public function show($id)
    {
        if (!$cliente = $this->repository->find($id))
            return response()->json(['status' => 'error', 'msg' => 'Cliente não encontrado.']);

        return response()->json($cliente);
    }

    public function store(Request $request)
    {
        $dataCliente = $request->except('_token');

        $this->repository->create($dataCliente);

        $msg = [
            "status" => 'success',
            "message" => "Cliente salvo com sucesso!"
        ];

        return response()->json($msg);
    }

    public function update(Request $request, $id)
    {
        if (!$cliente = $this->repository->find($id))
            return response()->json(['status' => 'error', 'msg' => 'Cliente não encontrado.']);

        $dataCliente['cnpj'] = $request->cnpj;
        $dataCliente['nome'] = $request->nome;
        $dataCliente['dt_fundacao'] = $request->dt_fundacao;

        $cliente->update($dataCliente);

        return response()->json(['msg' => 'success', 'message' => 'Cliente alterado com sucesso.']);
    }

    public function destroy($id)
    {
        if (!$cliente = $this->repository->find($id))
            return response()->json(['status' => 'error', 'msg' => 'Cliente não encontrado.']);

        $delete = $cliente->delete();

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

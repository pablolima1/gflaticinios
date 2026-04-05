<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function __construct(private Cliente $cliente)
    {
    }
    
    public function index()
    {
        $clientes = $this->cliente->getAllClientes();
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function show(Cliente $cliente)
    {
        return response()->json($cliente);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'data_nascimento' => 'nullable',
            'endereco' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string',
        ]);

        $dataNascimentoOriginal = str_replace('/', '-', $request->input('data_nascimento'));
        $dataNascimento = date('Y-m-d', strtotime($dataNascimentoOriginal));

        $data = array_merge($validatedData, ['data_nascimento' => $dataNascimento]);

        $this->cliente->create($data);

        return response()->json(['message' => 'Cliente criado com sucesso!'], 201);
    }

    public function update(Request $request, Cliente $cliente)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'data_nascimento' => 'nullable|date',
            'endereco' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string',
        ]);

        $cliente->update($validatedData);

        return response()->json(['message' => 'Cliente atualizado com sucesso!'], 200);
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return response()->json(['message' => 'Cliente removido com sucesso!'], 200);
    }

    // Retorna todos os clientes para uso em selects AJAX
    public function apiList()
    {
        $clientes = $this->cliente->select('id', 'nome')->orderBy('nome')->get();
        return response()->json($clientes);
    }
}

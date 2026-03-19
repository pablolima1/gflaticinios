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

        return redirect()->route('clientes.index')->with('success', 'Cliente atualizado com sucesso!');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente deletado com sucesso!');
    }
}

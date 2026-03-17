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
            'data_nascimento' => 'nullable|date',
            'endereco' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string',
        ]);

        $this->cliente->create($validatedData);

        return redirect()->route('clientes.index')->with('success', 'Cliente criado com sucesso!');
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

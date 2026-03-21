<?php

namespace App\Http\Controllers;

use App\Models\BrindeCliente;
use Illuminate\Http\Request;

class BrindeClienteController extends Controller
{
    public function __construct(private BrindeCliente $brindeCliente)
    {
    }

    public function index()
    {
        $brindesCliente = $this->brindeCliente->all();
        return view('brindes_cliente.index', compact('brindesCliente'));
    }

    public function create()
    {
        return view('brindes_cliente.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // Adicione regras de validação conforme o modelo
        ]);

        $this->brindeCliente->create($validatedData);

        return redirect()->route('brindes_cliente.index')->with('success', 'Brinde do cliente criado com sucesso!');
    }

    public function update(Request $request, BrindeCliente $brindeCliente)
    {
        $validatedData = $request->validate([
            // Adicione regras de validação conforme o modelo
        ]);

        $brindeCliente->update($validatedData);

        return redirect()->route('brindes_cliente.index')->with('success', 'Brinde do cliente atualizado com sucesso!');
    }

    public function destroy(BrindeCliente $brindeCliente)
    {
        $brindeCliente->delete();
        return redirect()->route('brindes_cliente.index')->with('success', 'Brinde do cliente removido com sucesso!');
    }
}

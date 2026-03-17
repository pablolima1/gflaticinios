<?php

namespace App\Http\Controllers;

use App\Models\PedidoRecorrente;
use Illuminate\Http\Request;

class PedidoRecorrenteController extends Controller
{
    public function __construct(private PedidoRecorrente $pedidoRecorrente)
    {
    }

    public function index()
    {
        $pedidosRecorrentes = $this->pedidoRecorrente->all();
        return view('pedidos_recorrentes.index', compact('pedidosRecorrentes'));
    }

    public function create()
    {
        return view('pedidos_recorrentes.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // Adicione regras de validação conforme o modelo
        ]);

        $this->pedidoRecorrente->create($validatedData);

        return redirect()->route('pedidos_recorrentes.index')->with('success', 'Pedido recorrente criado com sucesso!');
    }

    public function update(Request $request, PedidoRecorrente $pedidoRecorrente)
    {
        $validatedData = $request->validate([
            // Adicione regras de validação conforme o modelo
        ]);

        $pedidoRecorrente->update($validatedData);

        return redirect()->route('pedidos_recorrentes.index')->with('success', 'Pedido recorrente atualizado com sucesso!');
    }

    public function destroy(PedidoRecorrente $pedidoRecorrente)
    {
        $pedidoRecorrente->delete();
        return redirect()->route('pedidos_recorrentes.index')->with('success', 'Pedido recorrente removido com sucesso!');
    }
}

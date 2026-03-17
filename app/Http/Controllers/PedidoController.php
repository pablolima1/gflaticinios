<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function __construct(private Pedido $pedido)
    {
    }

    public function index()
    {
        $pedidos = $this->pedido->all();
        return view('pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        return view('pedidos.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // Adicione regras de validação conforme o modelo
        ]);

        $this->pedido->create($validatedData);

        return redirect()->route('pedidos.index')->with('success', 'Pedido criado com sucesso!');
    }

    public function update(Request $request, Pedido $pedido)
    {
        $validatedData = $request->validate([
            // Adicione regras de validação conforme o modelo
        ]);

        $pedido->update($validatedData);

        return redirect()->route('pedidos.index')->with('success', 'Pedido atualizado com sucesso!');
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->delete();
        return redirect()->route('pedidos.index')->with('success', 'Pedido removido com sucesso!');
    }
}

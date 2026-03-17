<?php

namespace App\Http\Controllers;

use App\Models\ItemPedido;
use Illuminate\Http\Request;

class ItemPedidoController extends Controller
{
    public function __construct(private ItemPedido $itemPedido)
    {
    }

    public function index()
    {
        $itensPedido = $this->itemPedido->all();
        return view('itens_pedido.index', compact('itensPedido'));
    }

    public function create()
    {
        return view('itens_pedido.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // Adicione regras de validação conforme o modelo
        ]);

        $this->itemPedido->create($validatedData);

        return redirect()->route('itens_pedido.index')->with('success', 'Item do pedido criado com sucesso!');
    }

    public function update(Request $request, ItemPedido $itemPedido)
    {
        $validatedData = $request->validate([
            // Adicione regras de validação conforme o modelo
        ]);

        $itemPedido->update($validatedData);

        return redirect()->route('itens_pedido.index')->with('success', 'Item do pedido atualizado com sucesso!');
    }

    public function destroy(ItemPedido $itemPedido)
    {
        $itemPedido->delete();
        return redirect()->route('itens_pedido.index')->with('success', 'Item do pedido removido com sucesso!');
    }
}

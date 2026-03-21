<?php

namespace App\Http\Controllers;

use App\Models\ItemVenda;
use Illuminate\Http\Request;

class ItemVendaController extends Controller
{
    public function __construct(private ItemVenda $itemVenda)
    {
    }

    public function index()
    {
        $itensVenda = $this->itemVenda->all();
        return view('itens_venda.index', compact('itensVenda'));
    }

    public function create()
    {
        return view('itens_venda.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // Adicione regras de validação conforme o modelo
        ]);

        $this->itemVenda->create($validatedData);

        return redirect()->route('itens_venda.index')->with('success', 'Item da venda criado com sucesso!');
    }

    public function update(Request $request, ItemVenda $itemVenda)
    {
        $validatedData = $request->validate([
            // Adicione regras de validação conforme o modelo
        ]);

        $itemVenda->update($validatedData);

        return redirect()->route('itens_venda.index')->with('success', 'Item da venda atualizado com sucesso!');
    }

    public function destroy(ItemVenda $itemVenda)
    {
        $itemVenda->delete();
        return redirect()->route('itens_venda.index')->with('success', 'Item da venda removido com sucesso!');
    }
}

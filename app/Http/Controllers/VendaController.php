<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use Illuminate\Http\Request;

class VendaController extends Controller
{
    public function __construct(private Venda $venda)
    {
    }

    public function index()
    {
        $vendas = $this->venda->all();
        return view('vendas.index', compact('vendas'));
    }

    public function create()
    {
        return view('vendas.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // Adicione regras de validação conforme o modelo
        ]);

        $this->venda->create($validatedData);

        return redirect()->route('vendas.index')->with('success', 'Venda criada com sucesso!');
    }

    public function update(Request $request, Venda $venda)
    {
        $validatedData = $request->validate([
            // Adicione regras de validação conforme o modelo
        ]);

        $venda->update($validatedData);

        return redirect()->route('vendas.index')->with('success', 'Venda atualizada com sucesso!');
    }

    public function destroy(Venda $venda)
    {
        $venda->delete();
        return redirect()->route('vendas.index')->with('success', 'Venda removida com sucesso!');
    }
}

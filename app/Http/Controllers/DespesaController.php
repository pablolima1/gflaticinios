<?php

namespace App\Http\Controllers;

use App\Models\Despesa;
use Illuminate\Http\Request;

class DespesaController extends Controller
{
    public function __construct(private Despesa $despesa)
    {
    }

    public function index()
    {
        $despesas = $this->despesa->all();
        return view('despesas.index', compact('despesas'));
    }

    public function create()
    {
        return view('despesas.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // Adicione regras de validação conforme o modelo
        ]);

        $this->despesa->create($validatedData);

        return redirect()->route('despesas.index')->with('success', 'Despesa criada com sucesso!');
    }

    public function update(Request $request, Despesa $despesa)
    {
        $validatedData = $request->validate([
            // Adicione regras de validação conforme o modelo
        ]);

        $despesa->update($validatedData);

        return redirect()->route('despesas.index')->with('success', 'Despesa atualizada com sucesso!');
    }

    public function destroy(Despesa $despesa)
    {
        $despesa->delete();
        return redirect()->route('despesas.index')->with('success', 'Despesa removida com sucesso!');
    }
}

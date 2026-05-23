<?php

namespace App\Http\Controllers;

use App\Models\TipoDespesa;
use Illuminate\Http\Request;

class TipoDespesaController extends Controller
{
    public function index()
    {
        $tipos = TipoDespesa::orderBy('nome')->paginate(20);
        return view('pages.tiposdespesas.index', compact('tipos'));
    }

    public function create()
    {
        return view('pages.tiposdespesas.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        TipoDespesa::create($data);

        return redirect()->route('tipos-despesas.index')->with('success', 'Tipo de despesa criado com sucesso.');
    }

    public function edit(TipoDespesa $tipo)
    {
        return view('pages.tiposdespesas.edit', compact('tipo'));
    }

    public function update(Request $request, TipoDespesa $tipo)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        $tipo->update($data);

        return redirect()->route('tipos-despesas.index')->with('success', 'Tipo de despesa atualizado.');
    }

    public function destroy(TipoDespesa $tipo)
    {
        $tipo->delete();
        return redirect()->route('tipos-despesas.index')->with('success', 'Tipo de despesa excluído.');
    }
}

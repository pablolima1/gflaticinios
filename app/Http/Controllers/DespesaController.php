<?php

namespace App\Http\Controllers;

use App\Models\Despesa;
use App\Models\TipoDespesa;
use Illuminate\Http\Request;

class DespesaController extends Controller
{
    public function __construct(private Despesa $despesa)
    {
    }

    public function index()
    {
        $despesas = $this->despesa
            ->orderBy('data_despesa', 'desc')
            ->paginate(15);

        return view('pages.despesas.index', compact('despesas'));
    }

    public function create()
    {
        $tiposdespesas = TipoDespesa::orderBy('nome')->get();
        return view('pages.despesas.create', compact('tiposdespesas'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tipo_despesa_id' => 'required|exists:tipos_despesas,id',
            'descricao' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0.01',
            'data_despesa' => 'required|date',
            'observacoes' => 'nullable|string|max:1000',
        ]);

        $this->despesa->create($validatedData);

        return redirect()->route('despesas.index')->with('success', 'Despesa criada com sucesso!');
    }

    public function edit(Despesa $despesa)
    {
        $tiposdespesas = TipoDespesa::orderBy('nome')->get();
        return view('pages.despesas.edit', compact('despesa', 'tiposdespesas'));
    }

    public function update(Request $request, Despesa $despesa)
    {
        $validatedData = $request->validate([
            'tipo_despesa_id' => 'required|exists:tipos_despesas,id',
            'descricao' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0.01',
            'data_despesa' => 'required|date',
            'observacoes' => 'nullable|string|max:1000',
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

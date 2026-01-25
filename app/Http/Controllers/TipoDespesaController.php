<?php

namespace App\Http\Controllers;

use App\Services\TipoDespesaService;
use Illuminate\Http\Request;

class TipoDespesaController extends Controller
{
    public function __construct(
        private TipoDespesaService $tipoDespesaService
        )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipoDespesas = $this->tipoDespesaService->all();
        
        return view('pages.administracao.tipodespesas.index', compact('tipoDespesas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.administracao.tipodespesas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        $this->tipoDespesaService->create($data);

        return redirect()->route('tipos-despesas.index')->with('success', 'Tipo de Despesa criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tipoDespesa = $this->tipoDespesaService->find($id);

        return view('pages.administracao.tipodespesas.edit', compact('tipoDespesa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validated = $request->validate([
                'nome' => 'required|string|max:255',
                'descricao' => 'nullable|string',
            ]);

            $this->tipoDespesaService->update($id, $validated);

            return redirect()
                ->route('tipos-despesas.index')
                ->with('success', 'Tipo de Despesa atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->tipoDespesaService->delete($id);
            return redirect()->route('tipos-despesas.index')->with('success', 'Tipo de Despesa deletado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('tipos-despesas.index')->with('error', $e->getMessage());
        }
    }
}

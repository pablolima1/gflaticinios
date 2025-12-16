<?php

namespace App\Http\Controllers;

use App\Services\TipoProcessoService;
use Illuminate\Http\Request;

class TipoProcessoController extends Controller
{
    public function __construct(
        private TipoProcessoService $tipoProcessoService
        )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipoProcessos = $this->tipoProcessoService->all();
        
        return view('pages.administracao.tipoprocessos.index', compact('tipoProcessos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.administracao.tipoprocessos.create');
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

        $this->tipoProcessoService->create($data);

        return redirect()->route('tipos-processos.index')->with('success', 'Tipo de Processo criado com sucesso!');
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
        $tipoProcesso = $this->tipoProcessoService->find($id);

        return view('pages.administracao.tipoprocessos.edit', compact('tipoProcesso'));
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

            $this->tipoProcessoService->update($id, $validated);

            return redirect()
                ->route('tipos-processos.index')
                ->with('success', 'Tipo de Processo atualizado com sucesso!');
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
            $this->tipoProcessoService->delete($id);
            return redirect()->route('tipos-processos.index')->with('success', 'Tipo de Processo deletado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('tipos-processos.index')->with('error', $e->getMessage());
        }
    }
}

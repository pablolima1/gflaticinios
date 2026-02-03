<?php

namespace App\Http\Controllers;

use App\Models\Despesa;
use App\Services\DespesaService;
use Illuminate\Http\Request;

class DespesaController extends Controller
{

    public function __construct(private DespesaService $despesaService) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'tipo_despesa_id' => 'required|integer|exists:tipos_despesas,id',
            'valor' => 'required|numeric',
            'data_despesa' => 'required',
        ]);

        $this->despesaService->store($data);

        return response()->json(['message' => 'Despesa criada com sucesso!'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $despesa = $this->despesaService->find($id);

        return response()->json($despesa);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->despesaService->update($request->all(), $id);
        return response()->json(['message' => 'Despesa atualizada com sucesso!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->despesaService->delete($id);

            return redirect()
                ->back()
                ->with('success', 'Despesa deletada com sucesso!');
        } catch (\Exception $e) {
            return redirect()
                ->route('despesa.index')
                ->with('error', $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Meta;
use Illuminate\Http\Request;

class MetaController extends Controller
{
    public function index()
    {
        $metas = Meta::orderByDesc('data_inicio')->get();
        return view('metas.index', compact('metas'));
    }

    public function show(Meta $meta)
    {
        // Calcula o progresso da meta
        $progresso = $meta->progresso();
        $percentual = $meta->valor_meta > 0 ? ($progresso / $meta->valor_meta) * 100 : 0;
        
        return response()->json([
            ...$meta->toArray(),
            'progresso' => $progresso,
            'percentual' => round($percentual, 2)
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'valor_meta' => 'required|numeric|min:0.01',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'status' => 'required|in:ativa,inativa',
        ]);

        $meta = Meta::create($validated);

        return response()->json([
            'message' => 'Meta criada com sucesso!',
            'meta' => $meta
        ], 201);
    }

    public function update(Request $request, Meta $meta)
    {
        $validated = $request->validate([
            'valor_meta' => 'required|numeric|min:0.01',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'status' => 'required|in:ativa,inativa',
        ]);

        $meta->update($validated);

        return response()->json([
            'message' => 'Meta atualizada com sucesso!',
            'meta' => $meta
        ], 200);
    }

    public function destroy(Meta $meta)
    {
        $meta->delete();

        return response()->json([
            'message' => 'Meta removida com sucesso!'
        ], 200);
    }
}

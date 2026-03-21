<?php

namespace App\Http\Controllers;

use App\Models\Meta;
use Illuminate\Http\Request;

class MetaController extends Controller
{
    public function index()
    {
        $metas = Meta::orderByDesc('data_inicio')->paginate(10);
        return view('metas.index', compact('metas'));
    }

    public function create()
    {
        return view('metas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'valor_meta' => 'required|numeric|min:0',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'status' => 'required|in:ativa,inativa',
        ]);
        Meta::create($validated);
        return redirect()->route('metas.index')->with('success', 'Meta criada com sucesso!');
    }

    public function edit(Meta $meta)
    {
        return view('metas.edit', compact('meta'));
    }

    public function update(Request $request, Meta $meta)
    {
        $validated = $request->validate([
            'valor_meta' => 'required|numeric|min:0',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'status' => 'required|in:ativa,inativa',
        ]);
        $meta->update($validated);
        return redirect()->route('metas.index')->with('success', 'Meta atualizada com sucesso!');
    }

    public function destroy(Meta $meta)
    {
        $meta->delete();
        return redirect()->route('metas.index')->with('success', 'Meta removida com sucesso!');
    }
}

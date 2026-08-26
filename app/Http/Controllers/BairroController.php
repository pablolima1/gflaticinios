<?php

namespace App\Http\Controllers;

use App\Models\Bairro;
use Illuminate\Http\Request;

class BairroController extends Controller
{
    public function index()
    {
        $bairros = Bairro::orderBy('nome')->paginate(20);

        return view('pages.bairros.index', compact('bairros'));
    }

    public function create()
    {
        return view('pages.bairros.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255|unique:bairros,nome',
        ]);

        Bairro::create($data);

        return redirect()->route('bairros.index')->with('success', 'Bairro criado com sucesso.');
    }

    public function edit(Bairro $bairro)
    {
        return view('pages.bairros.edit', compact('bairro'));
    }

    public function update(Request $request, Bairro $bairro)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255|unique:bairros,nome,' . $bairro->id,
        ]);

        $bairro->update($data);

        return redirect()->route('bairros.index')->with('success', 'Bairro atualizado com sucesso.');
    }

    public function destroy(Bairro $bairro)
    {
        $bairro->clientes()->update(['bairro_id' => null]);
        $bairro->delete();

        return redirect()->route('bairros.index')->with('success', 'Bairro excluído com sucesso.');
    }
}
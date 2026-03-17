<?php

namespace App\Http\Controllers;

use App\Models\Brinde;
use Illuminate\Http\Request;

class BrindeController extends Controller
{
    public function __construct(private Brinde $brinde)
    {
    }

    public function index()
    {
        $brindes = $this->brinde->all();
        return view('brindes.index', compact('brindes'));
    }

    public function create()
    {
        return view('brindes.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // Adicione regras de validação conforme o modelo
        ]);

        $this->brinde->create($validatedData);

        return redirect()->route('brindes.index')->with('success', 'Brinde criado com sucesso!');
    }

    public function update(Request $request, Brinde $brinde)
    {
        $validatedData = $request->validate([
            // Adicione regras de validação conforme o modelo
        ]);

        $brinde->update($validatedData);

        return redirect()->route('brindes.index')->with('success', 'Brinde atualizado com sucesso!');
    }

    public function destroy(Brinde $brinde)
    {
        $brinde->delete();
        return redirect()->route('brindes.index')->with('success', 'Brinde removido com sucesso!');
    }
}

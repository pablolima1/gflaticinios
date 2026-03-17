<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function __construct(private Produto $produto)
    {
    }

    public function index()
    {
        $produtos = $this->produto->paginate(10);
        return view('produtos.index', compact('produtos'));
    }

    public function create()
    {
        return view('produtos.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // Adicione regras de validação conforme o modelo
        ]);

        $this->produto->create($validatedData);

        return redirect()->route('produtos.index')->with('success', 'Produto criado com sucesso!');
    }

    public function update(Request $request, Produto $produto)
    {
        $validatedData = $request->validate([
            // Adicione regras de validação conforme o modelo
        ]);

        $produto->update($validatedData);

        return redirect()->route('produtos.index')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Produto $produto)
    {
        $produto->delete();
        return redirect()->route('produtos.index')->with('success', 'Produto removido com sucesso!');
    }
}

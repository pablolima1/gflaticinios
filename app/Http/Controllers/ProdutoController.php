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

    public function show(Produto $produto)
    {
        return response()->json($produto);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric',
            'unidade_medida' => 'nullable|string|max:50',
            'ativo' => 'required|boolean',
        ]);

        $this->produto->create($validatedData);

        return response()->json(['message' => 'Produto criado com sucesso!'], 201);
    }

    public function update(Request $request, Produto $produto)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric',
            'unidade_medida' => 'nullable|string|max:50',
            'ativo' => 'required|boolean',
        ]);

        $produto->update($validatedData);

        return response()->json(['message' => 'Produto atualizado com sucesso!'], 200);
    }

    public function destroy(Produto $produto)
    {
        $produto->delete();
        return response()->json(['message' => 'Produto removido com sucesso!'], 200);
    }

    // Retorna todos os produtos para uso em selects AJAX
    public function apiList()
    {
        $produtos = $this->produto->select('id', 'nome', 'preco')->orderBy('nome')->get();
        return response()->json($produtos);
    }
}

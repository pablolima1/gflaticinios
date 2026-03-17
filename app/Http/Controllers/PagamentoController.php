<?php

namespace App\Http\Controllers;

use App\Models\Pagamento;
use Illuminate\Http\Request;

class PagamentoController extends Controller
{
    public function __construct(private Pagamento $pagamento)
    {
    }

    public function index()
    {
        $pagamentos = $this->pagamento->paginate(10);
        return view('pagamentos.index', compact('pagamentos'));
    }

    public function create()
    {
        return view('pagamentos.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // Adicione regras de validação conforme o modelo
        ]);

        $this->pagamento->create($validatedData);

        return redirect()->route('pagamentos.index')->with('success', 'Pagamento criado com sucesso!');
    }

    public function update(Request $request, Pagamento $pagamento)
    {
        $validatedData = $request->validate([
            // Adicione regras de validação conforme o modelo
        ]);

        $pagamento->update($validatedData);

        return redirect()->route('pagamentos.index')->with('success', 'Pagamento atualizado com sucesso!');
    }

    public function destroy(Pagamento $pagamento)
    {
        $pagamento->delete();
        return redirect()->route('pagamentos.index')->with('success', 'Pagamento removido com sucesso!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use Illuminate\Http\Request;

class VendaController extends Controller
{
    public function __construct(private Venda $venda)
    {
    }

    public function index()
    {
        // Busca as últimas 10 vendas registradas com seus relacionamentos, em ordem decrescente de cadastro
        $vendas = $this->venda
            ->with(['cliente', 'usuario', 'itensVenda.produto'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Separa vendas de hoje das outras datas
        $hoje = now()->startOfDay();
        $vendasRecentes = [
            'hoje' => $vendas->filter(fn($v) => $v->created_at->startOfDay()->eq($hoje)),
            'outrosDias' => $vendas->filter(fn($v) => !$v->created_at->startOfDay()->eq($hoje))
        ];

        return view('pages.vendas.index', compact('vendasRecentes'));
    }

    public function create()
    {
        return view('vendas.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
            'valor' => 'required|numeric|min:0',
            'status_pagamento' => 'required|in:pago,anotado',
        ]);

        try {
            $userId = auth()->id();
            $dataOriginal = str_replace('/', '-', $request->input('data'));
            $dataFormatada = date('Y-m-d', strtotime($dataOriginal));
            
            $venda = $this->venda->create([
                'cliente_id' => $validatedData['cliente_id'],
                'usuario_id' => $userId,
                'data_venda' => $dataFormatada,
                'tipo_pagamento' => $validatedData['status_pagamento'] === 'pago' ? 'vista' : 'prazo',
                'status' => $validatedData['status_pagamento'] === 'pago' ? 'pago' : 'pendente',
                'valor_total' => $validatedData['valor'] * $validatedData['quantidade'],
                'observacoes' => null,
            ]);

            // Cria o item da venda
            $venda->itensVenda()->create([
                'produto_id' => $validatedData['produto_id'],
                'quantidade' => $validatedData['quantidade'],
                'preco_unitario' => $validatedData['valor'],
                'subtotal' => $validatedData['valor'] * $validatedData['quantidade'],
            ]);

            return response()->json(['message' => 'Venda cadastrada com sucesso!'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao cadastrar venda.', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Venda $venda)
    {
        $validatedData = $request->validate([
            // Adicione regras de validação conforme o modelo
        ]);

        $venda->update($validatedData);

        return redirect()->route('vendas.index')->with('success', 'Venda atualizada com sucesso!');
    }

    public function destroy(Venda $venda)
    {
        $venda->delete();
        return redirect()->route('vendas.index')->with('success', 'Venda removida com sucesso!');
    }
}

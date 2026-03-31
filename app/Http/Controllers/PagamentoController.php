<?php

namespace App\Http\Controllers;

use App\Models\Pagamento;
use App\Models\Venda;
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
        // Validação dos dados de entrada
        $validatedData = $request->validate([
            'venda_id' => 'required|integer|exists:vendas,id',
            'valor' => 'required|numeric|min:0.01',
            'data_pagamento' => 'required|date',
            'observacoes' => 'nullable|string|max:500',
        ], [
            'venda_id.required' => 'Venda é obrigatória',
            'venda_id.exists' => 'Venda não encontrada',
            'valor.required' => 'Valor é obrigatório',
            'valor.numeric' => 'Valor deve ser um número',
            'valor.min' => 'Valor deve ser maior que 0',
            'data_pagamento.required' => 'Data do pagamento é obrigatória',
            'data_pagamento.date' => 'Data inválida',
        ]);

        $validatedData['forma_pagamento'] = 'vista';

        try {
            // Verifica se a venda existe e está pendente
            $venda = Venda::findOrFail($validatedData['venda_id']);
            
            if ($venda->status !== 'pendente' || $venda->tipo_pagamento !== 'prazo') {
                return response()->json([
                    'success' => false,
                    'message' => 'Esta venda não está mais pendente ou não é uma venda a prazo'
                ], 422);
            }

            // Verifica se o valor não ultrapassa o saldo pendente
            $saldoPendente = $venda->saldoPendente();
            if ($validatedData['valor'] > $saldoPendente) {
                return response()->json([
                    'success' => false,
                    'message' => "Valor inserido (R$ " . number_format($validatedData['valor'], 2, ',', '.') . 
                                 ") ultrapassa o saldo pendente (R$ " . number_format($saldoPendente, 2, ',', '.') . ")"
                ], 422);
            }

            // Cria o pagamento
            $pagamento = $this->pagamento->create($validatedData);

            // Se o valor pago igualar o total, marca a venda como paga
            if ($venda->totalPago() + $validatedData['valor'] >= $venda->valor_total) {
                $venda->update(['status' => 'pago']);
            }

            return response()->json([
                'success' => true,
                'message' => 'Pagamento registrado com sucesso!',
                'data' => [
                    'id' => $pagamento->id,
                    'venda_id' => $pagamento->venda_id,
                    'valor' => $pagamento->valor,
                    'data_pagamento' => $pagamento->data_pagamento->format('d/m/Y'),
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao registrar pagamento: ' . $e->getMessage()
            ], 500);
        }
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

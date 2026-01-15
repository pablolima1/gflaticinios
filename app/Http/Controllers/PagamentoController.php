<?php

namespace App\Http\Controllers;

use App\Models\Parcela;
use App\Models\ParcelaPagamento;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;

class PagamentoController extends Controller
{
    public function __construct() {}

    public function registrarPagamento(Request $request)
    {
        try {
            DB::beginTransaction();
            $idParcela = $request->input('parcela_id');
            $valorPagamento = (float) $request->input('valor_pagamento');

            $dataPagamentoFormat = str_replace('/', '-', $request->input('data_pagamento'));
            $dataPagamento = date('Y-m-d', strtotime($dataPagamentoFormat));

            $observacoes = $request->input('observacoes');

            $parcela = Parcela::find($idParcela);
            $processo = $parcela->pagamento->processo;
            $pagamento = $parcela->pagamento;

            $valorRestanteParcela = (float) $parcela->valor_restante;

            if ($pagamento->quantidade_parcelas == $parcela->numero_parcela && $valorPagamento == $valorRestanteParcela) {
                $processo->status = 'finalizado';
            } else {
                $processo->status = 'andamento';
            }

            $processo->save();

            if ($valorPagamento == $valorRestanteParcela) {
                // Valor pago é igual ao valor da parcela
                $parcela->status = 'pago';
                $parcela->valor_restante = 0;
            } elseif ($valorPagamento < $valorRestanteParcela) {
                // Valor pago é menor que o valor da parcela
                $parcela->status = 'parcial';
                $parcela->valor_restante = $valorRestanteParcela - $valorPagamento;
            } else {
                // Valor pago é maior que o valor da parcela
                return redirect()->back()->with('error', 'O valor pago não pode ser maior que o valor da parcela.');
            }
            $parcela->save();

            ParcelaPagamento::create([
                'parcela_id' => $idParcela,
                'usuario_registrou_id' => auth()->user()->id,
                'valor_pago' => $valorPagamento,
                'data_pagamento' => $dataPagamento,
                'observacao' => $observacoes,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pagamento registrado com sucesso.'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao registrar o pagamento: ' . $th->getMessage()
            ]);
        }
    }

    public function detalhesPagamento(string $id)
    {
        $parcela = Parcela::find($id);

        $pagamento = $parcela->pagamento;
        $processo = $pagamento->processo;
        $cliente = $processo->cliente;

        return response()->json([
            'parcela' => $parcela,
            'processo' => $processo,
            'pagamento' => $pagamento
        ]);
    }
}

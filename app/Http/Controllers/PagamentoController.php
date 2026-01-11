<?php

namespace App\Http\Controllers;

use App\Models\Parcela;
use App\Models\ParcelaPagamento;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;

class PagamentoController extends Controller
{
    public function __construct() {}

    public function registrarPagamento($id, Request $request)
    {
        try {
            DB::beginTransaction();

            //dd('chegou aqui no controller com id ' . $id, $request->all());
            $parcela = Parcela::find($id);
            dd('parcela', $parcela);
            $processo = $parcela->pagamento->processo;
            $pagamento = $parcela->pagamento;

            if ($pagamento->quantidade_parcelas == $parcela->numero_parcela && $request->input('valor_pagamento') >= $parcela->valor) {
                $processo->status = 'finalizado';
            } else {
                $processo->status = 'andamento';
            }
            $processo->save();

            /* if (!$parcela) {
                return redirect()->back()->with('error', 'Parcela não encontrada.');
            }

            if ($parcela->status === 'pago') {
                return redirect()->back()->with('error', 'Esta parcela já foi paga.');
            } */

            if ($request->input('valor_pagamento') == $parcela->valor) {
                // Valor pago é igual ao valor da parcela
                $parcela->status = 'pago';
                $parcela->valor_restante = 0;
            } elseif ($request->input('valor_pagamento') < $parcela->valor) {
                // Valor pago é menor que o valor da parcela
                $parcela->status = 'parcial';
                $parcela->valor_restante = $parcela->valor - $request->input('valor_pagamento');
            } else {
                // Valor pago é maior que o valor da parcela
                return redirect()->back()->with('error', 'O valor pago não pode ser maior que o valor da parcela.');
            }
            $parcela->save();

            ParcelaPagamento::create([
                'parcela_id' => $id,
                'usuario_registrou_id' => auth()->user()->id,
                'valor_pago' => $request->input('valor_pagamento'),
                'data_pagamento' => $request->input('data_pagamento'),
                'observacao' => $request->input('observacoes'),
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Pagamento registrado com sucesso.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao registrar o pagamento: ' . $th->getMessage());
        }
    }

    public function detalhes(string $id)
    {
        $parcela = Parcela::find($id);

        $pagamento = $parcela->pagamento;
        $processo = $pagamento->processo;

        dd($pagamento, $processo);

        return response()->json([
            'processo' => $processo,
            'pagamento' => $pagamento,
            'informacoesPagamento' => $informacoesPagamento
        ]);
    }
}

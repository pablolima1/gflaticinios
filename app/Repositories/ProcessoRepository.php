<?php

namespace App\Repositories;

use App\Models\Pagamento;
use App\Models\Parcela;
use App\Models\ParcelaPagamento;
use App\Models\Processo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

use function Symfony\Component\Clock\now;

class ProcessoRepository
{
    public function all()
    {
        return Processo::orderBy('created_at', 'desc')->orderByDesc('created_at')->paginate(30);
    }

    public function allSemPaginacao()
    {
        return Processo::orderBy('numero_processo', 'asc')->get();
    }

    public function processosMesAno($mes, $ano)
    {
        $parcela = Parcela::with('pagamento', 'pagamento.cliente')
            ->whereYear('vencimento', $ano)
            ->whereMonth('vencimento', $mes)
            ->get();

        return $parcela;
    }

    public function find($id)
    {
        return Processo::find($id);
    }

    public function create($data)
    {
        try {
            DB::beginTransaction();

            $dataEntrada = Str::replace('/', '-', $data['date_entrada']);
            $dataEntrada = Carbon::parse($dataEntrada);

            $dataVencimento = Str::replace('/', '-', $data['data_vencimento_1parcela']);
            $dataVencimento = Carbon::parse($dataVencimento);

            $dataPagamento = $data['date_pagamento'] ? Str::replace('/', '-', $data['date_pagamento']) : null;
            $dataPagamento = $dataPagamento ? Carbon::parse($dataPagamento) : null;

            $valorEntrada = str_replace(['.', ','], ['', '.'], $data['valor_entrada'] ?? '0');
            $data['valor_entrada'] = (float) $valorEntrada;

            $valorParcelado = str_replace(['.', ','], ['', '.'], $data['valor_parcelado'] ?? '0');
            $data['valor_parcelado'] = (float) $valorParcelado;

            $processo = Processo::create([
                'cliente_id' => $data['cliente_id'],
                'usuario_responsavel_id' => auth()->user()->id,
                'numero_processo' => $data['numero_processo'],
                'esfera' => $data['esfera'],
                'tipo_processo_id' => $data['tipo_processo_id'],
                'subtipo_processo' => $data['subtipo_processo'],
                'observacao' => $data['observacao'] ?? null,
                'status' => $data['tipo_pagamento'] === 'avista' && $data['switcherPagoNoAto'] ? 'finalizado' : 'aberto'
            ]);

            if ($data['tipo_pagamento'] === 'aprazo') {

                $valorTotal = str_replace(['.', ','], ['', '.'], $data['valor_parcelado']) + str_replace(['.', ','], ['', '.'], $data['valor_entrada']);
                $valorTotal = (float) $valorTotal;

                $pagamento = Pagamento::create([
                    'cliente_id' => $data['cliente_id'],
                    'processo_id' => $processo->id,
                    'usuario_criador_id' => auth()->user()->id,
                    'valor_total' => $valorTotal,
                    'valor_entrada' => $data['valor_entrada'] ?? 0,
                    'valor_parcelado' => $data['valor_parcelado'] ?? 0,
                    'quantidade_parcelas' => $data['quantidade_parcelas'] ?? 1,
                    'data_pagamento_entrada' => $dataEntrada,
                    'dia_vencimento_primeira_parcela' => $dataVencimento->day,
                ]);

                $valor_parcela = $data['valor_parcelado'] / $data['quantidade_parcelas'];
                $data_vencimento = $dataVencimento;

                if ($data['valor_entrada'] > 0) {
                    // Criar parcela da entrada como paga
                    Parcela::create([
                        'pagamento_id' => $pagamento->id,
                        'numero_parcela' => 0,
                        'valor_parcela' => $data['valor_entrada'],
                        'valor_restante' => $data['valor_entrada'],
                        'vencimento' => $dataEntrada
                    ]);
                }
                $dia_vencimento = $data_vencimento->day;
                $mes_vencimento = $data_vencimento->month;
                $ano_vencimento = $data_vencimento->year;

                for ($i = 0; $i < $data['quantidade_parcelas']; $i++) {
                    // Calcula o mês e ano destino sem mexer no dia ainda
                    $data_base = Carbon::createFromDate($ano_vencimento, $mes_vencimento, 1)->addMonths($i);
                    
                    // Pega o menor valor entre o dia original e o último dia do mês destino
                    $dia_final = min($dia_vencimento, $data_base->daysInMonth);
                    
                    $data_parcela = Carbon::createFromDate($data_base->year, $data_base->month, $dia_final);
                    
                    Parcela::create([
                        'pagamento_id' => $pagamento->id,
                        'numero_parcela' => $i + 1,
                        'valor_parcela' => $valor_parcela,
                        'valor_restante' => $valor_parcela,
                        'vencimento' => $data_parcela,
                    ]);
                }
            } else if ($data['tipo_pagamento'] === 'avista') { // Criar parcela única

                $valorTotal = str_replace(['.', ','], ['', '.'], $data['valor_total']);
                $data['valor_total'] = (float) $valorTotal;

                $pagamento = Pagamento::create([
                    'cliente_id' => $data['cliente_id'],
                    'processo_id' => $processo->id,
                    'usuario_criador_id' => auth()->user()->id,
                    'valor_total' => $data['valor_total'],
                    'valor_entrada' => $data['valor_entrada'] ?? 0,
                    'valor_parcelado' => $data['valor_parcelado'] ?? 0,
                    'quantidade_parcelas' => $data['quantidade_parcelas'] ?? 1,
                    'dia_vencimento_primeira_parcela' => $dataVencimento->day,
                ]);

                if ($data['switcherPagoNoAto']) {

                    $parcela = Parcela::create([
                        'pagamento_id' => $pagamento->id,
                        'numero_parcela' => 1,
                        'valor_parcela' => $data['valor_total'],
                        'valor_restante' => 0,
                        'vencimento' => now(),
                        'status' => 'pago',
                    ]);

                    ParcelaPagamento::create([
                        'parcela_id' => $parcela->id,
                        'usuario_registrou_id' => auth()->user()->id,
                        'valor_pago' => $data['valor_total'],
                        'data_pagamento' => now(),

                    ]);
                } else {

                    Parcela::create([
                        'pagamento_id' => $pagamento->id,
                        'numero_parcela' => 1,
                        'valor_parcela' => $data['valor_total'],
                        'valor_restante' => $data['valor_total'],
                        'vencimento' => $dataPagamento,
                    ]);
                }
            }

            DB::commit();

            return $processo;
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            throw $th;
        }
    }

    public function update($id, array $data)
    {
        $processo = $this->find($id);
        if (!$processo) {
            return null;
        }
        $processo->update($data);
        return $processo;
    }

    public function delete($id)
    {
        $processo = $this->find($id);

        return $processo->delete();
    }

    public function deleteParcelasPagamentosByParcelasId($parcelaIds)
    {
        return ParcelaPagamento::whereIn('parcela_id', $parcelaIds)->delete();
    }

    public function deleteParcelasPagamentosByParcelaId($parcelaId)
    {
        return ParcelaPagamento::where('parcela_id', $parcelaId)->delete();
    }

    public function deleteParcelasByPagamentoId($pagamentoId)
    {
        return Parcela::where('pagamento_id', $pagamentoId)->delete();
    }

    public function deletePagamentosByProcessoId($processoId)
    {
        return Pagamento::where('processo_id', $processoId)->delete();
    }
}

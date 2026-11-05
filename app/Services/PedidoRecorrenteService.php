<?php

namespace App\Services;

use App\Models\Pedido;
use App\Models\PedidoRecorrente;
use App\Models\Produto;
use Carbon\CarbonImmutable;

class PedidoRecorrenteService
{
    public function gerarPedidos(PedidoRecorrente $recorrencia, Produto $produto): void
    {
        $datas = $this->gerarDatas($recorrencia);

        if ($datas !== []) {
            $recorrencia->update(['proxima_entrega' => $datas[0]->toDateString()]);
        }

        foreach ($datas as $dataEntrega) {
            $valorUnitario = (float) $produto->preco;
            $valorTotal = $valorUnitario * $recorrencia->quantidade;

            $pedido = Pedido::create([
                'cliente_id' => $recorrencia->cliente_id,
                'pedido_recorrente_id' => $recorrencia->id,
                'recorrente' => true,
                'data_entrega' => $dataEntrega->toDateString(),
                'status' => 'pendente',
                'observacoes' => 'Pedido gerado automaticamente por recorrência.',
                'valor_total' => $valorTotal,
            ]);

            $pedido->itensPedido()->create([
                'produto_id' => $produto->id,
                'quantidade' => $recorrencia->quantidade,
                'valor_unitario' => $valorUnitario,
                'valor_total' => $valorTotal,
            ]);
        }
    }

    public function gerarDatas(PedidoRecorrente $recorrencia): array
    {
        $inicio = CarbonImmutable::parse($recorrencia->data_inicio ?? $recorrencia->proxima_entrega)->startOfDay();
        $limite = $inicio->addMonthsNoOverflow(6);
        $datas = [];

        $diasAteOcorrencia = ((int) $recorrencia->dia_semana - $inicio->dayOfWeek + 7) % 7;
        $primeiraOcorrencia = $inicio->addDays($diasAteOcorrencia);

        if (in_array($recorrencia->frequencia, ['semanal', 'quinzenal'], true)) {
            $intervalo = $recorrencia->frequencia === 'semanal' ? 7 : 14;

            for ($data = $primeiraOcorrencia; $data->lessThanOrEqualTo($limite); $data = $data->addDays($intervalo)) {
                $datas[] = $data;
            }

            return $datas;
        }

        if ($recorrencia->frequencia === 'mensal') {
            $ordinalDiaSemana = intdiv($primeiraOcorrencia->day - 1, 7);

            for ($mes = 0; ; $mes++) {
                $mesAlvo = $primeiraOcorrencia->startOfMonth()->addMonthsNoOverflow($mes);
                $diasAteDiaEscolhido = ((int) $recorrencia->dia_semana - $mesAlvo->dayOfWeek + 7) % 7;
                $data = $mesAlvo->addDays($diasAteDiaEscolhido + ($ordinalDiaSemana * 7));

                if ($data->month !== $mesAlvo->month) {
                    $ultimoDiaMes = $mesAlvo->endOfMonth();
                    $diasDesdeDiaEscolhido = ($ultimoDiaMes->dayOfWeek - (int) $recorrencia->dia_semana + 7) % 7;
                    $data = $ultimoDiaMes->subDays($diasDesdeDiaEscolhido);
                }

                if ($data->greaterThan($limite)) {
                    break;
                }

                $datas[] = $data;
            }
        }

        return $datas;
    }
}
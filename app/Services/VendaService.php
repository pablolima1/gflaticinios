<?php

namespace App\Services;

use App\Models\Venda;
use App\Models\Pagamento;
use Illuminate\Support\Facades\DB;

class VendaService
{
    /**
     * Cria uma nova venda com seus itens e pagamento (se aplicável)
     * 
     * @param array $vendaData Dados da venda
     * @param array $itensData Itens da venda
     * @param array|null $pagamentoData Dados do pagamento (opcional)
     * @return Venda
     * @throws \Exception
     */
    public function criarVenda(array $vendaData, array $itensData, ?array $pagamentoData = null): Venda
    {
        return DB::transaction(function () use ($vendaData, $itensData, $pagamentoData) {
            // Cria a venda
            $venda = Venda::create($vendaData);

            // Cria os itens da venda
            foreach ($itensData as $item) {
                $venda->itensVenda()->create($item);
            }

            // Cria o pagamento se a venda for registrada como "pago"
            if ($pagamentoData) {
                $this->criarPagamento($venda, $pagamentoData);
            }

            return $venda;
        });
    }

    /**
     * Cria um registro de pagamento para uma venda
     * 
     * @param Venda $venda
     * @param array $pagamentoData
     * @return Pagamento
     */
    public function criarPagamento(Venda $venda, array $pagamentoData): Pagamento
    {
        return $venda->pagamentos()->create($pagamentoData);
    }

    /**
     * Registra um pagamento adicional em uma venda existente
     * 
     * @param Venda $venda
     * @param float $valor
     * @param string $formaPagamento
     * @param string|null $observacoes
     * @return Pagamento
     */
    public function adicionarPagamento(Venda $venda, float $valor, string $formaPagamento, ?string $observacoes = null): Pagamento
    {
        return $this->criarPagamento($venda, [
            'valor' => $valor,
            'forma_pagamento' => $formaPagamento,
            'data_pagamento' => now(),
            'observacoes' => $observacoes,
        ]);
    }

    /**
     * Verifica se uma venda pode ser atualizada para "pago"
     * 
     * @param Venda $venda
     * @return bool
     */
    public function podeMarcarComoPago(Venda $venda): bool
    {
        return $venda->status !== 'pago';
    }

    /**
     * Marca uma venda como paga registrando o pagamento final
     * 
     * @param Venda $venda
     * @param string $formaPagamento
     * @param string|null $observacoes
     * @return Venda
     */
    public function marcarComoPago(Venda $venda, string $formaPagamento = 'dinheiro', ?string $observacoes = null): Venda
    {
        return DB::transaction(function () use ($venda, $formaPagamento, $observacoes) {
            $saldoPendente = $venda->saldoPendente();

            if ($saldoPendente > 0) {
                $this->adicionarPagamento($venda, $saldoPendente, $formaPagamento, $observacoes);
            }

            $venda->update(['status' => 'pago']);

            return $venda;
        });
    }
}

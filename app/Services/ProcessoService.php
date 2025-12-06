<?php

namespace App\Services;

use App\Repositories\ProcessoRepository;

class ProcessoService
{
    protected $processoRepository;

    public function __construct(ProcessoRepository $processoRepository)
    {
        $this->processoRepository = $processoRepository;
    }

    public function all()
    {
        return $this->processoRepository->all();
    }

    public function allSemPaginacao()
    {
        return $this->processoRepository->allSemPaginacao();
    }

    public function find($id)
    {
        return $this->processoRepository->find($id);
    }

    public function create(array $data)
    {
        $validatedData = [
            'cliente_id' => $data['cliente_id'] ?? null,
            'numero_processo' => $data['numero_processo'] ?? null,
            'tipo_processo_id' => $data['tipo_processo_id'] ?? null,
            'esfera' => $data['esfera'] ?? null,
            'valor_total' => $data['valor_total'] ?? 0,
            'valor_entrada' => $data['valor_entrada'] ?? 0,
            'quantidade_parcelas' => $data['quantidade_parcelas'] ?? 1,
            'valor_parcelas' => $data['valor_parcelas'] ?? 0,
            'data_entrada' => $data['data_entrada'] ?? null,
            'responsavel_criacao' => auth()->user()->id,
        ];

        if (!$validatedData['cliente_id']) {
            throw new \Exception('Cliente é obrigatório');
        }

        if (!$validatedData['tipo_processo_id']) {
            throw new \Exception('Tipo de processo é obrigatório');
        }

        return $this->processoRepository->create($validatedData);
    }

    public function update($id, array $data)
    {
        $processo = $this->processoRepository->find($id);
        if (!$processo) {
            throw new \Exception('Processo not found');
        }

        $updateData = [
            'cliente_id' => $data['cliente_id'] ?? $processo->cliente_id,
            'numero_processo' => $data['numero_processo'] ?? $processo->numero_processo,
            'tipo_processo_id' => $data['tipo_processo_id'] ?? $processo->tipo_processo_id,
            'esfera' => $data['esfera'] ?? $processo->esfera,
            'valor_total' => $data['valor_total'] ?? $processo->valor_total,
            'valor_entrada' => $data['valor_entrada'] ?? $processo->valor_entrada,
            'quantidade_parcelas' => $data['quantidade_parcelas'] ?? $processo->quantidade_parcelas,
            'valor_parcelas' => $data['valor_parcelas'] ?? $processo->valor_parcelas,
            'data_entrada' => $data['data_entrada'] ?? $processo->data_entrada,
        ];

        return $this->processoRepository->update($id, $updateData);
    }

    public function delete($id)
    {
        $processo = $this->processoRepository->find($id);
        if (!$processo) {
            throw new \Exception('Processo not found');
        }

        return $this->processoRepository->delete($id);
    }
}
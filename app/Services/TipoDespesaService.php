<?php

namespace App\Services;

use App\Repositories\TipoDespesaRepository;

class TipoDespesaService
{
    protected $tipoDespesaRepository;

    public function __construct(TipoDespesaRepository $tipoDespesaRepository)
    {
        $this->tipoDespesaRepository = $tipoDespesaRepository;
    }

    public function all()
    {
        return $this->tipoDespesaRepository->all();
    }

    public function allSemPaginacao()
    {
        return $this->tipoDespesaRepository->allSemPaginacao();
    }

    public function find($id)
    {
        return $this->tipoDespesaRepository->find($id);
    }

    public function create(array $data)
    {
        $validatedData = [
            'nome' => $data['nome'] ?? null,
            'descricao' => $data['descricao'] ?? null
        ];

        if (!$validatedData['nome']) {
            throw new \Exception('Nome é obrigatório');
        }

        return $this->tipoDespesaRepository->create($validatedData);
    }

    public function update($id, array $data)
    {
        $tipoDespesa = $this->tipoDespesaRepository->find($id);
        if (!$tipoDespesa) {
            throw new \Exception('TipoDespesa not found');
        }

        $updateData = [
            'nome' => $data['nome'] ?? $tipoDespesa->nome,
            'descricao' => $data['descricao'] ?? $tipoDespesa->descricao,
        ];

        return $this->tipoDespesaRepository->update($id, $updateData);
    }

    public function delete($id)
    {
        $tipoDespesa = $this->tipoDespesaRepository->find($id);
        if (!$tipoDespesa) {
            throw new \Exception('TipoDespesa not found');
        }

        return $this->tipoDespesaRepository->delete($id);
    }
}

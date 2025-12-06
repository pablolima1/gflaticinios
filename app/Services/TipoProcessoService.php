<?php

namespace App\Services;

use App\Repositories\TipoProcessoRepository;

class TipoProcessoService
{
    protected $tipoProcessoRepository;

    public function __construct(TipoProcessoRepository $tipoProcessoRepository)
    {
        $this->tipoProcessoRepository = $tipoProcessoRepository;
    }

    public function all()
    {
        return $this->tipoProcessoRepository->all();
    }

    public function allSemPaginacao()
    {
        return $this->tipoProcessoRepository->allSemPaginacao();
    }

    public function find($id)
    {
        return $this->tipoProcessoRepository->find($id);
    }

    public function create(array $data)
    {
        $validatedData = [
            'nome' => $data['nome'] ?? null,
            'descricao' => $data['descricao'] ?? null,
            'responsavel_criacao' => auth()->user()->id,
        ];

        if (!$validatedData['nome']) {
            throw new \Exception('Nome é obrigatório');
        }

        return $this->tipoProcessoRepository->create($validatedData);
    }

    public function update($id, array $data)
    {
        $tipoProcesso = $this->tipoProcessoRepository->find($id);
        if (!$tipoProcesso) {
            throw new \Exception('TipoProcesso not found');
        }

        $updateData = [
            'nome' => $data['nome'] ?? $tipoProcesso->nome,
            'descricao' => $data['descricao'] ?? $tipoProcesso->descricao,
        ];

        return $this->tipoProcessoRepository->update($id, $updateData);
    }

    public function delete($id)
    {
        $tipoProcesso = $this->tipoProcessoRepository->find($id);
        if (!$tipoProcesso) {
            throw new \Exception('TipoProcesso not found');
        }

        return $this->tipoProcessoRepository->delete($id);
    }
}

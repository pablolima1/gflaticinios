<?php

namespace App\Services;

use App\Repositories\ClienteRepository;

class ClienteService
{
    protected $clienteRepository;

    public function __construct(ClienteRepository $clienteRepository)
    {
        $this->clienteRepository = $clienteRepository;
    }

    public function all()
    {
        return $this->clienteRepository->all();
    }

    public function allSemPaginacao()
    {
        return $this->clienteRepository->allSemPaginacao();
    }

    public function registerUser(array $data)
    {
        $data = [
            'nome' => $data['nome'],
            'cpf' => $data['cpf'],
            'rg' => $data['rg'] ?? null,
            'email' => $data['email'],
            'telefone' => $data['telefone'] ?? null,
            'responsavel_criacao' => auth()->user()->id,
        ];

        return $this->clienteRepository->create($data);
    }

    public function update(array $data, $id)
    {
        $cliente = $this->clienteRepository->find($id);
        if (!$cliente) {
            throw new \Exception('Cliente not found');
        }

        $cliente->nome = $data['nome'] ?? $cliente->nome;
        $cliente->cpf = $data['cpf'] ?? $cliente->cpf;
        $cliente->rg = $data['rg'] ?? $cliente->rg;
        $cliente->email = $data['email'] ?? $cliente->email;
        $cliente->telefone = $data['telefone'] ?? $cliente->telefone;

        $cliente->save();

        return $cliente;
    }

    public function find($id)
    {
        return $this->clienteRepository->find($id);
    }

    public function delete($id)
    {
        $cliente = $this->clienteRepository->find($id);
        if (!$cliente) {
            throw new \Exception('Cliente not found');
        }

        return $cliente->delete();
    }
}

<?php

namespace App\Services;

use App\Repositories\DespesaRepository;
use Carbon\Carbon;

class DespesaService
{
    protected $despesaRepository;

    public function __construct(DespesaRepository $despesaRepository)
    {
        $this->despesaRepository = $despesaRepository;
    }

    public function all()
    {
        return $this->despesaRepository->all();
    }

    public function allSemPaginacao()
    {
        return $this->despesaRepository->allSemPaginacao();
    }

    public function despesasMesAno($data)
    {
        $mes = '';
        $ano = '';

        if (!isset($data['mes']) || !isset($data['ano'])) {
            $mes = Carbon::now()->month;
            $ano = Carbon::now()->year;
        } else {
            $mes = $data['mes'];
            $ano = $data['ano'];
        }

        return $this->despesaRepository->despesasMesAno($mes, $ano);
    }

    public function store(array $data)
    {
        $dataDespesaFormat = str_replace('/', '-', $data['data_despesa']);
        $dataDespesa = date('Y-m-d', strtotime($dataDespesaFormat));

        $data = [
            'tipo_despesa_id' => $data['tipo_despesa_id'],
            'descricao' => $data['descricao'] ?? 'Descrição não informada',
            'valor' => $data['valor'],
            'data_despesa' => $dataDespesa,
            'status' => 'paga',
            'usuario_criador_id' => auth()->user()->id,
        ];

        return $this->despesaRepository->store($data);
    }

    public function update(array $data, $id)
    {
        $despesa = $this->despesaRepository->find($id);
        if (!$despesa) {
            throw new \Exception('Despesa not found');
        }

        $despesa->nome = $data['nome'] ?? $despesa->nome;
        $despesa->cpf = $data['cpf'] ?? $despesa->cpf;
        $despesa->rg = $data['rg'] ?? $despesa->rg;
        $despesa->email = $data['email'] ?? $despesa->email;
        $despesa->telefone = $data['telefone'] ?? $despesa->telefone;

        $despesa->save();

        return $despesa;
    }

    public function find($id)
    {
        return $this->despesaRepository->find($id);
    }

    public function delete($id)
    {
        $despesa = $this->despesaRepository->find($id);
        if (!$despesa) {
            throw new \Exception('Despesa not found');
        }

        return $despesa->delete();
    }
}

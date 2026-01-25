<?php

namespace App\Repositories;

use App\Models\Despesa;

class DespesaRepository
{
    public function all()
    {
        return Despesa::orderBy('nome', 'asc')->paginate(30);
    }

    public function despesasMesAno($mes, $ano)
    {
        $despesas = Despesa::whereYear('data_despesa', $ano)
            ->whereMonth('data_despesa', $mes)
            ->get();

        return $despesas;
    }

    public function allSemPaginacao()
    {
        return Despesa::orderBy('nome', 'asc')->get();
    }

    public function find($id)
    {
        return Despesa::find($id);
    }

    public function store(array $data)
    {
        return Despesa::create($data);
    }
}

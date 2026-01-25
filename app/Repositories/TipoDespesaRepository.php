<?php

namespace App\Repositories;

use App\Models\TipoDespesa;

class TipoDespesaRepository
{
    public function all()
    {
        return TipoDespesa::orderBy('created_at', 'desc')->paginate(10);
    }

    public function allSemPaginacao()
    {
        return TipoDespesa::orderBy('nome', 'asc')->get();
    }

    public function find($id)
    {
        return TipoDespesa::find($id);
    }

    public function create(array $data)
    {
        return TipoDespesa::create($data);
    }

    public function update($id, array $data)
    {
        $tipoDespesa = $this->find($id);
        if (!$tipoDespesa) {
            return null;
        }
        $tipoDespesa->update($data);
        return $tipoDespesa;
    }

    public function delete($id)
    {
        $tipoDespesa = $this->find($id);
        if (!$tipoDespesa) {
            return false;
        }
        return $tipoDespesa->delete();
    }
}

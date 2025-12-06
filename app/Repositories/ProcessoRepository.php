<?php

namespace App\Repositories;

use App\Models\Processo;

class ProcessoRepository
{
    public function all()
    {
        return Processo::orderBy('created_at', 'desc')->paginate(10);
    }

    public function allSemPaginacao()
    {
        return Processo::orderBy('numero_processo', 'asc')->get();
    }

    public function find($id)
    {
        return Processo::find($id);
    }

    public function create(array $data)
    {
        return Processo::create($data);
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
        if (!$processo) {
            return false;
        }
        return $processo->delete();
    }
}

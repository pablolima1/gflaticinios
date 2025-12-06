<?php

namespace App\Repositories;

use App\Models\TipoProcesso;

class TipoProcessoRepository
{
    public function all()
    {
        return TipoProcesso::orderBy('created_at', 'desc')->paginate(10);
    }

    public function allSemPaginacao()
    {
        return TipoProcesso::orderBy('nome', 'asc')->get();
    }

    public function find($id)
    {
        return TipoProcesso::find($id);
    }

    public function create(array $data)
    {
        return TipoProcesso::create($data);
    }

    public function update($id, array $data)
    {
        $tipoProcesso = $this->find($id);
        if (!$tipoProcesso) {
            return null;
        }
        $tipoProcesso->update($data);
        return $tipoProcesso;
    }

    public function delete($id)
    {
        $tipoProcesso = $this->find($id);
        if (!$tipoProcesso) {
            return false;
        }
        return $tipoProcesso->delete();
    }
}

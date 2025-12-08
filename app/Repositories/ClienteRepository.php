<?php

namespace App\Repositories;

use App\Models\Cliente;

class ClienteRepository
{
    public function all()
    {
        return Cliente::orderBy('nome', 'asc')->paginate(10);
    }

    public function allSemPaginacao()
    {
        return Cliente::orderBy('nome', 'asc')->get();
    }

    public function find($id)
    {
        return Cliente::find($id);
    }

    public function create(array $data)
    {
        return Cliente::create($data);
    }
}

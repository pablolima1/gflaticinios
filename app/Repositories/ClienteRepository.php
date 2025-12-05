<?php

namespace App\Repositories;

use App\Models\Cliente;

class ClienteRepository
{
    public function all()
    {
        return Cliente::orderBy('created_at', 'desc')->paginate(10);
    }

    public function allSemPaginacao()
    {
        return Cliente::all();
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

<?php

namespace App\Repositories;

use App\Models\Processo;

class ProcessoRepository
{
    public function all()
    {
        return Processo::orderBy('created_at', 'desc')->paginate(10);
    }
}

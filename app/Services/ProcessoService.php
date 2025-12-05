<?php

namespace App\Services;

use App\Repositories\ProcessoRepository;

class ProcessoService
{
    protected $processoRepository;

    public function __construct(ProcessoRepository $processoRepository)
    {
        $this->processoRepository = $processoRepository;
    }

    public function all()
    {
        return $this->processoRepository->all();
    }
}
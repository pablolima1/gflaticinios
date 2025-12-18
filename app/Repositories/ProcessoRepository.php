<?php

namespace App\Repositories;

use App\Models\Pagamento;
use App\Models\Parcela;
use App\Models\Processo;
use Symfony\Component\Process\Process;

class ProcessoRepository
{
    public function all()
    {
        return Processo::orderBy('created_at', 'desc')->paginate(5);
    }

    public function allSemPaginacao()
    {
        return Processo::orderBy('numero_processo', 'asc')->get();
    }

    public function processosMesAno($mes, $ano)
    {
        $parcela = Parcela::with('pagamento', 'pagamento.cliente')
            ->whereYear('vencimento', $ano)
            ->whereMonth('vencimento', $mes)
            ->get();

        return $parcela;
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

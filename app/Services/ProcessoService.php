<?php

namespace App\Services;

use App\Models\Processo;
use App\Repositories\ProcessoRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use function Symfony\Component\Clock\now;

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

    public function processosMesAno($data)
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

        return $this->processoRepository->processosMesAno($mes, $ano);
    }

    public function allSemPaginacao()
    {
        return $this->processoRepository->allSemPaginacao();
    }

    public function find($id)
    {
        return $this->processoRepository->find($id);
    }

    public function create($data)
    {
        return $this->processoRepository->create($data);
    }

    public function update($id, array $data)
    {
        $processo = $this->processoRepository->find($id);
        if (!$processo) {
            throw new \Exception('Processo not found');
        }

        $updateData = [
            'cliente_id' => $data['cliente_id'] ?? $processo->cliente_id,
            'numero_processo' => $data['numero_processo'] ?? $processo->numero_processo,
            'tipo_processo_id' => $data['tipo_processo_id'] ?? $processo->tipo_processo_id,
            'esfera' => $data['esfera'] ?? $processo->esfera,
            'valor_total' => $data['valor_total'] ?? $processo->valor_total,
            'valor_entrada' => $data['valor_entrada'] ?? $processo->valor_entrada,
            'quantidade_parcelas' => $data['quantidade_parcelas'] ?? $processo->quantidade_parcelas,
            'valor_parcelas' => $data['valor_parcelas'] ?? $processo->valor_parcelas,
            'data_entrada' => $data['data_entrada'] ?? $processo->data_entrada,
        ];

        return $this->processoRepository->update($id, $updateData);
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $processo = $this->processoRepository->find($id);
            $parcelas = $processo->pagamentos[0]->parcelas ?? [];
            $idsParcelas = $parcelas->pluck('id')->toArray();

            $this->processoRepository->deleteParcelasPagamentosByParcelasId($idsParcelas);
            $this->processoRepository->deleteParcelasByPagamentoId($processo->pagamentos[0]->id);
            $this->processoRepository->deletePagamentosByProcessoId($id);
            $this->processoRepository->delete($id);

            DB::commit();

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}

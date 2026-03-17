<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Meta extends Model
{
    use HasFactory;

    protected $table = 'metas';

    protected $fillable = [
        'valor_meta', 'data_inicio', 'data_fim', 'status'
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim' => 'date',
        'valor_meta' => 'decimal:2',
    ];

    /**
     * Retorna as vendas dentro do período da meta
     */
    public function vendasNoPeriodo()
    {
        return \App\Models\Venda::whereBetween('data_venda', [$this->data_inicio, $this->data_fim]);
    }

    /**
     * Soma o valor total das vendas no período da meta
     */
    public function progresso()
    {
        return $this->vendasNoPeriodo()->sum('valor_total');
    }
}

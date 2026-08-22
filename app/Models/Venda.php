<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Venda extends Model
{
    use HasFactory;

    protected $table = 'vendas';

    protected $fillable = [
        'cliente_id', 'usuario_id', 'data_venda', 'tipo_pagamento', 'status', 'valor_total', 'observacoes'
    ];

    protected $casts = [
        'data_venda' => 'datetime',
        'valor_total' => 'decimal:2',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function itensVenda()
    {
        return $this->hasMany(ItemVenda::class, 'venda_id');
    }

    public function pagamentos()
    {
        return $this->hasMany(Pagamento::class, 'venda_id');
    }

    protected static function booted()
    {
        static::deleting(function ($venda) {
            // Remove itens e pagamentos relacionados antes de excluir a venda
            $venda->itensVenda()->delete();
            $venda->pagamentos()->delete();
        });
    }

    /**
     * Escopo para filtrar vendas pendentes
     * (status = 'pendente' e tipo_pagamento = 'prazo')
     */
    public function scopePendentes($query)
    {
        return $query->where('status', 'pendente')->where('tipo_pagamento', 'prazo');
    }

    /**
     * Escopo para filtrar vendas por mês
     * $mes no formato 'YYYY-MM' ex: '2026-03'
     */
    public function scopeByMonth($query, $mes)
    {
        $inicio = Carbon::createFromFormat('Y-m', $mes)->startOfMonth();
        $fim = Carbon::createFromFormat('Y-m', $mes)->endOfMonth();
        
        return $query->whereBetween('data_venda', [$inicio, $fim]);
    }

    /**
     * Escopo para filtrar vendas finalizadas
     * (tipo_pagamento = 'vista' ou status = 'pago')
     */
    public function scopeFinalizadas($query)
    {
        return $query->where('tipo_pagamento', 'vista')->orWhere('status', 'pago');
    }

    /**
     * Calcula o total já pago em pagamentos
     */
    public function totalPago()
    {
        return $this->pagamentos()->sum('valor') ?? 0;
    }

    /**
     * Calcula o valor ainda pendente
     */
    public function saldoPendente()
    {
        return $this->valor_total - $this->totalPago();
    }

    /**
     * Retorna a meta vigente para a data da venda
     */
    public function metaVigente()
    {
        return \App\Models\Meta::where('data_inicio', '<=', $this->data_venda)
            ->where('data_fim', '>=', $this->data_venda)
            ->where('status', 'ativa')
            ->first();
    }
}

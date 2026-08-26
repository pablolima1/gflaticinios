<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'cliente_id',
        'data_entrega',
        'status',
        'observacoes',
        'valor_total',
        'entregue_em',
        'venda_id',
    ];

    protected $casts = [
        'data_entrega' => 'date',
        'valor_total' => 'decimal:2',
        'entregue_em' => 'datetime',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function itensPedido()
    {
        return $this->hasMany(ItemPedido::class, 'pedido_id');
    }

    public function getStatusOperacionalAttribute(): string
    {
        if ($this->status === 'entregue') {
            return 'entregue';
        }

        $hoje = now()->toDateString();
        $dataEntrega = $this->data_entrega?->toDateString();

        if ($dataEntrega && $dataEntrega < $hoje) {
            return 'atrasado';
        }

        if ($dataEntrega && $dataEntrega === $hoje) {
            return 'hoje';
        }

        return 'proximo';
    }

    public function scopeAtrasados($query)
    {
        return $query->where('status', '!=', 'entregue')
            ->whereDate('data_entrega', '<', now()->toDateString());
    }

    public function scopeParaHoje($query)
    {
        return $query->where('status', '!=', 'entregue')
            ->whereDate('data_entrega', now()->toDateString());
    }

    public function scopeProximos($query)
    {
        return $query->where('status', '!=', 'entregue')
            ->whereDate('data_entrega', '>', now()->toDateString());
    }

    protected static function booted(): void
    {
        static::saving(function (self $pedido) {
            if (! $pedido->valor_total && $pedido->relationLoaded('itensPedido')) {
                $pedido->valor_total = $pedido->itensPedido->sum('valor_total');
            }
        });
    }
}

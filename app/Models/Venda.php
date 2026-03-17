<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

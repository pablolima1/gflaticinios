<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    protected $table = 'pagamentos';

    protected $fillable = [
        'cliente_id',
        'usuario_criador_id',
        'valor_total',
        'valor_entrada',
        'valor_parcelado',
        'quantidade_parcelas',
        'data_pagamento_entrada',
        'dia_vencimento_primeira_parcela'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function criador()
    {
        return $this->belongsTo(User::class, 'usuario_criador_id');
    }

    public function parcelas()
    {
        return $this->hasMany(Parcela::class, 'pagamento_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParcelaPagamento extends Model
{
    protected $table = 'parcelas_pagamentos';

    protected $fillable = [
        'parcela_id',
        'usuario_registrou_id',
        'valor_pago',
        'data_pagamento',
        'observacao',
    ];

    public function parcela()
    {
        return $this->belongsTo(Parcela::class, 'parcela_id');
    }

    public function usuarioRegistrou()
    {
        return $this->belongsTo(User::class, 'usuario_registrou_id');
    }
}

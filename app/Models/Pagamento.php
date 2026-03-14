<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    use HasFactory;

    protected $table = 'pagamentos';

    protected $fillable = [
        'venda_id', 'valor', 'forma_pagamento', 'data_pagamento', 'observacoes'
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'data_pagamento' => 'datetime',
    ];

    public function venda()
    {
        return $this->belongsTo(Venda::class, 'venda_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrindeCliente extends Model
{
    use HasFactory;

    protected $table = 'brindes_clientes';

    protected $fillable = [
        'cliente_id', 'brinde_id', 'data_entrega', 'motivo'
    ];

    protected $casts = [
        'data_entrega' => 'date',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function brinde()
    {
        return $this->belongsTo(Brinde::class, 'brinde_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'cliente_id', 'data_entrega', 'status', 'observacoes'
    ];

    protected $casts = [
        'data_entrega' => 'date',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function itensPedido()
    {
        return $this->hasMany(ItemPedido::class, 'pedido_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoRecorrente extends Model
{
    use HasFactory;

    protected $table = 'pedidos_recorrentes';

    protected $fillable = [
        'cliente_id',
        'produto_id',
        'quantidade',
        'intervalo_dias',
        'frequencia',
        'dia_semana',
        'data_inicio',
        'proxima_entrega',
        'ativo',
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'proxima_entrega' => 'date',
        'dia_semana' => 'integer',
        'ativo' => 'boolean',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'produto_id');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'pedido_recorrente_id');
    }
}

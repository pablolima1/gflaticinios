<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';

    protected $fillable = [
        'nome', 'descricao', 'preco', 'unidade_medida', 'ativo'
    ];

    protected $casts = [
        'preco' => 'decimal:2',
        'ativo' => 'boolean',
    ];

    public function itensVenda()
    {
        return $this->hasMany(ItemVenda::class, 'produto_id');
    }

    public function itensPedido()
    {
        return $this->hasMany(ItemPedido::class, 'produto_id');
    }

    public function pedidosRecorrentes()
    {
        return $this->hasMany(PedidoRecorrente::class, 'produto_id');
    }
}

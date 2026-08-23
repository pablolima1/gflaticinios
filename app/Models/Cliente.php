<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'nome', 'telefone', 'email', 'data_nascimento', 'endereco', 'observacoes'
    ];

    protected $casts = [
        'data_nascimento' => 'date',
    ];

    public function vendas()
    {
        return $this->hasMany(Venda::class, 'cliente_id');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'cliente_id');
    }

    public function pedidosRecorrentes()
    {
        return $this->hasMany(PedidoRecorrente::class, 'cliente_id');
    }

    public function brindesClientes()
    {
        return $this->hasMany(BrindeCliente::class, 'cliente_id');
    }

    public function getAllClientes($search = null)
    {
        $query = Cliente::query();

        if ($search) {
            $query->where('nome', 'like', "%{$search}%")
                ->orWhere('telefone', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        }

        return $query->orderBy('nome')->paginate(100);
    }
}

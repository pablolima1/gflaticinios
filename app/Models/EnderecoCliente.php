<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnderecoCliente extends Model
{
    protected $table = 'enderecos_clientes';

    protected $fillable = [
        'cliente_id',
        'cep',
        'rua',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}

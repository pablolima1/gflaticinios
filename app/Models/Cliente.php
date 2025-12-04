<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'nome',
        'rg',
        'cpf',
        'telefone',
        'email',
        'responsavel_criacao'
    ];

    public function responsavelCriacao()
    {
        return $this->belongsTo(User::class, 'responsavel_criacao');
    }

    public function endereco()
    {
        return $this->hasOne(EnderecoCliente::class, 'cliente_id');
    }

    public function processos()
    {
        return $this->hasMany(Processo::class, 'cliente_id');
    }

    public function pagamentos()
    {
        return $this->hasMany(Pagamento::class, 'cliente_id');
    }
}
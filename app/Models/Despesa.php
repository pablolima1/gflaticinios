<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Despesa extends Model
{
    protected $fillable = [
        'tipo_despesa_id',
        'descricao',
        'valor',
        'data_despesa',
        'status',
        'usuario_criador_id',
    ];

    /**
     * A despesa pertence a um tipo
     */
    public function tipo()
    {
        return $this->belongsTo(TipoDespesa::class, 'tipo_despesa_id');
    }

    /**
     * A despesa foi criada por um usuário
     */
    public function usuarioCriador()
    {
        return $this->belongsTo(User::class, 'usuario_criador_id');
    }
}

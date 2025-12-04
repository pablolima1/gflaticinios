<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoProcesso extends Model
{
    protected $table = 'tipos_processos';

    protected $fillable = [
        'nome',
        'descricao',
        'responsavel_criacao',
    ];

    public function criador()
    {
        return $this->belongsTo(User::class, 'responsavel_criacao');
    }

    public function processos()
    {
        return $this->hasMany(Processo::class, 'tipo_processo_id');
    }
}

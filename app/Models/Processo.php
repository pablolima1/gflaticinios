<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Processo extends Model
{
    protected $table = 'processos';

    protected $fillable = [
        'cliente_id',
        'usuario_responsavel_id',
        'numero_processo',
        'esfera',
        'tipo_processo_id',
        'subtipo_processo',
        'observacao',
        'status'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function responsavel()
    {
        return $this->belongsTo(User::class, 'usuario_responsavel_id');
    }

    public function tipoProcesso()
    {
        return $this->belongsTo(TipoProcesso::class, 'tipo_processo_id');
    }

    public function pagamentos()
    {
        return $this->hasMany(Pagamento::class, 'processo_id');
    }

}

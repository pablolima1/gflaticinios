<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDespesa extends Model
{
    protected $table = 'tipos_despesas';

    protected $fillable = [
        'nome',
        'descricao',
    ];

    /**
     * Um tipo de despesa possui várias despesas
     */
    public function despesas()
    {
        return $this->hasMany(Despesa::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TipoDespesa;

class Despesa extends Model
{
    use HasFactory;

    protected $table = 'despesas';

    protected $fillable = [
        'descricao', 'valor', 'data_despesa', 'observacoes', 'tipo_despesa_id'
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'data_despesa' => 'date',
    ];

    public function tipo()
    {
        return $this->belongsTo(TipoDespesa::class, 'tipo_despesa_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brinde extends Model
{
    use HasFactory;

    protected $table = 'brindes';

    protected $fillable = [
        'nome', 'descricao', 'valor_estimado'
    ];

    protected $casts = [
        'valor_estimado' => 'decimal:2',
    ];

    public function brindesClientes()
    {
        return $this->hasMany(BrindeCliente::class, 'brinde_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parcela extends Model
{
    protected $table = 'parcelas';

    protected $fillable = [
        'pagamento_id',
        'numero_parcela',
        'valor_parcela',
        'valor_restante',
        'vencimento',
        'status'
    ];

    public function pagamento()
    {
        return $this->belongsTo(Pagamento::class, 'pagamento_id');
    }

    public function pagamentos()
    {
        return $this->hasMany(ParcelaPagamento::class, 'parcela_id');
    }
}

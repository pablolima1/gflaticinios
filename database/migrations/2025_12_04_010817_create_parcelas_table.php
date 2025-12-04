<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parcelas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pagamento_id')->constrained('pagamentos')->cascadeOnDelete();

            $table->integer('numero_parcela');
            $table->decimal('valor_parcela', 10, 2);
            $table->decimal('valor_restante', 10, 2);

            $table->date('vencimento');

            $table->enum('status', ['pendente', 'parcial', 'pago', 'vencido'])
                  ->default('pendente');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parcelas');
    }
};

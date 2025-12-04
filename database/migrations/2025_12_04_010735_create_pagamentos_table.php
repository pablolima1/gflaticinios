<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagamentos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cliente_id')->constrained('clientes')->cascadeOnDelete();
            $table->foreignId('usuario_criador_id')->constrained('users')->cascadeOnDelete();

            $table->decimal('valor_total', 10, 2);
            $table->decimal('valor_entrada', 10, 2)->default(0);
            $table->decimal('valor_parcelado', 10, 2)->default(0);
            $table->integer('quantidade_parcelas');

            $table->date('data_pagamento_entrada')->nullable();
            $table->integer('dia_vencimento_primeira_parcela');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagamentos');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->foreignId('usuario_id')->constrained('users');
            $table->dateTime('data_venda');
            $table->enum('tipo_pagamento', ['vista', 'prazo']);
            $table->enum('status', ['pendente', 'pago', 'cancelado']);
            $table->decimal('valor_total', 10, 2);
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendas');
    }
};

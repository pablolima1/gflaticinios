<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parcelas_pagamentos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('parcela_id')->constrained('parcelas')->cascadeOnDelete();
            $table->foreignId('usuario_registrou_id')->constrained('users')->cascadeOnDelete();

            $table->decimal('valor_pago', 10, 2);
            $table->date('data_pagamento');

            $table->text('observacao')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parcelas_pagamentos');
    }
};
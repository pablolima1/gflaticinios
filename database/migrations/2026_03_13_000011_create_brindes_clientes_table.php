<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('brindes_clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->foreignId('brinde_id')->constrained('brindes');
            $table->date('data_entrega');
            $table->string('motivo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brindes_clientes');
    }
};

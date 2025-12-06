<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('processos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->foreignId('usuario_responsavel_id')->constrained('users');
            $table->string('numero_processo')->nullable();
            $table->enum('esfera', ['judicial', 'extrajudicial']);
            $table->foreignId('tipo_processo_id')->constrained('tipos_processos');
            $table->string('subtipo_processo')->nullable();
            $table->text('observacao')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('processos');
    }
};
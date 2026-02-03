<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('despesas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_despesa_id')->constrained('tipos_despesas');
            $table->string('descricao');
            $table->decimal('valor', 10, 2);
            $table->date('data_despesa');
            $table->enum('status', ['pendente', 'paga'])->default('pendente');
            $table->foreignId('usuario_criador_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('despesas');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->foreignId('bairro_id')->nullable()->after('endereco')->constrained('bairros')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropForeign(['bairro_id']);
            $table->dropColumn('bairro_id');
        });
    }
};
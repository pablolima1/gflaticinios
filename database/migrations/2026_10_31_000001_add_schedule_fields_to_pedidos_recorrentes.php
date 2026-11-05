<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pedidos_recorrentes', function (Blueprint $table) {
            $table->string('frequencia', 20)->nullable()->after('intervalo_dias');
            $table->unsignedTinyInteger('dia_semana')->nullable()->after('frequencia');
            $table->date('data_inicio')->nullable()->after('dia_semana');
        });

        DB::table('pedidos_recorrentes')
            ->whereNull('data_inicio')
            ->update(['data_inicio' => DB::raw('proxima_entrega')]);
    }

    public function down(): void
    {
        Schema::table('pedidos_recorrentes', function (Blueprint $table) {
            $table->dropColumn(['frequencia', 'dia_semana', 'data_inicio']);
        });
    }
};
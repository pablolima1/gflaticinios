<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('despesas', function (Blueprint $table) {
            $table->unsignedBigInteger('tipo_despesa_id')->after('id');
            $table->foreign('tipo_despesa_id')->references('id')->on('tipos_despesas')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('despesas', function (Blueprint $table) {
            $table->dropForeign(['tipo_despesa_id']);
            $table->dropColumn('tipo_despesa_id');
        });
    }
};

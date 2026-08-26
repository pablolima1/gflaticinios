<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->decimal('valor_total', 12, 2)->nullable()->after('data_entrega');
            $table->timestamp('entregue_em')->nullable()->after('valor_total');
            $table->foreignId('venda_id')->nullable()->constrained('vendas')->nullOnDelete()->after('entregue_em');
            $table->index(['data_entrega', 'status']);
        });

        Schema::table('itens_pedido', function (Blueprint $table) {
            $table->decimal('valor_unitario', 12, 2)->default(0)->after('quantidade');
            $table->decimal('valor_total', 12, 2)->default(0)->after('valor_unitario');
        });
    }

    public function down(): void
    {
        Schema::table('itens_pedido', function (Blueprint $table) {
            $table->dropColumn(['valor_unitario', 'valor_total']);
        });

        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropIndex(['data_entrega', 'status']);
            $table->dropConstrainedForeignId('venda_id');
            $table->dropColumn(['valor_total', 'entregue_em', 'venda_id']);
        });
    }
};

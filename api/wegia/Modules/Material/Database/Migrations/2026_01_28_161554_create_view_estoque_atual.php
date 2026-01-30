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
        DB::statement("
            CREATE OR REPLACE VIEW view_estoque_atual AS
            SELECT
                tp.id_produto,
                mp.descricao AS nome_produto,
                t.id_almoxarifado,
                SUM(
                    CASE
                        WHEN tm.tipo = 'e' THEN tp.quantidade
                        WHEN tm.tipo = 's' THEN -tp.quantidade
                        ELSE 0
                    END
                ) AS estoque
            FROM material_transacao_produto tp
            JOIN material_transacao t ON tp.id_transacao = t.id_transacao
            JOIN material_tipo_movimentacao tm ON t.id_tipo_movimentacao = tm.id_tipo_movimentacao
            JOIN material_produto mp ON tp.id_produto = mp.id_produto
            GROUP BY tp.id_produto, mp.descricao, t.id_almoxarifado
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_estoque_atual');
    }
};

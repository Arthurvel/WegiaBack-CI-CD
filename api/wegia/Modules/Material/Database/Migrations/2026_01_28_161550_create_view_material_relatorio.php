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
            CREATE OR REPLACE VIEW view_material_relatorio AS
            SELECT
                t.id_transacao,
                tm.id_tipo_movimentacao,
                t.id_responsavel,
                a.id_almoxarifado,
                p.id_produto,
                t.id_parceiro,
                t.data,
                tm.nome AS tipo_movimentacao,
                tm.tipo,
                a.descricao AS almoxarifado,
                pa.nome AS parceiro,
                r.nome AS responsavel,
                p.descricao AS produto,
                u.descricao AS unidade,
                tp.quantidade,
                tp.valor_unitario,
                (tp.quantidade * tp.valor_unitario) AS total
            FROM material_transacao t
            JOIN material_transacao_produto tp ON tp.id_transacao = t.id_transacao
            JOIN material_produto p ON p.id_produto = tp.id_produto
            JOIN material_unidade u ON u.id_unidade = p.id_unidade
            JOIN material_almoxarifado a ON a.id_almoxarifado = t.id_almoxarifado
            JOIN material_parceiro pa ON pa.id_parceiro = t.id_parceiro
            JOIN pessoa r ON r.id_pessoa = t.id_responsavel
            JOIN material_tipo_movimentacao tm ON tm.id_tipo_movimentacao = t.id_tipo_movimentacao
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_material_relatorio');
    }
};

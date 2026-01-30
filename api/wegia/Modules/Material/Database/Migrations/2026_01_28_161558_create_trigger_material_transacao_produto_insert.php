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
        DB::unprepared("
            CREATE TRIGGER tr_material_transacao_produto_insert
            AFTER INSERT ON material_transacao_produto
            FOR EACH ROW
            BEGIN
                DECLARE v_responsavel INT;

                SELECT id_responsavel
                INTO v_responsavel
                FROM material_transacao
                WHERE id_transacao = NEW.id_transacao
                LIMIT 1;

                INSERT INTO material_transacao_produto_logs (
                    id_transacao_produto,
                    id_transacao,
                    id_produto,
                    quantidade,
                    valor_unitario,
                    id_usuario_acao,
                    acao,
                    data_acao
                ) VALUES (
                    NEW.id_transacao_produto,
                    NEW.id_transacao,
                    NEW.id_produto,
                    NEW.quantidade,
                    NEW.valor_unitario,
                    v_responsavel,
                    'create',
                    NOW()
                );
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS tr_material_transacao_produto_insert");
    }
};

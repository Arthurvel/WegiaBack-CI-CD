<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("
            CREATE OR REPLACE VIEW view_ultimo_despacho_por_memorando AS
            SELECT d.*,
                   m.titulo,
                   m.status_memorando,
                   m.id_pessoa AS criado_por,
                   p.nome AS origem
            FROM despacho d
            JOIN (
                SELECT id_memorando, MAX(data) AS max_data
                FROM despacho
                GROUP BY id_memorando
            ) latest
              ON d.id_memorando = latest.id_memorando
             AND d.data = latest.max_data
            JOIN memorando m ON m.id_memorando = d.id_memorando
            JOIN pessoa p ON p.id_pessoa = d.id_remetente
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS view_ultimo_despacho_por_memorando");
    }
};

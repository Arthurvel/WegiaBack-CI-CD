<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::unprepared("
            CREATE TRIGGER tr_despacho_aviso
            AFTER INSERT ON despacho
            FOR EACH ROW
            BEGIN
                DECLARE memorando_titulo TEXT;

                SELECT titulo INTO memorando_titulo
                FROM memorando
                WHERE id_memorando = NEW.id_memorando;

                INSERT INTO aviso (
                    id_pessoa,
                    titulo,
                    descricao,
                    url,
                    nivel,
                    ativo
                ) VALUES (
                    NEW.id_destinatario,
                    memorando_titulo,
                    CONCAT('Você recebeu um novo despacho do memorando: \"', memorando_titulo, '\"'),
                    CONCAT('/memorando/', NEW.id_memorando),
                    'info',
                    1
                );
            END
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS tr_despacho_aviso");
    }
};

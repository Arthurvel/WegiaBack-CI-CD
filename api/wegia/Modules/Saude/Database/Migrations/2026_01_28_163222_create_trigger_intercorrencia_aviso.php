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
            CREATE TRIGGER trg_intercorrencia_aviso
            AFTER INSERT ON saude_intercorrencia
            FOR EACH ROW
            BEGIN
                INSERT INTO aviso (id_pessoa, titulo, descricao, url, nivel)
                SELECT
                    p.id_pessoa,
                    CONCAT('Nova intercorrência registrada para o paciente ', pes.nome, ' ', IFNULL(pes.sobrenome, '')),
                    NEW.descricao,
                    CONCAT('/saude/ficha-medica/', NEW.id_fichamedica),
                    'info'
                FROM pessoa p
                    JOIN funcionario f ON p.id_pessoa = f.id_pessoa
                    JOIN perfil pf ON f.id_perfil = pf.id_perfil
                    JOIN perfil_permissao pp ON pf.id_perfil = pp.id_perfil
                    JOIN permissao prm ON pp.id_permissao = prm.id_permissao
                    JOIN saude_fichamedica sfm ON sfm.id_fichamedica = NEW.id_fichamedica
                    JOIN pessoa pes ON pes.id_pessoa = sfm.id_pessoa
                WHERE prm.nome = 'Visualizar Saúde Intercorrência'
                  AND f.id_funcionario <> NEW.id_funcionario;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trigger_intercorrencia_aviso');
    }
};

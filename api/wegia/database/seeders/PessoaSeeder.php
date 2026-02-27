<?php
namespace Database\Seeders;

use App\Models\Pessoa\Pessoa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PessoaSeeder extends Seeder{
    public function run(): void{
        Pessoa::firstOrCreate(
            ['id_pessoa' => 1],
            [
                'cpf' => 'admin',
                'senha' => 'wegia',
                'nome' => 'admin'
            ]
        );
    }
}

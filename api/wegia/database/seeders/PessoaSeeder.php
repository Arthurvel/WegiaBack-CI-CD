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
                'senha' => '9dcc9cbd309bfe63101c96687fb79ca847e9f238ce965f82eb44e8daf825cdbb',
                'nome' => 'admin'
            ]
        );
    }
}

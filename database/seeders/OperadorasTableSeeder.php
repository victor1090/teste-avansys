<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OperadorasTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('operadoras')->insert([
            'nome' => "Cielo",
            'descricao' => 'Operadora Cielo',
            'status' => true,
        ]);

        DB::table('operadoras')->insert([
            'nome' => "Mercado Pago",
            'descricao' => 'Operadora Mercado Pago',
            'status' => true,
        ]);
        DB::table('operadoras')->insert([
            'nome' => "Teste",
            'descricao' => 'Operadora Teste 1',
            'status' => true,
        ]);
    }
}

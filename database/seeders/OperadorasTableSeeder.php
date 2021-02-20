<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;

class OperadorasTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('operadora')->insert([
            'nome' => "Cielo",
            'descricao' => 'Operadora Cielo',
            'status' => true,
        ]);

        DB::table('operadora')->insert([
            'nome' => "Mercado Pago",
            'descricao' => 'Operadora Mercado Pago',
            'status' => true,
        ]);
    }
}

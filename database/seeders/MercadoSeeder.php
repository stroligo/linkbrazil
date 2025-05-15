<?php
// database/seeders/MercadoSeeder.php

namespace Database\Seeders;

use App\Models\Mercado;
use App\Models\Pais;
use Illuminate\Database\Seeder;

class MercadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $brasil = Pais::where('codigo', 'BR')->first();
        $portugal = Pais::where('codigo', 'PT')->first();

        $mercados = [
            [
                'nome' => 'Supermercado São Paulo',
                'pais_id' => $brasil->id,
                'telefone' => '(11) 3333-4444',
                'email' => 'contato@superpaulista.com',
                'cep' => '01001-000',
                'endereco' => 'Rua São Paulo',
                'numero' => '123',
                'complemento' => 'Loja 1',
                'bairro' => 'Centro',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'latitude' => -23.550520,
                'longitude' => -46.633308,
                'observacoes' => 'Supermercado localizado no centro da cidade',
                'ativo' => true,
            ],
            [
                'nome' => 'Mercado Lisboa',
                'pais_id' => $portugal->id,
                'telefone' => '+351 21 123 4567',
                'email' => 'contato@mercadolisboa.pt',
                'cep' => '1000-000',
                'endereco' => 'Rua Augusta',
                'numero' => '456',
                'complemento' => 'Loja 2',
                'bairro' => 'Baixa',
                'cidade' => 'Lisboa',
                'estado' => 'Lisboa',
                'latitude' => 38.722252,
                'longitude' => -9.139337,
                'observacoes' => 'Mercado tradicional em Lisboa',
                'ativo' => true,
            ],
            [
                'nome' => 'Supermercado Rio',
                'pais_id' => $brasil->id,
                'telefone' => '(21) 2222-3333',
                'email' => 'contato@superrio.com',
                'cep' => '20000-000',
                'endereco' => 'Avenida Rio Branco',
                'numero' => '789',
                'complemento' => 'Loja 3',
                'bairro' => 'Centro',
                'cidade' => 'Rio de Janeiro',
                'estado' => 'RJ',
                'latitude' => -22.906847,
                'longitude' => -43.172897,
                'observacoes' => 'Supermercado no centro do Rio',
                'ativo' => true,
            ],
        ];

        foreach ($mercados as $mercado) {
            Mercado::create($mercado);
        }
    }
}

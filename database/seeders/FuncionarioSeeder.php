<?php

namespace Database\Seeders;

use App\Models\Funcionario;
use App\Models\Mercado;
use Illuminate\Database\Seeder;

class FuncionarioSeeder extends Seeder
{
    public function run(): void
    {
        $mercados = Mercado::all();

        $funcionarios = [
            [
                'nome' => 'João Silva',
                'cpf' => '123.456.789-00',
                'email' => 'joao.silva@linkbrazil.com',
                'telefone' => '(11) 99999-1111',
                'cargo' => 'Gerente',
                'nivel_acesso' => 'gerente',
                'mercado_id' => $mercados->where('nome', 'Supermercado São Paulo')->first()->id,
                'data_admissao' => '2024-01-01',
                'salario' => 5000.00,
                'status' => true,
            ],
            [
                'nome' => 'Maria Santos',
                'cpf' => '987.654.321-00',
                'email' => 'maria.santos@linkbrazil.com',
                'telefone' => '(11) 99999-2222',
                'cargo' => 'Caixa',
                'nivel_acesso' => 'funcionario',
                'mercado_id' => $mercados->where('nome', 'Supermercado São Paulo')->first()->id,
                'data_admissao' => '2024-02-01',
                'salario' => 2500.00,
                'status' => true,
            ],
            [
                'nome' => 'Pedro Oliveira',
                'cpf' => '456.789.123-00',
                'email' => 'pedro.oliveira@linkbrazil.com',
                'telefone' => '(21) 99999-3333',
                'cargo' => 'Gerente',
                'nivel_acesso' => 'gerente',
                'mercado_id' => $mercados->where('nome', 'Supermercado Rio')->first()->id,
                'data_admissao' => '2024-01-15',
                'salario' => 5000.00,
                'status' => true,
            ],
            [
                'nome' => 'Ana Costa',
                'cpf' => '789.123.456-00',
                'email' => 'ana.costa@linkbrazil.com',
                'telefone' => '+351 91 123 4567',
                'cargo' => 'Gerente',
                'nivel_acesso' => 'gerente',
                'mercado_id' => $mercados->where('nome', 'Mercado Lisboa')->first()->id,
                'data_admissao' => '2024-01-10',
                'salario' => 4000.00,
                'status' => true,
            ],
            [
                'nome' => 'Carlos Ferreira',
                'cpf' => '321.654.987-00',
                'email' => 'carlos.ferreira@linkbrazil.com',
                'telefone' => '+351 91 987 6543',
                'cargo' => 'Caixa',
                'nivel_acesso' => 'funcionario',
                'mercado_id' => $mercados->where('nome', 'Mercado Lisboa')->first()->id,
                'data_admissao' => '2024-02-15',
                'salario' => 2000.00,
                'status' => true,
            ],
        ];

        foreach ($funcionarios as $funcionario) {
            Funcionario::create($funcionario);
        }
    }
} 
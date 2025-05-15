<?php

namespace Database\Factories;

use App\Models\Funcionario;
use App\Models\Mercado;
use Illuminate\Database\Eloquent\Factories\Factory;

class FuncionarioFactory extends Factory
{
    protected $model = Funcionario::class;

    public function definition()
    {
        $mercado = Mercado::inRandomOrder()->first() ?? Mercado::factory()->create();
        $niveisAcesso = ['administrador', 'gerente', 'funcionario'];

        return [
            'nome' => $this->faker->name(),
            'cargo' => $this->faker->jobTitle(),
            'nivel_acesso' => $this->faker->randomElement($niveisAcesso),
            'telefone' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'cpf' => $this->faker->numerify('###.###.###-##'),
            'data_admissao' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'salario' => $this->faker->randomFloat(2, 1500, 5000),
            'mercado_id' => $mercado->id,
            'status' => $this->faker->boolean(80), // 80% de chance de ser ativo
        ];
    }
} 
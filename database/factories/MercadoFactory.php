<?php
// database/factories/MercadoFactory.php

namespace Database\Factories;

use App\Models\Mercado;
use App\Models\Pais;
use Illuminate\Database\Eloquent\Factories\Factory;

class MercadoFactory extends Factory
{
    protected $model = Mercado::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $pais = Pais::inRandomOrder()->first() ?? Pais::factory()->create();

        return [
            'nome' => $this->faker->company(),
            'pais_id' => $pais->id,
            'telefone' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'cep' => $this->faker->postcode(),
            'endereco' => $this->faker->streetName(),
            'numero' => $this->faker->buildingNumber(),
            'complemento' => $this->faker->optional()->secondaryAddress(),
            'bairro' => $this->faker->cityPrefix(),
            'cidade' => $this->faker->city(),
            'estado' => $this->faker->state(),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'observacoes' => $this->faker->optional()->sentence(),
            'ativo' => $this->faker->boolean(80), // 80% de chance de ser ativo
        ];
    }
}

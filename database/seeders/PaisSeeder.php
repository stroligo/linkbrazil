<?php

namespace Database\Seeders;

use App\Models\Pais;
use Illuminate\Database\Seeder;

class PaisSeeder extends Seeder
{
    public function run(): void
    {
        $paises = [
            [
                'nome' => 'Brasil',
                'codigo' => 'BR',
                'codigo_telefone' => '+55',
            ],
            [
                'nome' => 'Estados Unidos',
                'codigo' => 'US',
                'codigo_telefone' => '+1',
            ],
            [
                'nome' => 'Portugal',
                'codigo' => 'PT',
                'codigo_telefone' => '+351',
            ],
            [
                'nome' => 'Espanha',
                'codigo' => 'ES',
                'codigo_telefone' => '+34',
            ],
            [
                'nome' => 'França',
                'codigo' => 'FR',
                'codigo_telefone' => '+33',
            ],
            [
                'nome' => 'Alemanha',
                'codigo' => 'DE',
                'codigo_telefone' => '+49',
            ],
            [
                'nome' => 'Itália',
                'codigo' => 'IT',
                'codigo_telefone' => '+39',
            ],
            [
                'nome' => 'Reino Unido',
                'codigo' => 'GB',
                'codigo_telefone' => '+44',
            ],
        ];

        foreach ($paises as $pais) {
            Pais::create($pais);
        }
    }
} 
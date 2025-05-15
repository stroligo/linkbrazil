<?php

// app/Models/Mercado.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mercado extends Model
{
    use HasFactory;

    // Definir a tabela associada ao model, se for diferente do plural do nome do model
    protected $table = 'mercados';

    // Definir os campos que podem ser preenchidos em massa
    protected $fillable = [
        'nome',
        'pais_id',
        'gerente_id',
        'telefone',
        'email',
        'cep',
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'latitude',
        'longitude',
        'observacoes',
        'ativo'
    ];

    // Definir se deseja usar timestamps (já está ativado por padrão)
    public $timestamps = true;

    protected $casts = [
        'ativo' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function pais()
    {
        return $this->belongsTo(Pais::class);
    }

    public function gerente()
    {
        return $this->belongsTo(Funcionario::class, 'gerente_id');
    }

    public function funcionarios()
    {
        return $this->hasMany(Funcionario::class);
    }
}

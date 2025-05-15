<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;

    protected $table = 'funcionarios';

    protected $fillable = [
        'nome',
        'cargo',
        'nivel_acesso',
        'telefone',
        'email',
        'cpf',
        'data_admissao',
        'salario',
        'mercado_id',
        'status',
    ];

    protected $casts = [
        'data_admissao' => 'date',
        'salario' => 'decimal:2',
        'status' => 'boolean',
    ];

    public function mercado()
    {
        return $this->belongsTo(Mercado::class);
    }

    public function mercadosGerenciados()
    {
        return $this->hasMany(Mercado::class, 'gerente_id');
    }
} 
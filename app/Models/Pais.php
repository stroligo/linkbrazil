<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    use HasFactory;

    protected $table = 'paises';

    protected $fillable = [
        'nome',
        'codigo',
        'codigo_telefone',
        'ativo'
    ];

    protected $casts = [
        'ativo' => 'boolean'
    ];

    public function mercados()
    {
        return $this->hasMany(Mercado::class);
    }
} 
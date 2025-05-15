<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mercados', function (Blueprint $table) {
            $table->foreignId('pais_id')->after('id')->constrained('paises');
            $table->string('cep')->after('endereco')->nullable();
            $table->string('numero')->after('endereco')->nullable();
            $table->string('complemento')->after('endereco')->nullable();
            $table->string('bairro')->after('endereco')->nullable();
            $table->string('cidade')->after('endereco')->nullable();
            $table->string('estado')->after('endereco')->nullable();
            $table->string('latitude')->after('endereco')->nullable();
            $table->string('longitude')->after('endereco')->nullable();
            $table->text('observacoes')->after('endereco')->nullable();
            $table->foreignId('gerente_id')->after('id')->nullable()->constrained('funcionarios');
        });
    }

    public function down(): void
    {
        Schema::table('mercados', function (Blueprint $table) {
            $table->dropForeign(['pais_id']);
            $table->dropForeign(['gerente_id']);
            $table->dropColumn([
                'pais_id',
                'cep',
                'numero',
                'complemento',
                'bairro',
                'cidade',
                'estado',
                'latitude',
                'longitude',
                'observacoes',
                'gerente_id'
            ]);
        });
    }
}; 
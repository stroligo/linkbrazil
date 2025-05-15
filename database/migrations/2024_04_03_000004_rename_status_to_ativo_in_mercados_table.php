<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mercados', function (Blueprint $table) {
            $table->renameColumn('status', 'ativo');
        });
    }

    public function down(): void
    {
        Schema::table('mercados', function (Blueprint $table) {
            $table->renameColumn('ativo', 'status');
        });
    }
}; 
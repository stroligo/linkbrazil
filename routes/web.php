<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Painel\MercadoController;
use App\Http\Controllers\Painel\FuncionarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

// Área administrativa protegida por autenticação
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard principal
    Route::get('/painel', function () {
        return view('painel.index');
    })->name('painel');

    // CRUD de Mercados (Agrupado dentro de /painel)
    Route::prefix('painel')->name('painel.')->group(function () {
        Route::resource('mercados', MercadoController::class);
        Route::resource('funcionarios', FuncionarioController::class);
    });

    // Rotas de perfil do usuário
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });
});

// Autenticação (Laravel Breeze ou Jetstream)
require __DIR__ . '/auth.php';

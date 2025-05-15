<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\MercadoController;
use App\Http\Controllers\Api\FuncionarioController;

Route::get('/', function () {
    return 'API Rodando!';
});

// Rotas para a API de Mercados
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/mercados', [MercadoController::class, 'index']);
    Route::get('/mercados/{mercado}', [MercadoController::class, 'show']);
    Route::post('/mercados', [MercadoController::class, 'store']);
    Route::put('/mercados/{mercado}', [MercadoController::class, 'update']);
    Route::delete('/mercados/{mercado}', [MercadoController::class, 'destroy']);

    // Rotas para a API de Funcionários
    Route::get('/funcionarios', [FuncionarioController::class, 'index']);
    Route::post('/funcionarios', [FuncionarioController::class, 'store']);
    Route::put('/funcionarios/{funcionario}', [FuncionarioController::class, 'update']);
    Route::delete('/funcionarios/{funcionario}', [FuncionarioController::class, 'destroy']);
});
// Registro de usuário
Route::post('/register', [RegisteredUserController::class, 'store']);
// Login de usuário (cria a sessão)
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
// Logout de usuário (remove a sessão)
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth:sanctum');

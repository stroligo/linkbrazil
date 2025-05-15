<?php

namespace App\Http\Controllers\Api;

use App\Models\Funcionario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FuncionarioController extends Controller
{
    public function index()
    {
        $funcionarios = Funcionario::with('mercado')->get();
        return response()->json($funcionarios);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'cpf' => 'required|string|max:14|unique:funcionarios',
            'data_admissao' => 'required|date',
            'salario' => 'required|numeric|min:0',
            'mercado_id' => 'required|exists:mercados,id',
            'status' => 'nullable|boolean',
        ]);

        $funcionario = Funcionario::create($validatedData);

        return response()->json([
            'message' => 'Funcionário criado com sucesso!',
            'funcionario' => $funcionario
        ], 201);
    }

    public function update(Request $request, Funcionario $funcionario)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'cpf' => 'required|string|max:14|unique:funcionarios,cpf,' . $funcionario->id,
            'data_admissao' => 'required|date',
            'salario' => 'required|numeric|min:0',
            'mercado_id' => 'required|exists:mercados,id',
            'status' => 'nullable|boolean',
        ]);

        $funcionario->update($validatedData);

        return response()->json([
            'message' => 'Funcionário atualizado com sucesso!',
            'funcionario' => $funcionario
        ]);
    }

    public function destroy(Funcionario $funcionario)
    {
        $funcionario->delete();

        return response()->json([
            'message' => 'Funcionário excluído com sucesso!'
        ]);
    }
} 
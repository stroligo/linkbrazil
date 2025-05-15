<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Models\Mercado;
use Illuminate\Http\Request;

class FuncionarioController extends Controller
{
    public function index()
    {
        $funcionarios = Funcionario::with('mercado')->latest()->paginate(10);
        return view('painel.funcionarios.index', compact('funcionarios'));
    }

    public function create()
    {
        $mercados = Mercado::where('status', true)->get();
        return view('painel.funcionarios.create', compact('mercados'));
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

        Funcionario::create($validatedData);

        return redirect()->route('painel.funcionarios.index')
            ->with('success', 'Funcionário criado com sucesso!');
    }

    public function edit(Funcionario $funcionario)
    {
        $mercados = Mercado::where('status', true)->get();
        return view('painel.funcionarios.edit', compact('funcionario', 'mercados'));
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

        $validatedData['status'] = $request->has('status') ? 1 : 0;

        $funcionario->update($validatedData);

        return redirect()->route('painel.funcionarios.index')
            ->with('success', 'Funcionário atualizado com sucesso!');
    }

    public function destroy(Funcionario $funcionario)
    {
        $funcionario->delete();

        return redirect()->route('painel.funcionarios.index')
            ->with('success', 'Funcionário excluído com sucesso!');
    }
} 
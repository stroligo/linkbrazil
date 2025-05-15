<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Models\Funcionario;
use App\Models\Mercado;
use Illuminate\Http\Request;

class FuncionarioController extends Controller
{
    public function index(Request $request)
    {
        $query = Funcionario::with('mercado');

        // Busca por nome, email ou telefone
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telefone', 'like', "%{$search}%");
            });
        }

        // Filtro por mercado
        if ($request->has('mercado_id') && $request->mercado_id) {
            $query->where('mercado_id', $request->mercado_id);
        }

        // Filtro por status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $funcionarios = $query->latest()->paginate(10);
        $mercados = Mercado::where('ativo', true)->orderBy('nome')->get();

        return view('painel.funcionarios.index', compact('funcionarios', 'mercados'));
    }

    public function create()
    {
        $mercados = Mercado::where('ativo', true)->orderBy('nome')->get();
        return view('painel.funcionarios.create', compact('mercados'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'nivel_acesso' => 'required|in:admin,gerente,funcionario',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:funcionarios',
            'cpf' => 'required|string|max:14|unique:funcionarios',
            'data_admissao' => 'required|date',
            'salario' => 'required|numeric|min:0',
            'mercado_id' => 'required|exists:mercados,id',
            'status' => 'boolean'
        ]);

        Funcionario::create($validated);

        return redirect()->route('painel.funcionarios.index')
            ->with('success', 'Funcionário criado com sucesso.');
    }

    public function edit(Funcionario $funcionario)
    {
        $mercados = Mercado::where('ativo', true)->orderBy('nome')->get();
        return view('painel.funcionarios.edit', compact('funcionario', 'mercados'));
    }

    public function update(Request $request, Funcionario $funcionario)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'nivel_acesso' => 'required|in:admin,gerente,funcionario',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:funcionarios,email,' . $funcionario->id,
            'cpf' => 'required|string|max:14|unique:funcionarios,cpf,' . $funcionario->id,
            'data_admissao' => 'required|date',
            'salario' => 'required|numeric|min:0',
            'mercado_id' => 'required|exists:mercados,id',
            'status' => 'boolean'
        ]);

        $funcionario->update($validated);

        return redirect()->route('painel.funcionarios.index')
            ->with('success', 'Funcionário atualizado com sucesso.');
    }

    public function destroy(Funcionario $funcionario)
    {
        $funcionario->delete();

        return redirect()->route('painel.funcionarios.index')
            ->with('success', 'Funcionário excluído com sucesso.');
    }
} 
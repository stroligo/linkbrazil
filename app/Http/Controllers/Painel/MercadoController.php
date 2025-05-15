<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Models\Mercado;
use App\Models\Pais;
use App\Models\Funcionario;
use Illuminate\Http\Request;

class MercadoController extends Controller
{
    public function edit(Mercado $mercado)
    {
        $paises = Pais::where('ativo', true)->orderBy('nome')->get();
        $gerentes = Funcionario::where('nivel_acesso', 'gerente')
                              ->where('status', true)
                              ->orderBy('nome')
                              ->get();
            
        return view('painel.mercados.edit', compact('mercado', 'paises', 'gerentes'));
    }

    public function update(Request $request, Mercado $mercado)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'pais_id' => 'required|exists:paises,id',
            'gerente_id' => 'nullable|exists:funcionarios,id',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'cep' => 'nullable|string|max:20',
            'endereco' => 'required|string|max:255',
            'numero' => 'nullable|string|max:20',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'nullable|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:100',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'observacoes' => 'nullable|string',
            'status' => 'boolean'
        ]);

        $mercado->update($validated);

        return redirect()->route('painel.mercados.index')
            ->with('success', 'Mercado atualizado com sucesso.');
    }

    public function create()
    {
        $paises = Pais::where('ativo', true)->orderBy('nome')->get();
        $gerentes = Funcionario::where('nivel_acesso', 'gerente')
                              ->where('status', true)
                              ->orderBy('nome')
                              ->get();
        return view('painel.mercados.create', compact('paises', 'gerentes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'pais_id' => 'required|exists:paises,id',
            'gerente_id' => 'nullable|exists:funcionarios,id',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'cep' => 'nullable|string|max:20',
            'endereco' => 'required|string|max:255',
            'numero' => 'nullable|string|max:20',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'nullable|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:100',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'observacoes' => 'nullable|string',
            'status' => 'boolean'
        ]);

        Mercado::create($validated);

        return redirect()->route('painel.mercados.index')
            ->with('success', 'Mercado criado com sucesso.');
    }

    public function index(Request $request)
    {
        $query = Mercado::with('pais');

        // Busca por nome, email ou telefone
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telefone', 'like', "%{$search}%");
            });
        }

        // Filtro por país
        if ($request->filled('pais_id')) {
            $query->where('pais_id', $request->pais_id);
        }

        // Filtro por status
        if ($request->filled('status')) {
            $query->where('ativo', $request->status);
        }

        $mercados = $query->orderBy('nome')->paginate(10);
        $paises = Pais::where('ativo', true)->orderBy('nome')->get();

        return view('painel.mercados.index', compact('mercados', 'paises'));
    }

    public function destroy(Mercado $mercado)
    {
        $mercado->delete();

        return redirect()->route('painel.mercados.index')
            ->with('success', 'Mercado excluído com sucesso.');
    }
} 
<?php

namespace App\Http\Controllers;

use App\Models\Mercado;
use App\Models\Pais;
use App\Models\Funcionario;
use Illuminate\Http\Request;

class MercadoController extends Controller
{
    // Exibe a lista de mercados
    public function index(Request $request)
    {
        $query = Mercado::with(['pais', 'gerente']);

        // Busca por nome
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nome', 'like', "%{$search}%");
        }

        // Filtro por país
        if ($request->has('pais_id') && $request->pais_id) {
            $query->where('pais_id', $request->pais_id);
        }

        // Filtro por status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $mercados = $query->latest()->paginate(10);
        $paises = Pais::where('ativo', true)->orderBy('nome')->get();

        return view('painel.mercados.index', compact('mercados', 'paises'));
    }

    // Exibe o formulário de criação de mercado
    public function create()
    {
        $paises = Pais::where('ativo', true)->orderBy('nome')->get();
        $gerentes = Funcionario::where('nivel_acesso', 'gerente')
            ->where('status', true)
            ->orderBy('nome')
            ->get();
        return view('painel.mercados.create', compact('paises', 'gerentes'));
    }

    // Salva o novo mercado
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'pais_id' => 'required|exists:paises,id',
            'endereco' => 'required|string|max:255',
            'cep' => 'nullable|string|max:9',
            'numero' => 'nullable|string|max:20',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:100',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'observacoes' => 'nullable|string',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'gerente_id' => 'nullable|exists:funcionarios,id',
            'status' => 'nullable|boolean',
        ]);

        Mercado::create($validatedData);

        return redirect()->route('painel.mercados.index')
            ->with('success', 'Mercado criado com sucesso!');
    }

    // Exibe o formulário de edição do mercado
    public function edit(Mercado $mercado)
    {
        $paises = Pais::where('ativo', true)->orderBy('nome')->get();
        $gerentes = Funcionario::where('nivel_acesso', 'gerente')
            ->where('status', true)
            ->orderBy('nome')
            ->get();
        return view('painel.mercados.edit', compact('mercado', 'paises', 'gerentes'));
    }

    // Atualiza um mercado existente
    public function update(Request $request, Mercado $mercado)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'pais_id' => 'required|exists:paises,id',
            'endereco' => 'required|string|max:255',
            'cep' => 'nullable|string|max:9',
            'numero' => 'nullable|string|max:20',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:100',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'observacoes' => 'nullable|string',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'gerente_id' => 'nullable|exists:funcionarios,id',
            'status' => 'nullable|boolean',
        ]);

        $mercado->update($validatedData);

        return redirect()->route('painel.mercados.index')
            ->with('success', 'Mercado atualizado com sucesso!');
    }

    // Exclui um mercado
    public function destroy(Mercado $mercado)
    {
        $mercado->delete();

        return redirect()->route('painel.mercados.index')
            ->with('success', 'Mercado excluído com sucesso!');
    }
}

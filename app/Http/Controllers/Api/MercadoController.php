<?php

namespace App\Http\Controllers\Api;

use App\Models\Mercado;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MercadoController extends Controller
{
    // Exibe a lista de mercados (API)
    public function index()
    {
        $mercados = Mercado::all();
        return response()->json($mercados);
    }

    // Salva o novo mercado (API)
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'gerente' => 'nullable|string|max:255',
            'status' => 'nullable|boolean',
        ]);

        $mercado = Mercado::create($validatedData);

        return response()->json([
            'message' => 'Mercado criado com sucesso!',
            'mercado' => $mercado
        ], 201);
    }

    // Atualiza um mercado existente (API)
    public function update(Request $request, Mercado $mercado)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'gerente' => 'nullable|string|max:255',
            'status' => 'nullable|boolean',
        ]);

        $mercado->update($validatedData);

        return response()->json([
            'message' => 'Mercado atualizado com sucesso!',
            'mercado' => $mercado
        ]);
    }

    // Exclui um mercado (API)
    public function destroy(Mercado $mercado)
    {
        $mercado->delete();

        return response()->json([
            'message' => 'Mercado excluído com sucesso!'
        ]);
    }
}

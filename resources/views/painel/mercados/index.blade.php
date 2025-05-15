<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Mercados') }}
            </h2>
            <a href="{{ route('painel.mercados.create') }}" class="btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Novo Mercado
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Filtros -->
                    <div class="mb-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <form method="GET" action="{{ route('painel.mercados.index') }}" class="space-y-4">
                            <!-- Linha de busca e botão de filtro -->
                            <div class="flex items-center space-x-4">
                                <div class="flex-1">
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                        </div>
                                        <x-text-input id="search" name="search" type="text" class="pl-10 form-input" :value="request('search')" placeholder="Buscar por nome, email ou telefone" />
                                    </div>
                                </div>
                                
                                <div class="flex space-x-2">
                                    <button type="button" id="toggle-filters" class="btn-secondary">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                        </svg>
                                        Filtros
                                    </button>
                                    
                                    @if(request('search') || request('pais_id') || request('status'))
                                        <a href="{{ route('painel.mercados.index') }}" class="btn-secondary">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                            Limpar Filtros
                                        </a>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Opções de filtro (inicialmente ocultas) -->
                            <div id="filter-options" class="hidden grid grid-cols-1 md:grid-cols-3 gap-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                                <div>
                                    <x-input-label for="pais_id" :value="__('País')" />
                                    <select id="pais_id" name="pais_id" class="form-select">
                                        <option value="">Todos os países</option>
                                        @foreach($paises as $pais)
                                            <option value="{{ $pais->id }}" {{ request('pais_id') == $pais->id ? 'selected' : '' }}>
                                                {{ $pais->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <x-input-label for="status" :value="__('Status')" />
                                    <select id="status" name="status" class="form-select">
                                        <option value="">Todos</option>
                                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Ativo</option>
                                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inativo</option>
                                    </select>
                                </div>

                                <div class="flex items-end">
                                    <x-primary-button class="w-full">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                        </svg>
                                        {{ __('Aplicar Filtros') }}
                                    </x-primary-button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Script para mostrar/ocultar filtros -->
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const toggleButton = document.getElementById('toggle-filters');
                            const filterOptions = document.getElementById('filter-options');
                            
                            // Verificar se há filtros aplicados para mostrar as opções
                            const urlParams = new URLSearchParams(window.location.search);
                            const hasFilters = urlParams.has('pais_id') || urlParams.has('status');
                            
                            if (hasFilters) {
                                filterOptions.classList.remove('hidden');
                            }
                            
                            toggleButton.addEventListener('click', function() {
                                filterOptions.classList.toggle('hidden');
                            });
                        });
                    </script>

                    <!-- Cards de Resumo -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                                Total de Mercados
                                            </dt>
                                            <dd class="flex items-baseline">
                                                <div class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                                    {{ $mercados->total() }}
                                                </div>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                                Mercados Ativos
                                            </dt>
                                            <dd class="flex items-baseline">
                                                <div class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                                    {{ $mercados->where('status', true)->count() }}
                                                </div>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                                Mercados Inativos
                                            </dt>
                                            <dd class="flex items-baseline">
                                                <div class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                                    {{ $mercados->where('status', false)->count() }}
                                                </div>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lista de Mercados -->
                    <div class="overflow-hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @forelse($mercados as $mercado)
                                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow duration-300">
                                    <div class="p-6">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $mercado->nome }}</h3>
                                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $mercado->pais->nome }}</p>
                                            </div>
                                            <span class="status-badge {{ $mercado->status ? 'status-badge-active' : 'status-badge-inactive' }}">
                                                {{ $mercado->status ? 'Ativo' : 'Inativo' }}
                                            </span>
                                        </div>
                                        
                                        <div class="mt-4 space-y-2">
                                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                                <span>Gerente: {{ $mercado->gerente->nome ?? 'Não definido' }}</span>
                                            </div>
                                            
                                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                </svg>
                                                <span>{{ $mercado->telefone }}</span>
                                            </div>
                                            
                                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                </svg>
                                                <span>{{ $mercado->email }}</span>
                                            </div>
                                            
                                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                <span>{{ $mercado->endereco }}, {{ $mercado->numero }} - {{ $mercado->bairro }}</span>
                                            </div>
                                            
                                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                <span>{{ $mercado->cidade }} - {{ $mercado->estado }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-6 flex justify-end space-x-3">
                                            <a href="{{ route('painel.mercados.edit', $mercado) }}" class="btn-secondary">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Editar
                                            </a>
                                            <form action="{{ route('painel.mercados.destroy', $mercado) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-danger" onclick="return confirm('Tem certeza que deseja excluir este mercado?')">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Excluir
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 p-6 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Nenhum mercado encontrado</h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Comece criando um novo mercado.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('painel.mercados.create') }}" class="btn-primary">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Novo Mercado
                                        </a>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="mt-6">
                        {{ $mercados->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

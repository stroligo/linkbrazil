<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Funcionários') }}
            </h2>
            <a href="{{ route('painel.funcionarios.create') }}" class="btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Novo Funcionário
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Filtros -->
                    <div class="mb-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <form method="GET" action="{{ route('painel.funcionarios.index') }}" class="space-y-4">
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
                                    
                                    @if(request('search') || request('mercado_id') || request('status'))
                                        <a href="{{ route('painel.funcionarios.index') }}" class="btn-secondary">
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
                                    <x-input-label for="mercado_id" :value="__('Mercado')" />
                                    <select id="mercado_id" name="mercado_id" class="form-select">
                                        <option value="">Todos os mercados</option>
                                        @foreach($mercados as $mercado)
                                            <option value="{{ $mercado->id }}" {{ request('mercado_id') == $mercado->id ? 'selected' : '' }}>
                                                {{ $mercado->nome }}
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
                            const hasFilters = urlParams.has('mercado_id') || urlParams.has('status');
                            
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
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                                Total de Funcionários
                                            </dt>
                                            <dd class="flex items-baseline">
                                                <div class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                                    {{ $funcionarios->total() }}
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
                                                Funcionários Ativos
                                            </dt>
                                            <dd class="flex items-baseline">
                                                <div class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                                    {{ $funcionarios->where('status', true)->count() }}
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
                                                Funcionários Inativos
                                            </dt>
                                            <dd class="flex items-baseline">
                                                <div class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                                    {{ $funcionarios->where('status', false)->count() }}
                                                </div>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lista de Funcionários -->
                    <div class="overflow-hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @forelse($funcionarios as $funcionario)
                                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow duration-300">
                                    <div class="p-6">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $funcionario->nome }}</h3>
                                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $funcionario->mercado->nome }}</p>
                                            </div>
                                            <span class="status-badge {{ $funcionario->status ? 'status-badge-active' : 'status-badge-inactive' }}">
                                                {{ $funcionario->status ? 'Ativo' : 'Inativo' }}
                                            </span>
                                        </div>
                                        
                                        <div class="mt-4 space-y-2">
                                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                </svg>
                                                <span>Cargo: {{ $funcionario->cargo }}</span>
                                            </div>
                                            
                                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                                </svg>
                                                <span>Nível: {{ ucfirst($funcionario->nivel_acesso) }}</span>
                                            </div>
                                            
                                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                </svg>
                                                <span>{{ $funcionario->telefone }}</span>
                                            </div>
                                            
                                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                </svg>
                                                <span>{{ $funcionario->email }}</span>
                                            </div>
                                            
                                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                                </svg>
                                                <span>CPF: {{ $funcionario->cpf }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-6 flex justify-end space-x-3">
                                            <a href="{{ route('painel.funcionarios.edit', $funcionario) }}" class="btn-secondary">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Editar
                                            </a>
                                            <form action="{{ route('painel.funcionarios.destroy', $funcionario) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-danger" onclick="return confirm('Tem certeza que deseja excluir este funcionário?')">
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Nenhum funcionário encontrado</h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Comece criando um novo funcionário.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('painel.funcionarios.create') }}" class="btn-primary">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Novo Funcionário
                                        </a>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="mt-6">
                        {{ $funcionarios->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Editar Funcionário') }}
            </h2>
            <a href="{{ route('painel.funcionarios.index') }}" class="btn-back">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Voltar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('painel.funcionarios.update', $funcionario) }}" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-section">
                            <h3 class="form-section-title">{{ __('Informações Pessoais') }}</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="form-field">
                                    <x-input-label for="nome" :value="__('Nome')" />
                                    <x-text-input id="nome" name="nome" type="text" class="form-input" :value="old('nome', $funcionario->nome)" required autofocus />
                                    <x-input-error class="form-error" :messages="$errors->get('nome')" />
                                </div>

                                <div class="form-field">
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" name="email" type="email" class="form-input" :value="old('email', $funcionario->email)" required />
                                    <x-input-error class="form-error" :messages="$errors->get('email')" />
                                </div>

                                <div class="form-field">
                                    <x-input-label for="telefone" :value="__('Telefone')" />
                                    <x-text-input id="telefone" name="telefone" type="text" class="form-input" :value="old('telefone', $funcionario->telefone)" required />
                                    <x-input-error class="form-error" :messages="$errors->get('telefone')" />
                                </div>
                            </div>
                        </div>

                        <div class="form-section mt-6">
                            <h3 class="form-section-title">{{ __('Vínculo') }}</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="form-field">
                                    <x-input-label for="mercado_id" :value="__('Mercado')" />
                                    <select id="mercado_id" name="mercado_id" class="form-select" required>
                                        <option value="">Selecione um mercado</option>
                                        @foreach($mercados as $mercado)
                                            <option value="{{ $mercado->id }}" {{ old('mercado_id', $funcionario->mercado_id) == $mercado->id ? 'selected' : '' }}>
                                                {{ $mercado->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error class="form-error" :messages="$errors->get('mercado_id')" />
                                </div>

                                <div class="form-field">
                                    <x-input-label for="nivel_acesso" :value="__('Nível de Acesso')" />
                                    <select id="nivel_acesso" name="nivel_acesso" class="form-select" required>
                                        <option value="">Selecione um nível</option>
                                        <option value="admin" {{ old('nivel_acesso', $funcionario->nivel_acesso) === 'admin' ? 'selected' : '' }}>Administrador</option>
                                        <option value="gerente" {{ old('nivel_acesso', $funcionario->nivel_acesso) === 'gerente' ? 'selected' : '' }}>Gerente</option>
                                        <option value="funcionario" {{ old('nivel_acesso', $funcionario->nivel_acesso) === 'funcionario' ? 'selected' : '' }}>Funcionário</option>
                                    </select>
                                    <x-input-error class="form-error" :messages="$errors->get('nivel_acesso')" />
                                </div>
                            </div>
                        </div>

                        <div class="form-section mt-6">
                            <h3 class="form-section-title">{{ __('Senha') }}</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="form-field">
                                    <x-input-label for="password" :value="__('Nova Senha')" />
                                    <x-text-input id="password" name="password" type="password" class="form-input" />
                                    <x-input-error class="form-error" :messages="$errors->get('password')" />
                                </div>

                                <div class="form-field">
                                    <x-input-label for="password_confirmation" :value="__('Confirmar Nova Senha')" />
                                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="form-input" />
                                    <x-input-error class="form-error" :messages="$errors->get('password_confirmation')" />
                                </div>
                            </div>
                        </div>

                        <div class="form-section mt-6">
                            <h3 class="form-section-title">{{ __('Status') }}</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="form-field">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="status" value="1" class="form-checkbox" {{ old('status', $funcionario->status) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Ativo') }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-secondary-button type="button" onclick="window.history.back()" class="mr-3">
                                {{ __('Cancelar') }}
                            </x-secondary-button>
                            <x-primary-button>
                                {{ __('Salvar') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 
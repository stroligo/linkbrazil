<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Criar Mercado') }}
            </h2>
            <a href="{{ route('painel.mercados.index') }}" class="btn-back">
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
                    <form method="POST" action="{{ route('painel.mercados.store') }}" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-field">
                                <x-input-label for="nome" :value="__('Nome')" />
                                <x-text-input id="nome" name="nome" type="text" class="form-input" :value="old('nome')" required autofocus />
                                <x-input-error class="form-error" :messages="$errors->get('nome')" />
                            </div>

                            <div class="form-field">
                                <x-input-label for="pais_id" :value="__('País')" />
                                <select id="pais_id" name="pais_id" class="form-select" required>
                                    <option value="">Selecione um país</option>
                                    @foreach($paises as $pais)
                                        <option value="{{ $pais->id }}" {{ old('pais_id') == $pais->id ? 'selected' : '' }}>
                                            {{ $pais->nome }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="form-error" :messages="$errors->get('pais_id')" />
                            </div>

                            <div class="form-field">
                                <x-input-label for="gerente_id" :value="__('Gerente')" />
                                <select id="gerente_id" name="gerente_id" class="form-select">
                                    <option value="">Selecione um gerente</option>
                                    @foreach($gerentes as $gerente)
                                        <option value="{{ $gerente->id }}" {{ old('gerente_id') == $gerente->id ? 'selected' : '' }}>
                                            {{ $gerente->nome }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="form-error" :messages="$errors->get('gerente_id')" />
                            </div>

                            <div class="form-field">
                                <x-input-label for="telefone" :value="__('Telefone')" />
                                <x-text-input id="telefone" name="telefone" type="text" class="form-input" :value="old('telefone')" required />
                                <x-input-error class="form-error" :messages="$errors->get('telefone')" />
                            </div>

                            <div class="form-field">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" type="email" class="form-input" :value="old('email')" required />
                                <x-input-error class="form-error" :messages="$errors->get('email')" />
                            </div>
                        </div>

                        <div class="form-section mt-6">
                            <h3 class="form-section-title">{{ __('Endereço') }}</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="form-field-sm">
                                    <x-input-label for="cep" :value="__('CEP')" />
                                    <x-text-input id="cep" name="cep" type="text" class="form-input" :value="old('cep')" />
                                    <x-input-error class="form-error" :messages="$errors->get('cep')" />
                                </div>

                                <div class="form-field">
                                    <x-input-label for="endereco" :value="__('Endereço')" />
                                    <x-text-input id="endereco" name="endereco" type="text" class="form-input" :value="old('endereco')" required />
                                    <x-input-error class="form-error" :messages="$errors->get('endereco')" />
                                </div>

                                <div class="form-field-sm">
                                    <x-input-label for="numero" :value="__('Número')" />
                                    <x-text-input id="numero" name="numero" type="text" class="form-input" :value="old('numero')" />
                                    <x-input-error class="form-error" :messages="$errors->get('numero')" />
                                </div>

                                <div class="form-field">
                                    <x-input-label for="complemento" :value="__('Complemento')" />
                                    <x-text-input id="complemento" name="complemento" type="text" class="form-input" :value="old('complemento')" />
                                    <x-input-error class="form-error" :messages="$errors->get('complemento')" />
                                </div>

                                <div class="form-field">
                                    <x-input-label for="bairro" :value="__('Bairro')" />
                                    <x-text-input id="bairro" name="bairro" type="text" class="form-input" :value="old('bairro')" />
                                    <x-input-error class="form-error" :messages="$errors->get('bairro')" />
                                </div>

                                <div class="form-field-sm">
                                    <x-input-label for="cidade" :value="__('Cidade')" />
                                    <x-text-input id="cidade" name="cidade" type="text" class="form-input" :value="old('cidade')" required />
                                    <x-input-error class="form-error" :messages="$errors->get('cidade')" />
                                </div>

                                <div class="form-field-sm">
                                    <x-input-label for="estado" :value="__('Estado')" />
                                    <x-text-input id="estado" name="estado" type="text" class="form-input" :value="old('estado')" required />
                                    <x-input-error class="form-error" :messages="$errors->get('estado')" />
                                </div>
                            </div>
                        </div>

                        <div class="form-section mt-6">
                            <h3 class="form-section-title">{{ __('Localização') }}</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="form-field-sm">
                                    <x-input-label for="latitude" :value="__('Latitude')" />
                                    <x-text-input id="latitude" name="latitude" type="text" class="form-input" :value="old('latitude')" />
                                    <x-input-error class="form-error" :messages="$errors->get('latitude')" />
                                </div>

                                <div class="form-field-sm">
                                    <x-input-label for="longitude" :value="__('Longitude')" />
                                    <x-text-input id="longitude" name="longitude" type="text" class="form-input" :value="old('longitude')" />
                                    <x-input-error class="form-error" :messages="$errors->get('longitude')" />
                                </div>
                            </div>
                        </div>

                        <div class="form-section mt-6">
                            <h3 class="form-section-title">{{ __('Informações Adicionais') }}</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="form-field">
                                    <x-input-label for="observacoes" :value="__('Observações')" />
                                    <textarea id="observacoes" name="observacoes" class="form-textarea" rows="3">{{ old('observacoes') }}</textarea>
                                    <x-input-error class="form-error" :messages="$errors->get('observacoes')" />
                                </div>

                                <div class="form-field">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="ativo" value="1" class="form-checkbox" {{ old('ativo', true) ? 'checked' : '' }}>
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

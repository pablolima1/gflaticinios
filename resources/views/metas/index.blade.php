@extends('layouts.app')

@section('content')
<div x-data="metasPageHandler()">
    <!-- Header com botão de adicionar -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Gerenciamento de Metas</h1>
        <x-ui.button 
            @click="openNewMetaModal()" 
            variant="primary" 
            size="md">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Adicionar Meta
        </x-ui.button>
    </div>

    <!-- Tabela de Metas -->
    <x-tables.metas.meta-table :metas="$metas" />

    <!-- Modal de Formulário -->
    <x-modals.metas.form-modal />

    <script>
        function metasPageHandler() {
            return {
                openNewMetaModal() {
                    window.dispatchEvent(new CustomEvent('open-meta-modal'));
                }
            }
        }
    </script>
</div>
@endsection

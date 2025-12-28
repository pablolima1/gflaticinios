@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Administração de Tipos de Processos" />
<div class="space-y-6">
    <x-common.component-card title="Tipos de Processos">
        @if ($tipoProcessos->isEmpty())
        <x-ui.alert>
            Nenhum tipo de processo encontrado. Clique no botão abaixo para adicionar um novo tipo de processo.
        </x-ui.alert>
        @else
        <x-tables.tipo-processos.tipo-processos-table :tipoprocessos="$tipoProcessos" />
        @endif
        <x-ui.button @click="window.location.href = '{{ route('tipos-processos.create') }}'">Adicionar Tipo de Processo</x-ui.button>
    </x-common.component-card>
</div>
@endsection
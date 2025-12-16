@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Administração de Tipos de Processos" />
    <div class="space-y-6">
        <x-common.component-card title="Tipos de Processos">
            <x-tables.tipo-processos.tipo-processos-table :tipoprocessos="$tipoProcessos" />
            <x-ui.button @click="window.location.href = '{{ route('tipos-processos.create') }}'">Adicionar Tipo de Processo</x-ui.button>
        </x-common.component-card>
    </div>
@endsection

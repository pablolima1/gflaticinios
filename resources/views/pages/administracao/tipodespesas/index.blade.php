@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Administração de Tipos de Despesas" />
<div class="space-y-6">
    <x-common.component-card title="Tipos de Despesas">
        @if ($tipoDespesas->isEmpty())
        <x-ui.alert>
            Nenhum tipo de despesa encontrado. Clique no botão abaixo para adicionar um novo tipo de despesa.
        </x-ui.alert>
        @else
        <x-tables.tipo-despesas.tipo-despesas-table :tipodespesas="$tipoDespesas" />
        @endif
        <x-ui.button @click="window.location.href = '{{ route('tipos-despesas.create') }}'">Adicionar Tipo de Despesa</x-ui.button>
    </x-common.component-card>
</div>
@endsection
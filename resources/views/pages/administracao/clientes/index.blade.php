@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Administração de Clientes" />
<div class="space-y-6">
    <x-common.component-card title="Clientes">
        @if ($clientes->isEmpty())
        <x-ui.alert>
            Nenhum cliente cadastrado. Clique no botão abaixo para adicionar um novo Cliente.
        </x-ui.alert>
        @else
        <x-tables.clientes.cliente-table :clientes="$clientes" />
        @endif
        <x-ui.button @click="window.location.href = '{{ route('clientes.create') }}'">Adicionar Cliente</x-ui.button>
    </x-common.component-card>
</div>
@endsection
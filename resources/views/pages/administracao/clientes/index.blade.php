@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Administração de Clientes" />
    <div class="space-y-6">
        <x-common.component-card title="Clientes">
            <x-tables.clientes.cliente-table :clientes="$clientes" />
            <x-ui.button @click="window.location.href = '{{ route('clientes.create') }}'">Adicionar Cliente</x-ui.button>
        </x-common.component-card>
    </div>
@endsection

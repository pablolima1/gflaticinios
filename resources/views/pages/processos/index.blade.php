@extends('layouts.app')

@section('content')
<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
    <div class="space-y-6">
        <x-common.component-card title="Gerenciar Meus Processos">
            @if ($processos->isEmpty())
            <x-ui.alert>
                Nenhum processo cadastrado. Clique no botão abaixo para adicionar um novo Processo.
            </x-ui.alert>
            @else
            <x-tables.processos.processo-index-table :processos="$processos" />
            @endif
            <x-ui.button @click="window.location.href = '{{ route('processos.create') }}'">Add Novo Processo</x-ui.button>
        </x-common.component-card>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Gerenciar Meus Processos" />
<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
    <div class="mb-6 rounded-2xl border border-gray-200 bg-white p-4 sm:p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-gray-800 dark:text-white/90">Overview</h2>
            </div>
        </div>
        <div
            class="grid grid-cols-1 rounded-xl border border-gray-200 sm:grid-cols-2 lg:grid-cols-4 lg:divide-x lg:divide-y-0 dark:divide-gray-800 dark:border-gray-800">
            <div class="border-b p-5 sm:border-r sm:border-b-0">
                <p class="mb-1.5 text-sm text-gray-400 dark:text-gray-500">Mês/Ano de Referência</p>
                <x-form.date-picker-anomes
                    name="competencia"
                    defaultDate="{{ $ano . '-' . $mes }}" />
            </div>
            <div class="border-b p-5 sm:border-r lg:border-b-0">
                <p class="mb-1.5 text-sm text-gray-400 dark:text-gray-500">Receita Prevista</p>
                <h3 class="text-3xl text-green-600 dark:text-green-500">R$ {{ number_format($receitaPrevista, 2, ',', '.') }}</h3>
            </div>
            <div class="border-b p-5 lg:border-b-0">
                <p class="mb-1.5 text-sm text-gray-400 dark:text-gray-500">Receita Recebida</p>
                <h3 class="text-3xl {{ $receitaRecebida >= $receitaPrevista ? 'text-green-600 dark:text-green-500' : 'text-red-600 dark:text-red-500' }}">R$ {{ number_format($receitaRecebida, 2, ',', '.') }}</h3>
            </div>
            <div class="p-5">
                <p class="mb-1.5 text-sm text-gray-400 dark:text-gray-500">Informação</p>
                <h3 class="text-3xl text-gray-800 dark:text-white/90">Teste</h3>
            </div>
        </div>
    </div>

    <script></script>
</div>
<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
    <x-tables.processos.balanco-balancete-index-table :processos="$processos" />
</div>
@endsection
@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Editar Despesa</h1>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Atualize as informações da despesa selecionada.</p>
            </div>
            <x-ui.button @click="window.location.href='{{ route('despesas.index') }}'" variant="secondary" size="md">
                Voltar para lista
            </x-ui.button>
        </div>

        @if($errors->any())
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-4 text-sm text-red-800 dark:border-red-800 dark:bg-red-900/20 dark:text-red-200">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-white/[0.03] p-6">
            @include('pages.despesas._form', [
                'action' => route('despesas.update', $despesa),
                'method' => 'PUT',
                'buttonText' => 'Atualizar Despesa',
                'despesa' => $despesa,
            ])
        </div>
    </div>
@endsection

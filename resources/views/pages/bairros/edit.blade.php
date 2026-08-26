@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Editar Bairro</h1>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Atualize os dados do bairro.</p>
        </div>

        @if($errors->any())
            <div class="mb-4 rounded-2xl border border-red-200 bg-red-50 px-4 py-4 text-sm text-red-800 dark:border-red-800 dark:bg-red-900/20 dark:text-red-200">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/[0.03]">
            @include('pages.bairros._form', ['action' => route('bairros.update', $bairro), 'method' => 'PUT', 'buttonText' => 'Atualizar', 'bairro' => $bairro])
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Gerenciar Meus Processos" />
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div class="mb-6 rounded-2xl border border-gray-200 bg-white p-4 sm:p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h2 class="font-semibold text-gray-800 dark:text-white/90">Overview</h2>
                </div>
                <div>
                    <button @click="window.location.href = '{{ route('processos.create') }}'"
                        class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">
                        Add Novo Processo

                        <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M9.2502 4.99951C9.2502 4.5853 9.58599 4.24951 10.0002 4.24951C10.4144 4.24951 10.7502 4.5853 10.7502 4.99951V9.24971H15.0006C15.4148 9.24971 15.7506 9.5855 15.7506 9.99971C15.7506 10.4139 15.4148 10.7497 15.0006 10.7497H10.7502V15.0001C10.7502 15.4143 10.4144 15.7501 10.0002 15.7501C9.58599 15.7501 9.2502 15.4143 9.2502 15.0001V10.7497H5C4.58579 10.7497 4.25 10.4139 4.25 9.99971C4.25 9.5855 4.58579 9.24971 5 9.24971H9.2502V4.99951Z"
                                fill=""></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div
                class="grid grid-cols-1 rounded-xl border border-gray-200 sm:grid-cols-2 lg:grid-cols-4 lg:divide-x lg:divide-y-0 dark:divide-gray-800 dark:border-gray-800">
                <div class="border-b p-5 sm:border-r lg:border-b-0">
                    <p class="mb-1.5 text-sm text-gray-400 dark:text-gray-500">Receita Prevista</p>
                    <h3 class="text-3xl text-gray-800 dark:text-white/90">R$ 12.220,80</h3>
                </div>
                <div class="border-b p-5 lg:border-b-0">
                    <p class="mb-1.5 text-sm text-gray-400 dark:text-gray-500">Receita Recebida</p>
                    <h3 class="text-3xl text-gray-800 dark:text-white/90">R$ 4.530,00</h3>
                </div>
                <div class="border-b p-5 sm:border-r sm:border-b-0">
                    <p class="mb-1.5 text-sm text-gray-400 dark:text-gray-500">Informação</p>
                    <h3 class="text-3xl text-gray-800 dark:text-white/90">Teste</h3>
                </div>
                <div class="p-5">
                    <p class="mb-1.5 text-sm text-gray-400 dark:text-gray-500">Informação</p>
                    <h3 class="text-3xl text-gray-800 dark:text-white/90">Teste</h3>
                </div>
            </div>
        </div>

        <script></script>
    </div>
    <div class="pb-8">
        <x-tables.processos.processo-index-table :processos="$processos"/>
    </div>
@endsection

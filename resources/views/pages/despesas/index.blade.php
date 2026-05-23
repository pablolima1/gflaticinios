@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Despesas</h1>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Gerencie as despesas registradas no sistema.</p>
            </div>
            <x-ui.button @click="window.location.href='{{ route('despesas.create') }}'" variant="primary" size="md">
                Nova Despesa
            </x-ui.button>
        </div>

        @if(session('success'))
            <div class="mb-4 rounded-2xl border border-green-200 bg-green-50 px-4 py-4 text-sm text-green-800 dark:border-green-800 dark:bg-green-900/20 dark:text-green-200">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="overflow-x-auto p-4 sm:p-6">
                <table class="min-w-full border-separate border-spacing-0 text-left text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 dark:bg-gray-900 dark:text-gray-400">
                            <th class="px-4 py-3 font-medium">Descrição</th>
                            <th class="px-4 py-3 font-medium text-right">Valor</th>
                            <th class="px-4 py-3 font-medium text-right">Data</th>
                            <th class="px-4 py-3 font-medium">Observações</th>
                            <th class="px-4 py-3 font-medium text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse($despesas as $despesa)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/70">
                                <td class="px-4 py-4 text-gray-700 dark:text-white/90">{{ $despesa->descricao }}</td>
                                <td class="px-4 py-4 text-right text-gray-700 dark:text-white/90">R$ {{ number_format($despesa->valor, 2, ',', '.') }}</td>
                                <td class="px-4 py-4 text-right text-gray-700 dark:text-white/90">{{ optional($despesa->data_despesa)->format('d/m/Y') }}</td>
                                <td class="px-4 py-4 text-gray-600 dark:text-gray-300">{{ $despesa->observacoes ?: '-' }}</td>
                                <td class="px-4 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('despesas.edit', $despesa) }}" class="rounded-lg border border-blue-500 bg-blue-50 px-3 py-2 text-sm font-medium text-blue-700 transition hover:bg-blue-100 dark:border-blue-400 dark:bg-blue-500/10 dark:text-blue-200 dark:hover:bg-blue-500/20">
                                            Editar
                                        </a>
                                        <form action="{{ route('despesas.destroy', $despesa) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta despesa?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white transition hover:bg-red-700">
                                                Excluir
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                    Nenhuma despesa registrada.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-gray-200 bg-gray-50 px-4 py-4 text-right dark:border-gray-800 dark:bg-white/5">
                {{ $despesas->links() }}
            </div>
        </div>
    </div>
@endsection

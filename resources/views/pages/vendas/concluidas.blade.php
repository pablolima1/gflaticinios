@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-6">
    <x-common.component-card title="Vendas Concluídas" 
                            desc="Visualize o histórico de vendas finalizadas">

        <!-- Filtros Secundários -->
        <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
            <form method="GET" class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">

                <!-- Filtro de Cliente -->
                <div>
                    <label for="cliente_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Cliente
                    </label>
                    <select id="cliente_id" 
                            name="cliente_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                        <option value="">-- Todos os Clientes --</option>
                        @foreach($clientesDisponiveis as $cliente)
                            <option value="{{ $cliente->id }}" 
                                    @selected(request('cliente_id') == $cliente->id)>
                                {{ $cliente->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-brand-500 text-white rounded-lg hover:bg-brand-600 transition font-medium">
                        Filtrar
                    </button>
                    <a href="{{ route('vendas.concluidas') }}" 
                       class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg text-gray-700 dark:text-gray-300 text-center hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        Limpar
                    </a>
                </div>
            </form>
        </div>

        <!-- Tabela de Vendas -->
        @if($vendas->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-y border-gray-200 dark:border-gray-700">
                            <th scope="col" class="px-4 py-3 font-semibold text-gray-700 dark:text-gray-300 text-left text-sm">
                                Cliente
                            </th>
                            <th scope="col" class="px-4 py-3 font-semibold text-gray-700 dark:text-gray-300 text-left text-sm">
                                Produtos
                            </th>
                            <th scope="col" class="px-4 py-3 font-semibold text-gray-700 dark:text-gray-300 text-left text-sm">
                                Data
                            </th>
                            <th scope="col" class="px-4 py-3 font-semibold text-gray-700 dark:text-gray-300 text-right text-sm">
                                Valor Total
                            </th>
                            <th scope="col" class="px-4 py-3 font-semibold text-gray-700 dark:text-gray-300 text-right text-sm">
                                Pago
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($vendas as $venda)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                                <td class="px-4 py-3 text-sm font-medium text-gray-800 dark:text-white">
                                    {{ $venda->cliente->nome }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                    @foreach($venda->itensVenda as $item)
                                        <div>{{ $item->produto->nome ?? 'N/A' }} ({{ $item->quantidade }}x)</div>
                                    @endforeach
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                    {{ $venda->data_venda->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-3 text-sm font-semibold text-right text-gray-800 dark:text-white">
                                    R$ {{ number_format($venda->valor_total, 2, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-sm font-semibold text-right text-green-600 dark:text-green-400">
                                    R$ {{ number_format($venda->totalPago(), 2, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            <div class="mt-6 flex justify-center">
                {{ $vendas->links() }}
            </div>
        @else
            <div class="py-12 text-center">
                <div class="text-6xl mb-4">📋</div>
                <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">
                    Nenhuma venda concluída
                </h4>
                <p class="text-gray-600 dark:text-gray-400">
                    Não há vendas concluídas para exibir.
                </p>
            </div>
        @endif
    </x-common.component-card>
</div>

@endsection

@section('scripts')
@endsection

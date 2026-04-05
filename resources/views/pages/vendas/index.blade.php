@extends('layouts.app')

@section('content')
<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] max-w-5xl mx-auto mt-6">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Ações rápidas
        </h3>
    </div>
    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
            <!-- Card Item: Nova Venda -->
            <div>
                <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6 cursor-pointer hover:shadow-lg transition" data-modal-target="#modalNovaVenda">
                    <div class="mb-5 flex h-14 max-w-14 items-center justify-center rounded-[10.5px] bg-brand-50 text-brand-500 dark:bg-brand-500/10">
                        <span class="text-2xl">🛒</span>
                    </div>
                    <h4 class="mb-1 font-medium text-gray-800 text-theme-xl dark:text-white/90">Nova Venda</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Cadastrar uma nova venda rapidamente</p>
                </div>
            </div>
            <!-- Card Item: Novo Pedido -->
            <div>
                <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6 relative opacity-50 cursor-not-allowed">
                    <div class="absolute inset-0 flex items-center justify-center rounded-xl">
                        <span class="bg-brand-500 text-white px-3 py-1 rounded-full text-xs font-semibold">Em breve</span>
                    </div>
                    <div class="mb-5 flex h-14 max-w-14 items-center justify-center rounded-[10.5px] bg-brand-50 text-brand-500 dark:bg-brand-500/10">
                        <span class="text-2xl">📦</span>
                    </div>
                    <h4 class="mb-1 font-medium text-gray-800 text-theme-xl dark:text-white/90">Novo Pedido</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Registrar um novo pedido</p>
                </div>
            </div>
            <!-- Card Item: Cadastro Múltiplo -->
            <!-- <div>
                <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6 cursor-pointer hover:shadow-lg transition" data-modal-target="#modalCadastroMultiplo">
                    <div class="mb-5 flex h-14 max-w-14 items-center justify-center rounded-[10.5px] bg-brand-50 text-brand-500 dark:bg-brand-500/10">
                        <span class="text-2xl">➕</span>
                    </div>
                    <h4 class="mb-1 font-medium text-gray-800 text-theme-xl dark:text-white/90">Cadastro Múltiplo</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Adicionar várias vendas/pedidos</p>
                </div>
            </div> -->
            <!-- Card Item: Vendas Recentes -->
            <!-- <div>
                <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6">
                    <div class="mb-5 flex h-14 max-w-14 items-center justify-center rounded-[10.5px] bg-brand-50 text-brand-500 dark:bg-brand-500/10">
                        <span class="text-2xl">📈</span>
                    </div>
                    <h4 class="mb-1 font-medium text-gray-800 text-theme-xl dark:text-white/90">Vendas Recentes</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Veja as últimas vendas registradas</p>
                </div>
            </div> -->
        </div>
    </div>
</div>

<!-- Card: Últimas Vendas Registradas -->
<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] max-w-5xl mx-auto mt-6">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Últimas Vendas Registradas
        </h3>
    </div>
    <!-- Card Body -->
    <div class="overflow-hidden">
        <div class="max-w-full px-5 overflow-x-auto sm:px-6">
            @if($vendasRecentes['hoje']->count() > 0 || $vendasRecentes['outrosDias']->count() > 0)
                <table class="min-w-full">
                    <thead>
                        <tr class="border-gray-200 border-y dark:border-gray-700">
                            <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">
                                Cliente
                            </th>
                            <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">
                                Produto
                            </th>
                            <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">
                                Valor
                            </th>
                            <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">
                                Usuário
                            </th>
                            <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">
                                Data e Horário
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <!-- Vendas de Hoje -->
                        @if($vendasRecentes['hoje']->count() > 0)
                            <tr class="bg-gray-50 dark:bg-gray-900">
                                <td colspan="5" class="px-4 py-3 text-sm font-semibold text-gray-700 dark:text-white">
                                    📅 Hoje
                                </td>
                            </tr>
                            @foreach ($vendasRecentes['hoje'] as $venda)
                                <tr>
                                    <td class="px-4 py-4 text-gray-800 dark:text-white/80">
                                        {{ $venda->cliente->nome ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-4 text-gray-700 dark:text-white/70">
                                        @if($venda->itensVenda->count() > 0)
                                            {{ $venda->itensVenda->first()->produto->nome ?? 'N/A' }}
                                            @if($venda->itensVenda->count() > 1)
                                                <span class="text-gray-500 dark:text-gray-400"> +{{ $venda->itensVenda->count() - 1 }}</span>
                                            @endif
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-gray-800 dark:text-white/80 font-medium">
                                        @if($venda->itensVenda->count() > 0)
                                            R$ {{ number_format($venda->itensVenda->first()->subtotal, 2, ',', '.') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-gray-800 dark:text-white/80">
                                        {{ $venda->usuario->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-gray-700 dark:text-white/70">
                                        {{ $venda->created_at->format('d/m/Y H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        <!-- Vendas de Outros Dias -->
                        @if($vendasRecentes['outrosDias']->count() > 0)
                            <tr class="bg-gray-50 dark:bg-gray-900">
                                <td colspan="5" class="px-4 py-3 text-sm font-semibold text-gray-700 dark:text-white">
                                    📋 Outras Datas
                                </td>
                            </tr>
                            @foreach ($vendasRecentes['outrosDias'] as $venda)
                                <tr>
                                    <td class="px-4 py-4 text-gray-800 dark:text-white/80">
                                        {{ $venda->cliente->nome ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-4 text-gray-700 dark:text-white/70">
                                        @if($venda->itensVenda->count() > 0)
                                            {{ $venda->itensVenda->first()->produto->nome ?? 'N/A' }}
                                            @if($venda->itensVenda->count() > 1)
                                                <span class="text-gray-500 dark:text-gray-400"> +{{ $venda->itensVenda->count() - 1 }}</span>
                                            @endif
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-gray-800 dark:text-white/80 font-medium">
                                        @if($venda->itensVenda->count() > 0)
                                            R$ {{ number_format($venda->itensVenda->first()->subtotal, 2, ',', '.') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-gray-800 dark:text-white/80">
                                        {{ $venda->usuario->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-gray-700 dark:text-white/70">
                                        {{ $venda->created_at->format('d/m/Y H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            @else
                <div class="py-12 text-center">
                    <p class="text-gray-500 dark:text-gray-400">Nenhuma venda registrada</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modais usando x-ui.modal -->
<x-ui.modal x-on:open-modal-nova-venda.window="open = true" class="max-w-[700px] max-h-[90vh] overflow-y-auto">
    @include('pages.vendas.partials.modal-nova-venda')
</x-ui.modal>
<x-ui.modal x-on:open-modal-novo-pedido.window="open = true" class="max-w-[700px] max-h-[90vh] overflow-y-auto">
    @include('pages.vendas.partials.modal-novo-pedido')
</x-ui.modal>
<x-ui.modal x-on:open-modal-cadastro-multiplo.window="open = true" class="max-w-[900px] max-h-[90vh] overflow-y-auto">
    @include('pages.vendas.partials.modal-cadastro-multiplo')
</x-ui.modal>

<script>
    // Abrir modal ao clicar nos cards
    document.querySelectorAll('[data-modal-target]').forEach(function(card) {
        card.addEventListener('click', function() {
            var target = card.getAttribute('data-modal-target');
            if (target === '#modalNovaVenda') {
                window.dispatchEvent(new CustomEvent('open-modal-nova-venda'));
            } else if (target === '#modalNovoPedido') {
                window.dispatchEvent(new CustomEvent('open-modal-novo-pedido'));
            } else if (target === '#modalCadastroMultiplo') {
                window.dispatchEvent(new CustomEvent('open-modal-cadastro-multiplo'));
            }
        });
    });
</script>
@endsection

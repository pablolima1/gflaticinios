@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-6">
    <x-common.component-card title="Vendas Pendentes a Receber" 
                            desc="Gerencie pagamentos de vendas anotadas para pagar depois">
        <!-- Filtro de Mês Principal -->
        <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
            <form method="GET" class="flex flex-col gap-4 sm:flex-row sm:items-end sm:gap-3">
                <div class="flex-1">
                    <label for="mes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Filtrar por Mês
                    </label>
                    <input type="month" 
                           id="mes" 
                           name="mes" 
                           value="{{ $mesParam }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white dark:bg-gray-900 dark:border-gray-700 dark:text-white"
                           onchange="this.form.submit()">
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    {{ \Carbon\Carbon::createFromFormat('Y-m', $mesParam)->format('F \\d\\e Y') }}
                </div>
            </form>
        </div>

        <!-- Filtros Secundários -->
        <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
            <form method="GET" class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
                <input type="hidden" name="mes" value="{{ $mesParam }}">

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
                    <a href="{{ route('vendas.pendentes', ['mes' => $mesParam]) }}" 
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
                            <th scope="col" class="px-4 py-3 font-semibold text-gray-700 dark:text-gray-300 text-right text-sm">
                                Saldo
                            </th>
                            <th scope="col" class="px-4 py-3 font-semibold text-gray-700 dark:text-gray-300 text-left text-sm">
                                Observações
                            </th>
                            <th scope="col" class="px-4 py-3 font-semibold text-gray-700 dark:text-gray-300 text-center text-sm">
                                Ações
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
                                <td class="px-4 py-3 text-sm font-semibold text-right text-red-600 dark:text-red-400">
                                    R$ {{ number_format($venda->saldoPendente(), 2, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400 max-w-xs truncate">
                                    {{ $venda->observacoes ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-center flex items-center justify-center gap-2">
                                    <button @click="openPagamentoModal({{ $venda->id }}, '{{ addslashes($venda->cliente->nome) }}', {{ $venda->saldoPendente() }})"
                                            class="inline-flex items-center justify-center px-3 py-2 rounded-lg bg-brand-500 hover:bg-brand-600 text-white transition font-medium">
                                        + Pagamento
                                    </button>

                                    <button @click="openDeleteModal({{ $venda->id }}, '{{ addslashes($venda->cliente->nome) }}', '{{ route('vendas.destroy', $venda) }}')"
                                            class="inline-flex items-center justify-center px-3 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white transition font-medium">
                                        &#128465;
                                    </button>
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
                    Nenhuma venda pendente
                </h4>
                <p class="text-gray-600 dark:text-gray-400">
                    Não há vendas pendentes de pagamento para este período.
                </p>
            </div>
        @endif
    </x-common.component-card>
</div>

<!-- Modal de Registro de Pagamento -->
<x-ui.modal x-on:open-modal-registrar-pagamento.window="open = true" class="max-w-[700px] max-h-[90vh] overflow-y-auto">
    @include('pages.vendas.partials.modal-registrar-pagamento')
</x-ui.modal>

<!-- Modal de Confirmação de Deleção -->
<x-ui.modal x-on:open-modal-delete.window="open = true" class="max-w-[500px]">
    @include('pages.vendas.partials.modal-confirm-delete')
</x-ui.modal>

<script>
    // Inicializar Alpine.store para dados do pagamento
    document.addEventListener('alpine:init', () => {
        Alpine.store('pagamento', {
            venda_id: '',
            cliente_nome: '',
            saldo_display: '',
            saldo_pendente: 0
        });
    });

    const openPagamentoModal = (vendaId, clienteNome, saldo) => {
        // Atualizar o store do Alpine.js
        Alpine.store('pagamento').venda_id = vendaId;
        Alpine.store('pagamento').cliente_nome = clienteNome;
        Alpine.store('pagamento').saldo_display = 'R$ ' + saldo.toFixed(2).replace('.', ',');
        Alpine.store('pagamento').saldo_pendente = saldo;
        
        // Abre o modal
        window.dispatchEvent(new CustomEvent('open-modal-registrar-pagamento'));
    };

    const closePagamentoModal = () => {
        // Dispara evento para fechar o modal
        window.dispatchEvent(new CustomEvent('close-modal'));
    };

    const showErrorMessage = (message) => {
        // Remove mensagem anterior se existir
        const errorDiv = document.getElementById('pagamento-error-message');
        if (errorDiv) {
            errorDiv.remove();
        }

        // Cria novo elemento de erro
        const newError = document.createElement('div');
        newError.id = 'pagamento-error-message';
        newError.className = 'mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg dark:bg-red-900/20 dark:border-red-700 dark:text-red-400';
        newError.textContent = message;
        
        // Insere no início do formulário
        const form = document.getElementById('pagamento-form');
        form.insertBefore(newError, form.firstChild);
    };

    const showSuccessMessage = (message) => {
        // Cria toast de sucesso
        const toast = document.createElement('div');
        toast.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
        toast.textContent = message;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 3000);
    };

    document.getElementById('modal-pagamento')?.addEventListener('click', (e) => {
        if (e.target.id === 'modal-pagamento') {
            closePagamentoModal();
        }
    });

    document.getElementById('pagamento-form')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const submitButton = e.target.querySelector('button[type="submit"]');
        const originalText = submitButton.textContent;
        submitButton.disabled = true;
        submitButton.textContent = 'Processando...';
        
        try {
            const formData = new FormData(e.target);
            const response = await fetch('{{ route("pagamentos.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: formData
            });

            const data = await response.json();

            if (response.ok) {
                showSuccessMessage(data.message || 'Pagamento registrado com sucesso!');
                closePagamentoModal();
                
                // Recarrega a página após 1.5 segundos
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showErrorMessage(data.message || 'Erro ao registrar pagamento');
                submitButton.disabled = false;
                submitButton.textContent = originalText;
            }
        } catch (error) {
            console.error('Erro:', error);
            showErrorMessage('Erro ao enviar o formulário. Tente novamente.');
            submitButton.disabled = false;
            submitButton.textContent = originalText;
        }
    });

    // --- Delete handlers ---
    const openDeleteModal = (vendaId, clienteNome, deleteUrl) => {
        window.deleteVendaUrl = deleteUrl;
        const nameEl = document.getElementById('delete-target-nome');
        if (nameEl) nameEl.textContent = clienteNome;

        window.dispatchEvent(new CustomEvent('open-modal-delete'));
    };

    const closeDeleteModal = () => {
        window.dispatchEvent(new CustomEvent('close-modal'));
    };

    document.getElementById('modal-delete')?.addEventListener('click', (e) => {
        if (e.target.id === 'modal-delete') {
            closeDeleteModal();
        }
    });

    document.getElementById('delete-form')?.addEventListener('submit', async (e) => {
        e.preventDefault();

        const submitButton = e.target.querySelector('button[type="submit"]');
        const originalText = submitButton ? submitButton.textContent : '';
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.textContent = 'Processando...';
        }

        try {
            const token = document.querySelector('meta[name="csrf-token"]').content;
            const response = await fetch(window.deleteVendaUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({'_method': 'DELETE'})
            });

            const data = await response.json().catch(() => ({}));

            if (response.ok) {
                showSuccessMessage(data.message || 'Registro excluído com sucesso!');
                closeDeleteModal();
                setTimeout(() => window.location.reload(), 1200);
            } else {
                showErrorMessage(data.message || 'Erro ao excluir registro');
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.textContent = originalText;
                }
            }
        } catch (error) {
            console.error('Erro:', error);
            showErrorMessage('Erro ao excluir. Tente novamente.');
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.textContent = originalText;
            }
        }
    });
</script>
@endsection

@section('scripts')
@endsection

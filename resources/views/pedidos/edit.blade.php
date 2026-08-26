@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-4xl rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6">
        <div class="mb-5 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Editar pedido</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Atualizar itens e entrega</p>
            </div>
            <a href="{{ route('pedidos.index') }}" class="text-sm text-gray-600 dark:text-gray-300">Voltar</a>
        </div>

        <form action="{{ route('pedidos.update', $pedido) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Cliente</label>
                    <select name="cliente_id" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:text-white" required>
                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->id }}" {{ $pedido->cliente_id == $cliente->id ? 'selected' : '' }}>{{ $cliente->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Data de entrega</label>
                    <input type="date" name="data_entrega" value="{{ $pedido->data_entrega?->format('Y-m-d') }}" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:text-white" required>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Observações</label>
                    <input type="text" name="observacoes" value="{{ $pedido->observacoes }}" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:text-white">
                </div>
            </div>

            <div class="mt-6 rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-900/40">
                <h2 class="mb-3 text-sm font-semibold text-gray-800 dark:text-white">Itens do pedido</h2>
                @foreach ($pedido->itensPedido as $item)
                    <div class="mb-3 grid grid-cols-1 gap-3 rounded-lg border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-900 md:grid-cols-4">
                        <div>
                            <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Produto</label>
                            <select name="items[{{ $loop->index }}][produto_id]" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-3 text-sm text-gray-800 dark:border-gray-700 dark:text-white" required>
                                @foreach ($produtos as $produto)
                                    <option value="{{ $produto->id }}" {{ $item->produto_id == $produto->id ? 'selected' : '' }}>{{ $produto->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Quantidade</label>
                            <input type="number" name="items[{{ $loop->index }}][quantidade]" value="{{ $item->quantidade }}" min="1" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-3 text-sm text-gray-800 dark:border-gray-700 dark:text-white" required>
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Valor unitário</label>
                            <input type="number" name="items[{{ $loop->index }}][valor_unitario]" value="{{ $item->valor_unitario }}" min="0" step="0.01" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-3 text-sm text-gray-800 dark:border-gray-700 dark:text-white" required>
                        </div>
                        <div class="flex items-end">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-200">R$ {{ number_format((float) $item->valor_total, 2, ',', '.') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-5 py-3 text-sm font-medium text-white dark:bg-brand-500">Salvar alterações</button>
            </div>
        </form>
    </div>
@endsection

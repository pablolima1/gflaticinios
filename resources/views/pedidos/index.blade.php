@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-6xl space-y-5 pb-8">
        <div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Pedidos</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Visão operacional dos pedidos do dia</p>
                </div>
                <a href="{{ route('pedidos.create') }}" class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs transition hover:bg-brand-600">
                    Novo pedido
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 dark:border-green-800 dark:bg-green-900/20 dark:text-green-200">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 dark:border-red-800 dark:bg-red-900/20 dark:text-red-200">
                {{ session('error') }}
            </div>
        @endif

        <div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03] sm:p-5">
            <form method="GET" class="grid grid-cols-1 gap-3 md:grid-cols-4">
                <div class="col-span-1 md:col-span-1">
                    <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Cliente</label>
                    <select name="cliente_id" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-3 text-sm text-gray-800 dark:border-gray-700 dark:text-white">
                        <option value="">Todos</option>
                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->id }}" {{ request('cliente_id') == $cliente->id ? 'selected' : '' }}>{{ $cliente->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-1 md:col-span-1">
                    <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Status</label>
                    <select name="status" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-3 text-sm text-gray-800 dark:border-gray-700 dark:text-white">
                        <option value="">Todos</option>
                        <option value="atrasado" {{ request('status') === 'atrasado' ? 'selected' : '' }}>Atrasados</option>
                        <option value="hoje" {{ request('status') === 'hoje' ? 'selected' : '' }}>Para hoje</option>
                        <option value="proximo" {{ request('status') === 'proximo' ? 'selected' : '' }}>Próximos</option>
                        <option value="pendente" {{ request('status') === 'pendente' ? 'selected' : '' }}>Pendente</option>
                        <option value="entregue" {{ request('status') === 'entregue' ? 'selected' : '' }}>Entregue</option>
                    </select>
                </div>
                <div class="col-span-1 md:col-span-1">
                    <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Início</label>
                    <x-form.date-picker-custom
                        name="data_inicio"
                        label=""
                        placeholder="Selecione a data"
                        defaultDate="{{ request('data_inicio') ? date('d/m/Y', strtotime(request('data_inicio'))) : '' }}"
                        dateFormat="d/m/Y"
                    />
                </div>
                <div class="col-span-1 md:col-span-1">
                    <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Fim</label>
                    <x-form.date-picker-custom
                        name="data_fim"
                        label=""
                        placeholder="Selecione a data"
                        defaultDate="{{ request('data_fim') ? date('d/m/Y', strtotime(request('data_fim'))) : '' }}"
                        dateFormat="d/m/Y"
                    />
                </div>
                <div class="md:col-span-4 flex justify-end gap-2">
                    <a href="{{ route('pedidos.index') }}" class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-700 dark:border-gray-700 dark:text-gray-200">Limpar</a>
                    <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white dark:bg-brand-500">Filtrar</button>
                </div>
            </form>
        </div>

        @php
            $grupos = [
                'atrasado' => ['label' => 'Atrasados', 'color' => 'border-red-200 bg-red-50 dark:border-red-900/60 dark:bg-red-900/10', 'badge' => 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-200'],
                'hoje' => ['label' => 'Para hoje', 'color' => 'border-yellow-200 bg-yellow-50 dark:border-yellow-900/60 dark:bg-yellow-900/10', 'badge' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-500/20 dark:text-yellow-200'],
                'proximo' => ['label' => 'Próximos', 'color' => 'border-blue-200 bg-blue-50 dark:border-blue-900/60 dark:bg-blue-900/10', 'badge' => 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-200'],
            ];
        @endphp

        <div class="space-y-5">
            @foreach ($grupos as $key => $config)
                @php
                    $itensGrupo = $pedidos->filter(function ($pedido) use ($key) {
                        return $pedido->status !== 'entregue' && $pedido->status_operacional === $key;
                    });
                    $pedidosPorBairro = $itensGrupo->groupBy(function ($pedido) {
                        return $pedido->cliente?->bairro?->nome ?? 'Sem bairro cadastrado';
                    })->sortKeys();
                @endphp

                <div class="rounded-2xl border {{ $config['color'] }} p-3 sm:p-4">
                    <div class="mb-3 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="text-lg">{{ $key === 'atrasado' ? '🔴' : ($key === 'hoje' ? '🟡' : '🔵') }}</span>
                            <h2 class="text-base font-semibold text-gray-800 dark:text-white">{{ $config['label'] }}</h2>
                        </div>
                        <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $config['badge'] }}">{{ $itensGrupo->count() }}</span>
                    </div>

                    <div class="space-y-3">
                        @forelse ($pedidosPorBairro as $bairroNome => $pedidosDoBairro)
                            <section x-data="{ aberto: false }" class="overflow-hidden rounded-xl border border-white/70 bg-white/70 dark:border-gray-800 dark:bg-gray-900/40">
                                <button type="button" @click="aberto = !aberto" class="flex w-full items-center justify-between gap-3 px-4 py-3 text-left transition hover:bg-white dark:hover:bg-gray-800/50">
                        <span class="flex min-w-0 items-center gap-3">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-300">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path d="M12 21s7-5.2 7-11a7 7 0 1 0-14 0c0 5.8 7 11 7 11Z" />
                                    <circle cx="12" cy="10" r="2.5" />
                                </svg>
                            </span>
                            <span class="min-w-0">
                                <span class="block truncate text-base font-semibold text-gray-800 dark:text-white">{{ $bairroNome }}</span>
                                    <span class="block text-xs text-gray-500 dark:text-gray-400">Pedidos por bairro</span>
                            </span>
                        </span>
                        <span class="flex shrink-0 items-center gap-3">
                            <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-700 dark:bg-gray-800 dark:text-gray-200">{{ $pedidosDoBairro->count() }}</span>
                            <svg class="h-5 w-5 text-gray-400 transition-transform" :class="aberto ? 'rotate-180' : ''" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="m6 9 6 6 6-6" />
                            </svg>
                        </span>
                                </button>

                                <div x-show="aberto" x-cloak>
                                    <div class="space-y-3 border-t border-gray-200 p-3 dark:border-gray-800 sm:p-4">
                            @foreach ($pedidosDoBairro as $pedido)
                                <div class="rounded-xl border border-gray-200 bg-gray-50 p-3 shadow-sm dark:border-gray-800 dark:bg-gray-900/60">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <h3 class="text-base font-semibold text-gray-900 dark:text-white">{{ $pedido->cliente?->nome ?? 'Cliente não informado' }}</h3>
                                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                {{ $pedido->itensPedido->map(fn ($item) => ($item->produto?->nome ?? 'Produto') . ' ' . $item->quantidade . 'x')->implode(', ') ?: 'Sem itens' }}
                                            </p>
                                            @if ($pedido->observacoes)
                                                <p class="mt-2 text-xs text-gray-600 dark:text-gray-300">
                                                    <span class="font-semibold">Obs.:</span> {{ $pedido->observacoes }}
                                                </p>
                                            @endif
                                        </div>
                                        <span class="inline-flex rounded-full bg-gray-100 px-2 py-1 text-[10px] font-semibold text-gray-700 dark:bg-gray-800 dark:text-gray-200">
                                            {{ strtoupper($pedido->status) }}
                                        </span>
                                    </div>

                                    <div class="mt-3 flex items-center justify-between gap-3 text-sm text-gray-700 dark:text-gray-200">
                                        <span>R$ {{ number_format((float) $pedido->valor_total, 2, ',', '.') }}</span>
                                        <span>{{ $pedido->data_entrega?->format('d/m/Y') }}</span>
                                    </div>

                                    <div class="mt-3 flex flex-wrap items-center justify-between gap-2">
                                        <form method="POST" action="{{ route('pedidos.entregue', $pedido) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-green-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-green-700">Entregue Pg a Vista</button>
                                        </form>
                                        <form method="POST" action="{{ route('pedidos.entreguePagarDepois', $pedido) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-amber-500 px-3 py-2 text-xs font-semibold text-white transition hover:bg-amber-600">Entregue | Pagar Depois</button>
                                        </form>
                                        <a href="{{ route('pedidos.edit', $pedido) }}" class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-3 py-2 text-xs font-medium text-gray-700 dark:border-gray-700 dark:text-gray-200">Editar</a>
                                        <button type="button"
                                            @click="$dispatch('abrir-exclusao-pedido', { id: {{ $pedido->id }}, nome: @js($pedido->cliente?->nome ?? 'Cliente não informado') })"
                                            class="inline-flex items-center justify-center rounded-lg border border-red-200 px-3 py-2 text-xs font-medium text-red-700 transition hover:bg-red-50 dark:border-red-900/60 dark:text-red-300 dark:hover:bg-red-900/20">
                                            Excluir
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                                    </div>
                                </div>
                            </section>
                        @empty
                            <div class="rounded-lg border border-dashed border-gray-300 bg-white/30 px-3 py-5 text-center text-sm text-gray-500 dark:border-gray-700 dark:text-gray-400">
                                Nenhum pedido neste grupo.
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>

        <x-ui.modal x-on:abrir-exclusao-pedido.window="open = true; $refs.deleteForm.action = '{{ url('pedidos') }}/' + $event.detail.id; $refs.deleteNome.textContent = $event.detail.nome" class="max-w-[500px]">
            <div class="p-6 sm:p-8">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Confirmar exclusão</h2>
                <p class="mt-3 text-sm text-gray-600 dark:text-gray-300">
                    Tem certeza que deseja excluir o pedido de
                    <strong x-ref="deleteNome" class="font-semibold text-gray-900 dark:text-white"></strong>?
                </p>
                <p class="mt-4 rounded-lg border border-yellow-200 bg-yellow-50 px-4 py-3 text-xs text-yellow-800 dark:border-yellow-900/60 dark:bg-yellow-900/20 dark:text-yellow-200">
                    Esta ação não pode ser desfeita.
                </p>

                <form x-ref="deleteForm" method="POST" action="{{ route('pedidos.index') }}" class="mt-6 flex justify-end gap-3">
                    @csrf
                    @method('DELETE')
                    <button type="button" @click="open = false" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
                        Cancelar
                    </button>
                    <button type="submit" class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-700">
                        Excluir pedido
                    </button>
                </form>
            </div>
        </x-ui.modal>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-6xl space-y-5 pb-8">
        <section class="flex flex-col gap-4 rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03] sm:flex-row sm:items-center sm:justify-between sm:p-6">
            <div>
                <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Pedidos recorrentes</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Clientes com pedidos programados</p>
            </div>
            <button type="button" @click="$dispatch('abrir-cadastro-recorrencia')" class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-brand-600">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="M12 5v14M5 12h14" stroke-linecap="round" />
                </svg>
                Nova recorrência
            </button>
        </section>

        @if (session('success'))
            <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 dark:border-green-800 dark:bg-green-900/20 dark:text-green-200">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 dark:border-red-800 dark:bg-red-900/20 dark:text-red-200">
                Revise os campos destacados no formulário.
            </div>
        @endif

        @if ($pedidosRecorrentes->isEmpty())
            <div class="rounded-2xl border border-dashed border-gray-300 bg-white px-4 py-12 text-center dark:border-gray-700 dark:bg-white/[0.03]">
                <h2 class="text-base font-semibold text-gray-800 dark:text-white">Nenhuma recorrência cadastrada</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">As regras ativas aparecerão nesta lista.</p>
            </div>
        @else
            <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                @foreach ($pedidosRecorrentes as $recorrencia)
                    @php
                        $inicio = $recorrencia->data_inicio ?? $recorrencia->proxima_entrega;
                        $frequencia = match ($recorrencia->frequencia) {
                            'semanal' => 'Toda semana',
                            'quinzenal' => 'A cada 15 dias',
                            'mensal' => 'Todo mês',
                            default => 'A cada ' . $recorrencia->intervalo_dias . ' dias',
                        };
                        $diasSemana = ['domingo', 'segunda-feira', 'terça-feira', 'quarta-feira', 'quinta-feira', 'sexta-feira', 'sábado'];
                    @endphp
                    <article class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03] sm:p-5">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <h2 class="truncate text-base font-semibold text-gray-900 dark:text-white">{{ $recorrencia->cliente?->nome ?? 'Cliente removido' }}</h2>
                                @if ($recorrencia->cliente?->telefone)
                                    <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">{{ $recorrencia->cliente->telefone }}</p>
                                @endif
                            </div>
                            <button type="button"
                                title="Excluir recorrência"
                                aria-label="Excluir recorrência de {{ $recorrencia->cliente?->nome ?? 'cliente' }}"
                                @click="$dispatch('abrir-exclusao-recorrencia', { id: {{ $recorrencia->id }}, nome: @js(($recorrencia->cliente?->nome ?? 'Cliente') . ' - ' . ($recorrencia->produto?->nome ?? 'Produto')) })"
                                class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-red-200 text-red-600 transition hover:bg-red-50 dark:border-red-900/60 dark:text-red-300 dark:hover:bg-red-900/20">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path d="M4 7h16M10 11v6m4-6v6M5 7l1 13h12l1-13M9 7V4h6v3" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>

                        <dl class="mt-4 grid grid-cols-2 gap-x-4 gap-y-3 border-t border-gray-100 pt-4 dark:border-gray-800">
                            <div class="min-w-0">
                                <dt class="text-xs text-gray-500 dark:text-gray-400">Produto</dt>
                                <dd class="mt-0.5 truncate text-sm font-medium text-gray-800 dark:text-gray-200">{{ $recorrencia->produto?->nome ?? 'Produto removido' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-500 dark:text-gray-400">Quantidade</dt>
                                <dd class="mt-0.5 text-sm font-medium text-gray-800 dark:text-gray-200">{{ $recorrencia->quantidade }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-500 dark:text-gray-400">Período</dt>
                                <dd class="mt-0.5 text-sm font-medium text-gray-800 dark:text-gray-200">
                                    {{ $frequencia }}
                                    @if ($recorrencia->dia_semana !== null)
                                        <span class="block text-xs font-normal text-gray-500 dark:text-gray-400">{{ ucfirst($diasSemana[$recorrencia->dia_semana]) }}</span>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-500 dark:text-gray-400">Início</dt>
                                <dd class="mt-0.5 text-sm font-medium text-gray-800 dark:text-gray-200">{{ $inicio?->format('d/m/Y') ?? 'Não informado' }}</dd>
                            </div>
                        </dl>
                    </article>
                @endforeach
            </div>
        @endif
    </div>

    <x-ui.modal :isOpen="$errors->any()" x-on:abrir-cadastro-recorrencia.window="open = true" x-on:fechar-modal-recorrencia.window="open = false" class="max-w-[640px]">
        <div class="max-h-[90vh] overflow-y-auto p-5 sm:p-7">
            <div class="mb-5 pr-10">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Nova recorrência</h2>
            </div>

            <form method="POST" action="{{ route('pedidos-recorrentes.store') }}" x-data="pedidoRecorrenteForm(@js($clientes), @js($produtos), @js(old('cliente_id')), @js(old('frequencia', 'semanal')), @js(old('dia_semana')), @js(old('produto_id')), @js(old('cliente_nome')))" class="space-y-4">
                @csrf

                <div>
                    <label for="cliente-recorrencia" class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Cliente</label>
                    <input id="cliente-recorrencia" name="cliente_nome" type="text" x-model="clienteNome" list="clientes-recorrentes-list" placeholder="Digite para buscar o cliente" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:border-brand-300 focus:outline-none dark:border-gray-700 dark:text-white" required>
                    <input type="hidden" name="cliente_id" x-model="clienteId">
                    <datalist id="clientes-recorrentes-list">
                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->nome }}"></option>
                        @endforeach
                    </datalist>
                    @error('cliente_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="produto_id" class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Produto</label>
                        <select id="produto_id" name="produto_id" x-model="produtoId" required class="h-11 w-full rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-800 focus:border-brand-300 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="">Selecione</option>
                            @foreach ($produtos as $produto)
                                <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
                            @endforeach
                        </select>
                        @error('produto_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400" x-show="produtoSelecionado">
                            Valor vigente: <span class="font-medium" x-text="precoFormatado"></span>
                        </p>
                    </div>

                    <div>
                        <label for="quantidade" class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Quantidade por pedido</label>
                        <input id="quantidade" name="quantidade" type="number" min="1" step="1" inputmode="numeric" value="{{ old('quantidade', 1) }}" required class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-none dark:border-gray-700 dark:text-white">
                        @error('quantidade')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="frequencia" class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Período</label>
                        <select id="frequencia" name="frequencia" x-model="frequencia" required class="h-11 w-full rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-800 focus:border-brand-300 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="semanal">Toda semana</option>
                            <option value="quinzenal">De 15 em 15 dias</option>
                            <option value="mensal">De mês em mês</option>
                        </select>
                        @error('frequencia')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="dia_semana" class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Dia da semana</label>
                        <select id="dia_semana" name="dia_semana" x-model="diaSemana" required class="h-11 w-full rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-800 focus:border-brand-300 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="">Selecione</option>
                            <option value="0">Domingo</option>
                            <option value="1">Segunda-feira</option>
                            <option value="2">Terça-feira</option>
                            <option value="3">Quarta-feira</option>
                            <option value="4">Quinta-feira</option>
                            <option value="5">Sexta-feira</option>
                            <option value="6">Sábado</option>
                        </select>
                        @error('dia_semana')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="data_inicio" class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Data inicial</label>
                    <x-form.date-picker-custom id="data_inicio" name="data_inicio" label="" placeholder="Selecione a data" defaultDate="{{ old('data_inicio', now()->format('d/m/Y')) }}" dateFormat="d/m/Y" />
                    @error('data_inicio')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5 text-xs text-gray-600 dark:border-gray-700 dark:bg-gray-800/60 dark:text-gray-300">
                    Os pedidos serão gerados para os próximos seis meses.
                </div>

                <div class="flex flex-col-reverse gap-2 border-t border-gray-100 pt-4 dark:border-gray-800 sm:flex-row sm:justify-end">
                    <button type="button" @click="$dispatch('fechar-modal-recorrencia')" class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800">Cancelar</button>
                    <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-brand-600">Salvar recorrência</button>
                </div>
            </form>
        </div>
    </x-ui.modal>

    <x-ui.modal x-on:abrir-exclusao-recorrencia.window="open = true; $refs.deleteForm.action = '{{ url('pedidos-recorrentes') }}/' + $event.detail.id; $refs.deleteNome.textContent = $event.detail.nome" class="max-w-[500px]">
        <div class="p-5 sm:p-7">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Excluir recorrência</h2>
            <p class="mt-3 text-sm text-gray-600 dark:text-gray-300">
                Confirma a exclusão da recorrência de <strong x-ref="deleteNome" class="font-semibold text-gray-900 dark:text-white"></strong>?
            </p>
            <p class="mt-4 rounded-lg border border-yellow-200 bg-yellow-50 px-4 py-3 text-xs text-yellow-800 dark:border-yellow-900/60 dark:bg-yellow-900/20 dark:text-yellow-200">
                Os pedidos futuros ainda pendentes serão removidos. Pedidos concluídos serão mantidos.
            </p>
            <form x-ref="deleteForm" method="POST" action="{{ route('pedidos-recorrentes.index') }}" class="mt-6 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                @csrf
                @method('DELETE')
                <button type="button" @click="open = false" class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">Cancelar</button>
                <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-red-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-red-700">Excluir recorrência</button>
            </form>
        </div>
    </x-ui.modal>

    <script>
        function pedidoRecorrenteForm(clientes, produtos, clienteId, frequencia, diaSemana, produtoId, clienteNome) {
            const clienteInicial = clientes.find((cliente) => String(cliente.id) === String(clienteId));

            return {
                clientes,
                produtos,
                clienteId: clienteInicial ? String(clienteInicial.id) : '',
                clienteNome: clienteInicial ? clienteInicial.nome : String(clienteNome ?? ''),
                produtoId: String(produtoId ?? ''),
                frequencia,
                diaSemana: String(diaSemana ?? ''),
                get produtoSelecionado() {
                    return this.produtos.find((produto) => String(produto.id) === String(this.produtoId));
                },
                get precoFormatado() {
                    const preco = Number(this.produtoSelecionado?.preco || 0);
                    return preco.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                },
                init() {
                    this.$watch('clienteNome', () => {
                        const cliente = this.clientes.find((item) => item.nome === this.clienteNome);
                        this.clienteId = cliente ? String(cliente.id) : '';
                    });
                },
            };
        }
    </script>
@endsection
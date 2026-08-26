@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-4xl rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6">
        <div class="mb-5 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Novo pedido</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Cadastro rápido para entregas</p>
            </div>
            <a href="{{ route('pedidos.index') }}" class="text-sm text-gray-600 dark:text-gray-300">Voltar</a>
        </div>

        <form action="{{ route('pedidos.store') }}" method="POST" x-data="pedidoForm()" @submit.prevent="submitPedido">
            @csrf

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Cliente</label>
                    <input type="text" x-model="clienteNome" list="clientes-list" placeholder="Digite para buscar o cliente" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:border-brand-300 focus:outline-none dark:border-gray-700 dark:text-white" required>
                    <input type="hidden" name="cliente_id" x-model="cliente_id">
                    <datalist id="clientes-list">
                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->nome }}"></option>
                        @endforeach
                    </datalist>
                </div>

                <div>
                    <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Data de entrega</label>
                    <x-form.date-picker-custom name="data_entrega" label="" placeholder="Selecione a data" defaultDate="{{ date('d/m/Y') }}" dateFormat="d/m/Y" />
                </div>

                <div>
                    <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Observações</label>
                    <input type="text" name="observacoes" placeholder="Observações" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:border-brand-300 focus:outline-none dark:border-gray-700 dark:text-white">
                </div>
            </div>

            <div class="mt-6 rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-900/40">
                <div class="mb-3 flex items-center justify-between">
                    <h2 class="text-sm font-semibold text-gray-800 dark:text-white">Adicionar itens</h2>
                    <span class="text-xs text-gray-500 dark:text-gray-400" x-text="itens.length + ' item(s)'"></span>
                </div>

                <div class="grid grid-cols-1 gap-3 md:grid-cols-[1.4fr_0.8fr_1fr_auto]">
                    <div>
                        <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Produto</label>
                        <select x-model="produtoId" class="h-11 w-full rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="">Selecione</option>
                            @foreach ($produtos as $produto)
                                <option value="{{ $produto->id }}" data-preco="{{ $produto->preco }}">{{ $produto->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Qtd</label>
                        <input type="number" x-model.number="quantidade" min="1" inputmode="numeric" class="h-11 w-full rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white" value="1">
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Valor unitário</label>
                        <input type="number" x-model.number="valorUnitario" min="0" step="0.01" inputmode="decimal" class="h-11 w-full rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white" value="0">
                    </div>
                    <div class="flex items-end">
                        <button type="button" @click="adicionarItem" class="inline-flex h-11 items-center justify-center rounded-lg bg-brand-500 px-4 text-sm font-medium text-white">+ adicionar</button>
                    </div>
                </div>

                <div class="mt-4 space-y-2" x-show="itens.length > 0" x-cloak>
                    <template x-for="(item, index) in itens" :key="index">
                        <div class="flex items-center justify-between gap-3 rounded-lg border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-900">
                            <div>
                                <div class="text-sm font-medium text-gray-900 dark:text-white" x-text="item.nome"></div>
                                <div class="text-xs text-gray-500 dark:text-gray-400" x-text="item.quantidade + ' x R$ ' + Number(item.valor_unitario).toFixed(2).replace('.', ',')"></div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-200" x-text="'R$ ' + Number(item.valor_total).toFixed(2).replace('.', ',')"></span>
                                <button type="button" @click="removerItem(index)" class="text-lg text-red-500">×</button>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="mt-5 flex items-center justify-between border-t border-gray-200 pt-4 dark:border-gray-700">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-200">Total do pedido</span>
                    <span class="text-lg font-bold text-gray-900 dark:text-white" x-text="'R$ ' + totalPedido.toFixed(2).replace('.', ',')"></span>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-5 py-3 text-sm font-medium text-white dark:bg-brand-500">Salvar pedido</button>
            </div>

            <template x-if="mensagem">
                <div class="mt-4 rounded-lg border px-3 py-2 text-sm" :class="sucesso ? 'border-green-200 bg-green-50 text-green-700 dark:border-green-800 dark:bg-green-900/20 dark:text-green-200' : 'border-red-200 bg-red-50 text-red-700 dark:border-red-800 dark:bg-red-900/20 dark:text-red-200'" x-text="mensagem"></div>
            </template>
        </form>
    </div>

    <script>
        function pedidoForm() {
            return {
                cliente_id: '',
                clienteNome: '',
                produtoId: '',
                quantidade: 1,
                valorUnitario: 0,
                itens: [],
                mensagem: '',
                sucesso: false,
                get totalPedido() {
                    return this.itens.reduce((acc, item) => acc + Number(item.valor_total || 0), 0);
                },
                adicionarItem() {
                    const produtoSelect = document.querySelector('select[x-model="produtoId"]');
                    const selectedOption = produtoSelect ? produtoSelect.options[produtoSelect.selectedIndex] : null;
                    if (!this.produtoId || Number(this.quantidade) <= 0) {
                        this.mensagem = 'Selecione um produto e informe uma quantidade maior que zero.';
                        this.sucesso = false;
                        return;
                    }

                    const produtoNome = selectedOption ? selectedOption.text : 'Produto';
                    const valor = Number(this.valorUnitario || 0);
                    const qtd = Number(this.quantidade || 0);
                    const valorTotal = valor * qtd;

                    this.itens.push({
                        produto_id: this.produtoId,
                        nome: produtoNome,
                        quantidade: qtd,
                        valor_unitario: valor,
                        valor_total: valorTotal,
                    });

                    this.produtoId = '';
                    this.quantidade = 1;
                    this.valorUnitario = 0;
                    this.mensagem = '';
                },
                removerItem(index) {
                    this.itens.splice(index, 1);
                    this.mensagem = '';
                },
                submitPedido() {
                    if (!this.clienteNome || !this.cliente_id) {
                        this.mensagem = 'Selecione um cliente válido.';
                        this.sucesso = false;
                        return;
                    }

                    if (!this.itens.length) {
                        this.mensagem = 'Adicione pelo menos um item ao pedido.';
                        this.sucesso = false;
                        return;
                    }

                    const form = document.querySelector('form[action*="pedidos"]');
                    const items = this.itens.map((item) => ({
                        produto_id: item.produto_id,
                        quantidade: item.quantidade,
                        valor_unitario: item.valor_unitario,
                    }));

                    const payload = {
                        cliente_id: this.cliente_id,
                        data_entrega: form.querySelector('[name="data_entrega"]').value,
                        observacoes: form.querySelector('[name="observacoes"]').value,
                        items,
                    };

                    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    fetch('{{ route('pedidos.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify(payload)
                    }).then(async (response) => {
                        if (response.redirected || response.ok) {
                            this.sucesso = true;
                            this.mensagem = 'Pedido salvo com sucesso!';
                            window.location.href = '{{ route('pedidos.index') }}';
                            return;
                        }

                        const data = await response.json().catch(() => ({}));
                        this.sucesso = false;
                        this.mensagem = data.message || 'Erro ao salvar pedido.';
                    }).catch(() => {
                        this.sucesso = false;
                        this.mensagem = 'Erro ao salvar pedido.';
                    });
                },
                init() {
                    const clientes = @json($clientes);
                    this.$watch('clienteNome', () => {
                        const cliente = clientes.find((c) => c.nome === this.clienteNome);
                        this.cliente_id = cliente ? cliente.id : '';
                    });

                    const produtoSelect = document.querySelector('select[x-model="produtoId"]');
                    if (produtoSelect) {
                        produtoSelect.addEventListener('change', (event) => {
                            const selected = event.target.selectedOptions[0];
                            const preco = selected && selected.dataset.preco ? Number(selected.dataset.preco) : 0;
                            this.valorUnitario = preco;
                            this.produtoId = selected ? selected.value : '';
                        });
                    }
                }
            }
        }
    </script>
@endsection

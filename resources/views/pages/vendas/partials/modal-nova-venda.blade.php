<div class="p-6 dark:bg-transparent lg:p-10">
    <h2 class="mb-6 text-lg font-bold text-gray-800 dark:text-white">Nova Venda</h2>
    <form id="vendaForm" class="grid grid-cols-1 gap-4" x-data="novaVendaFormHandler()" @submit.prevent="submitVenda">
                <template x-if="mensagem">
                    <div :class="{'bg-green-100 text-green-800': sucesso, 'bg-red-100 text-red-800': !sucesso}" class="rounded-lg px-4 py-2 mb-2 text-sm font-semibold">
                        <span x-text="mensagem"></span>
                    </div>
                </template>
        <div class="col-span-1">
            <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Cliente</label>
            <input type="text" name="cliente_nome" x-model="cliente_nome" list="clientes-list" @input="onClienteInput"
                placeholder="Digite para buscar o cliente"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:text-white/90 dark:border-gray-700 dark:bg-gray-900 dark:placeholder:text-white/30 transition-all" required />
            <input type="hidden" name="cliente_id" x-model="cliente_id" />
            <datalist id="clientes-list">
                <template x-for="cliente in clientes" :key="cliente.id">
                    <option :value="cliente.nome"></option>
                </template>
            </datalist>
        </div>
        <div class="col-span-1 rounded-xl border border-gray-200 p-4 dark:border-gray-700">
            <div class="mb-3 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white">Adicionar itens</h3>
                <span class="text-xs text-gray-500 dark:text-gray-400" x-text="itens.length + ' item(s)'"></span>
            </div>
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-[1.4fr_0.7fr_1fr_auto]">
                <div>
                    <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Produto</label>
                    <select x-model="produto_id" @change="atualizaValor()"
                        class="dark:bg-dark-900 shadow-theme-xs h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                        <option value="">Selecione o produto</option>
                        <template x-for="produto in produtos" :key="produto.id">
                            <option :value="produto.id" x-text="produto.nome"></option>
                        </template>
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Quantidade</label>
                    <input type="number" min="1" x-model.number="quantidade"
                        class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                </div>
                <div>
                    <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Valor unitário</label>
                    <input type="text" :value="valor === '' ? '' : 'R$ ' + Number(valor).toFixed(2).replace('.', ',')" placeholder="Definido pelo produto" readonly
                        class="h-11 w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2.5 text-sm text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300" />
                </div>
                <div class="flex items-end">
                    <button type="button" @click="adicionarItem" class="h-11 w-full rounded-lg bg-brand-500 px-4 text-sm font-medium text-white transition hover:bg-brand-600">Adicionar</button>
                </div>
            </div>

            <div class="mt-4 space-y-2" x-show="itens.length > 0" x-cloak>
                <template x-for="(item, index) in itens" :key="index">
                    <div class="flex items-center justify-between gap-3 rounded-lg border border-gray-200 bg-gray-50 p-3 dark:border-gray-700 dark:bg-gray-900/60">
                        <div class="min-w-0">
                            <div class="truncate text-sm font-medium text-gray-900 dark:text-white" x-text="item.nome"></div>
                            <div class="text-xs text-gray-500 dark:text-gray-400" x-text="item.quantidade + ' x R$ ' + Number(item.valor).toFixed(2).replace('.', ',')"></div>
                        </div>
                        <div class="flex shrink-0 items-center gap-3">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-200" x-text="'R$ ' + Number(item.subtotal).toFixed(2).replace('.', ',')"></span>
                            <button type="button" @click="removerItem(index)" :aria-label="'Remover ' + item.nome" class="text-lg leading-none text-red-600 hover:text-red-700">&times;</button>
                        </div>
                    </div>
                </template>
            </div>
            <div class="mt-4 flex items-center justify-between border-t border-gray-200 pt-3 dark:border-gray-700">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-200">Total da venda</span>
                <span class="text-base font-bold text-gray-900 dark:text-white" x-text="'R$ ' + totalVenda.toFixed(2).replace('.', ',')"></span>
            </div>
        </div>
        <div class="col-span-1">
            <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Pagamento</label>
            <div class="relative">
                <select name="status_pagamento" x-model="status_pagamento" required
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:text-white/90 dark:border-gray-700 dark:bg-gray-900 dark:placeholder:text-white/30 transition-all appearance-none">
                    <option value="pago">Pago</option>
                    <option value="anotado">Anotar para pagar depois</option>
                </select>
                <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                </span>
            </div>
        </div>
        <div class="col-span-1">
            <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Data</label>
            <x-form.date-picker-custom name="data" label="" placeholder="Selecione a data" defaultDate="{{ date('d/m/Y') }}" dateFormat="d/m/Y" />
        </div>
        <div class="flex justify-end mt-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Salvar</button>
        </div>
    </form>
    <script>
        function novaVendaFormHandler() {
            return {
                mensagem: '',
                sucesso: false,
                clientes: [],
                produtos: [],
                cliente_id: '',
                produto_id: '',
                cliente_nome: '',
                quantidade: 1,
                valor: '',
                itens: [],
                status_pagamento: 'pago',
                data: new Date().toISOString().slice(0, 10),
                get totalVenda() {
                    return this.itens.reduce((total, item) => total + Number(item.subtotal), 0);
                },
                async fetchClientes() {
                    const res = await fetch('/api/clientes');
                    this.clientes = await res.json();
                },
                async fetchProdutos() {
                    const res = await fetch('/api/produtos');
                    this.produtos = await res.json();
                },
                atualizaValor() {
                    const prod = this.produtos.find(p => p.id == this.produto_id);
                    this.valor = prod ? Number(prod.preco) : '';
                },
                adicionarItem() {
                    const produto = this.produtos.find(p => p.id == this.produto_id);
                    const quantidade = Number(this.quantidade);
                    const valor = Number(this.valor);

                    if (!produto || quantidade < 1 || !Number.isFinite(quantidade) || valor < 0 || !Number.isFinite(valor)) {
                        this.mensagem = 'Selecione um produto e informe quantidade e valor válidos.';
                        this.sucesso = false;
                        return;
                    }

                    this.itens.push({
                        produto_id: produto.id,
                        nome: produto.nome,
                        quantidade,
                        valor,
                        subtotal: quantidade * valor,
                    });
                    this.produto_id = '';
                    this.quantidade = 1;
                    this.valor = '';
                    this.mensagem = '';
                },
                removerItem(index) {
                    this.itens.splice(index, 1);
                },
                onClienteInput() {
                    const c = this.clientes.find(cl => cl.nome === this.cliente_nome);
                    this.cliente_id = c ? c.id : '';
                },
                onProdutoInput() {
                    const p = this.produtos.find(pr => pr.nome === this.produto_nome);
                    this.produto_id = p ? p.id : '';
                    if (p) this.valor = p.preco;
                },
                async submitVenda() {
                    if (!this.cliente_id) {
                        this.mensagem = 'Selecione um cliente válido.';
                        this.sucesso = false;
                        return;
                    }
                    if (!this.itens.length) {
                        this.mensagem = 'Adicione pelo menos um item à venda.';
                        this.sucesso = false;
                        return;
                    }

                    const form = document.getElementById('vendaForm');
                    const data = {
                        cliente_id: this.cliente_id,
                        status_pagamento: this.status_pagamento,
                        data: form.querySelector('[name="data"]').value,
                        items: this.itens.map(item => ({
                            produto_id: item.produto_id,
                            quantidade: item.quantidade,
                            valor: item.valor,
                        })),
                    };
                    try {
                        const response = await fetch('/vendas', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify(data)
                        });
                        if (response.ok) {
                            this.mensagem = 'Venda cadastrada com sucesso!';
                            this.sucesso = true;
                            form.reset();
                            this.itens = [];
                            setTimeout(() => {
                                this.mensagem = '';
                                window.dispatchEvent(new CustomEvent('close-modal'));
                                window.location.reload();
                            }, 1200);
                        } else {
                            this.mensagem = 'Erro ao cadastrar venda.';
                            this.sucesso = false;
                        }
                    } catch (err) {
                        this.mensagem = 'Erro ao cadastrar venda.';
                        this.sucesso = false;
                    }
                },
                init() {
                    this.fetchClientes();
                    this.fetchProdutos();
                }
            }
        }
    </script>
</div>

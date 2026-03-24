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
            <select name="cliente_id" x-model="cliente_id" required
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:text-white/90 dark:border-gray-700 dark:bg-gray-900 dark:placeholder:text-white/30 transition-all">
                <option value="" disabled selected>Selecione o cliente</option>
                <template x-for="cliente in clientes" :key="cliente.id">
                    <option :value="cliente.id" x-text="cliente.nome"></option>
                </template>
            </select>
        </div>
        <div class="col-span-1">
            <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Produto</label>
            <select name="produto_id" x-model="produto_id" @change="atualizaValor()" required
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:text-white/90 dark:border-gray-700 dark:bg-gray-900 dark:placeholder:text-white/30 transition-all">
                <option value="" disabled selected>Selecione o produto</option>
                <template x-for="produto in produtos" :key="produto.id">
                    <option :value="produto.id" x-text="produto.nome"></option>
                </template>
            </select>
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
            <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Quantidade</label>
            <input type="number" name="quantidade" min="1" placeholder="Quantidade" x-model="quantidade"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 transition-all" required />
        </div>
        <div class="col-span-1">
            <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Valor</label>
            <input type="number" name="valor" min="0" step="0.01" placeholder="Valor" x-model="valor"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 transition-all" required />
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
                quantidade: 1,
                valor: '',
                status_pagamento: 'pago',
                data: new Date().toISOString().slice(0, 10),
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
                    if (prod) this.valor = prod.preco;
                },
                async submitVenda() {
                    const form = document.getElementById('vendaForm');
                    const formData = new FormData(form);
                    const data = Object.fromEntries(formData.entries());
                    // O valor do campo data será enviado conforme selecionado no input
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

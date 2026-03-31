<div class="p-6 dark:bg-transparent lg:p-10"
    x-data="registrarPagamentoFormHandler()"
    x-effect="venda_id = $store.pagamento.venda_id; cliente_nome = $store.pagamento.cliente_nome; saldo_display = $store.pagamento.saldo_display; saldo_pendente = $store.pagamento.saldo_pendente; valor = saldo_pendente;">

    <h2 class="mb-6 text-lg font-bold text-gray-800 dark:text-white">Registrar Pagamento</h2>
    <form id="pagamentoForm" class="grid grid-cols-1 gap-4" @submit.prevent="submitPagamento">
        <template x-if="mensagem">
            <div :class="{'bg-green-100 text-green-800': sucesso, 'bg-red-100 text-red-800': !sucesso}" class="rounded-lg px-4 py-2 mb-2 text-sm font-semibold">
                <span x-text="mensagem"></span>
            </div>
        </template>

        <div class="col-span-1">
            <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Cliente</label>
            <input type="text" x-model="cliente_nome" disabled
                class="dark:bg-dark-900 shadow-theme-xs h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:text-white/90 dark:border-gray-700 dark:bg-gray-900 dark:placeholder:text-white/30 transition-all cursor-not-allowed opacity-70" />
        </div>

        <div class="col-span-1">
            <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Saldo Pendente</label>
            <input type="text" x-model="saldo_display" disabled
                class="dark:bg-dark-900 shadow-theme-xs h-11 w-full rounded-lg border border-red-300 bg-red-50 px-4 py-2.5 text-sm font-semibold text-red-700 dark:bg-red-900/20 dark:border-red-700 dark:text-red-400 dark:placeholder:text-white/30 transition-all cursor-not-allowed" />
        </div>

        <input type="hidden" x-model="venda_id" name="venda_id">

        <div class="col-span-1">
            <label for="valor" class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Valor a Pagar *</label>
            <input type="number" name="valor" min="0" step="0.01" placeholder="0.00" x-model="valor" :max="saldo_pendente"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 transition-all" required />
        </div>

        <div class="col-span-1">
            <label for="data_pagamento" class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Data do Pagamento</label>
            <input type="date" name="data_pagamento" x-model="data_pagamento"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:text-white/90 dark:border-gray-700 dark:bg-gray-900 dark:placeholder:text-white/30 transition-all" />
        </div>

        <div class="col-span-1">
            <label for="observacoes" class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Observações</label>
            <textarea name="observacoes" x-model="observacoes" rows="3" placeholder="Adicione observações sobre este pagamento (opcional)"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 transition-all"></textarea>
        </div>

        <div class="flex justify-end gap-3 mt-2">
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition font-medium">
                Registrar Pagamento
            </button>
        </div>
    </form>
    <script>
        function registrarPagamentoFormHandler() {
            return {
                mensagem: '',
                sucesso: false,
                venda_id: '',
                cliente_nome: '',
                saldo_display: '',
                saldo_pendente: 0,
                valor: '',
                data_pagamento: '',
                observacoes: '',
                init() {
                    // Inicializa com data de hoje (usando hora local, não UTC)
                    const today = new Date();
                    const year = today.getFullYear();
                    const month = String(today.getMonth() + 1).padStart(2, '0');
                    const date = String(today.getDate()).padStart(2, '0');
                    this.data_pagamento = `${year}-${month}-${date}`;
                },
                async submitPagamento() {
                    // Validar se valor é maior que saldo pendente
                    if (parseFloat(this.valor) > this.saldo_pendente) {
                        this.mensagem = 'O valor não pode ser maior que o saldo pendente!';
                        this.sucesso = false;
                        return;
                    }
                    
                    const form = document.getElementById('pagamentoForm');
                    const formData = new FormData(form);
                    const data = Object.fromEntries(formData.entries());
                    try {
                        const response = await fetch('/vendas/pagamentos', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify(data)
                        });
                        if (response.ok) {
                            this.mensagem = 'Pagamento registrado com sucesso!';
                            this.sucesso = true;
                            form.reset();
                            setTimeout(() => {
                                this.mensagem = '';
                                window.dispatchEvent(new CustomEvent('close-modal'));
                                window.location.reload();
                            }, 1200);
                        } else {
                            this.mensagem = 'Erro ao registrar pagamento.';
                            this.sucesso = false;
                        }
                    } catch (err) {
                        this.mensagem = 'Erro ao registrar pagamento.';
                        this.sucesso = false;
                    }
                }
            }
        }
    </script>
</div>

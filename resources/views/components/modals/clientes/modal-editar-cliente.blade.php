<div class="p-6 dark:bg-transparent lg:p-10"
    x-data="editarClienteFormHandler()"
    x-effect="cliente_id = $store.cliente.id; cliente_nome = $store.cliente.nome; cliente_telefone = $store.cliente.telefone; cliente_email = $store.cliente.email; cliente_data_nascimento = formatDateToBR($store.cliente.data_nascimento); cliente_endereco = $store.cliente.endereco; cliente_observacoes = $store.cliente.observacoes;">

    <h2 class="mb-6 text-lg font-bold text-gray-800 dark:text-white">Editar Cliente</h2>
    <form id="editarClienteForm" class="grid grid-cols-1 gap-4" @submit.prevent="submitCliente">
        <template x-if="mensagem">
            <div :class="{'bg-green-100 text-green-800': sucesso, 'bg-red-100 text-red-800': !sucesso}" class="rounded-lg px-4 py-2 mb-2 text-sm font-semibold">
                <span x-text="mensagem"></span>
            </div>
        </template>

        <input type="hidden" x-model="cliente_id" name="cliente_id">

        <div class="col-span-1">
            <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Nome *</label>
            <input type="text" name="nome" x-model="cliente_nome" placeholder="Nome do cliente"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 transition-all" required />
        </div>

        <div class="col-span-1">
            <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Telefone</label>
            <input type="text" name="telefone" x-model="cliente_telefone" x-mask="(99) 99999-9999" placeholder="(99) 99999-9999"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 transition-all" />
        </div>

        <div class="col-span-1">
            <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Email</label>
            <input type="email" name="email" x-model="cliente_email" placeholder="Email do cliente"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 transition-all" />
        </div>

        <div class="col-span-1">
            <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Data de Nascimento</label>
            <input 
                type="text" 
                name="data_nascimento"
                x-model="cliente_data_nascimento"
                x-mask="99/99/9999"
                placeholder="DD/MM/AAAA"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 transition-all"
            />
        </div>

        <div class="col-span-1">
            <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Endereço</label>
            <input type="text" name="endereco" x-model="cliente_endereco" placeholder="Endereço do cliente"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 transition-all" />
        </div>

        <div class="col-span-1">
            <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Observações</label>
            <textarea name="observacoes" x-model="cliente_observacoes" rows="3" placeholder="Observações sobre o cliente (opcional)"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 transition-all"></textarea>
        </div>

        <div class="flex justify-end gap-3 mt-4">
            <button type="button" @click="open = false" class="px-4 py-2 border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition font-medium">
                Cancelar
            </button>
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition font-medium">
                Salvar Alterações
            </button>
        </div>
    </form>

    <script>
        function editarClienteFormHandler() {
            return {
                mensagem: '',
                sucesso: false,
                cliente_id: '',
                cliente_nome: '',
                cliente_telefone: '',
                cliente_email: '',
                cliente_data_nascimento: '',
                cliente_endereco: '',
                cliente_observacoes: '',
                
                formatDateToBR(dateStr) {
                    if (!dateStr) return '';
                    // Se já está em formato DD/MM/AAAA, retorna como está
                    if (dateStr.includes('/')) {
                        return dateStr;
                    }
                    // Se é formato ISO com timestamp (contém T e Z), extrai apenas a data
                    if (dateStr.includes('T')) {
                        dateStr = dateStr.split('T')[0];
                    }
                    // Converte de Y-m-d para DD/MM/AAAA
                    if (dateStr.includes('-')) {
                        const parts = dateStr.split('-');
                        if (parts.length === 3) {
                            return parts[2].padStart(2, '0') + '/' + parts[1].padStart(2, '0') + '/' + parts[0];
                        }
                    }
                    return dateStr;
                },
                
                convertDateToISO(dateStr) {
                    if (!dateStr) return '';
                    // Se já está em formato Y-m-d, retorna como está
                    if (dateStr.includes('-') && !dateStr.includes('/')) {
                        return dateStr;
                    }
                    // Converte de DD/MM/AAAA para Y-m-d
                    const parts = dateStr.split('/');
                    if (parts.length === 3) {
                        return parts[2] + '-' + parts[1] + '-' + parts[0];
                    }
                    return dateStr;
                },
                
                async submitCliente() {
                    const form = document.getElementById('editarClienteForm');
                    const formData = new FormData(form);
                    
                    // Converter dados para objeto
                    const data = {
                        nome: formData.get('nome'),
                        telefone: formData.get('telefone'),
                        email: formData.get('email'),
                        data_nascimento: this.convertDateToISO(formData.get('data_nascimento')),
                        endereco: formData.get('endereco'),
                        observacoes: formData.get('observacoes'),
                    };
                    
                    try {
                        const response = await fetch(`/clientes/${this.cliente_id}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify(data)
                        });
                        
                        if (response.ok) {
                            const result = await response.json();
                            this.mensagem = result.message || 'Cliente atualizado com sucesso!';
                            this.sucesso = true;
                            
                            // Aguardar 1.5 segundos e depois recarregar
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            const result = await response.json();
                            this.mensagem = result.message || 'Erro ao atualizar cliente.';
                            this.sucesso = false;
                        }
                    } catch (err) {
                        console.error('Erro:', err);
                        this.mensagem = 'Erro ao enviar formulário.';
                        this.sucesso = false;
                    }
                }
            }
        }
    </script>
</div>

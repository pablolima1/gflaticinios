<div class="p-6 dark:bg-transparent lg:p-10"
    x-data="editarProdutoFormHandler()"
    x-effect="produto_id = $store.produto.id; produto_nome = $store.produto.nome; produto_descricao = $store.produto.descricao; produto_preco = $store.produto.preco; produto_unidade_medida = $store.produto.unidade_medida; produto_ativo = $store.produto.ativo;">

    <h2 class="mb-6 text-lg font-bold text-gray-800 dark:text-white">Editar Produto</h2>
    <form id="editarProdutoForm" class="grid grid-cols-1 gap-4" @submit.prevent="submitProduto">
        <template x-if="mensagem">
            <div :class="{'bg-green-100 text-green-800': sucesso, 'bg-red-100 text-red-800': !sucesso}" class="rounded-lg px-4 py-2 mb-2 text-sm font-semibold">
                <span x-text="mensagem"></span>
            </div>
        </template>

        <input type="hidden" x-model="produto_id" name="produto_id">

        <div class="col-span-1">
            <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Nome *</label>
            <input type="text" name="nome" x-model="produto_nome" placeholder="Nome do produto"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 transition-all" required />
        </div>

        <div class="col-span-1">
            <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Descrição</label>
            <input type="text" name="descricao" x-model="produto_descricao" placeholder="Descrição do produto"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 transition-all" />
        </div>

        <div class="col-span-1">
            <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Preço *</label>
            <input type="number" name="preco" min="0" step="0.01" x-model="produto_preco" placeholder="0.00"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 transition-all" required />
        </div>

        <div class="col-span-1">
            <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Unidade de Medida</label>
            <input type="text" name="unidade_medida" x-model="produto_unidade_medida" placeholder="Ex: kg, litro, unidade"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 transition-all" />
        </div>

        <div class="col-span-1 flex items-center gap-2">
            <input type="checkbox" name="ativo" x-model="produto_ativo" value="1" 
                class="w-4 h-4 rounded border-gray-300 dark:border-gray-700 cursor-pointer" />
            <label class="text-xs font-semibold text-gray-700 dark:text-gray-300">Ativo</label>
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
        function editarProdutoFormHandler() {
            return {
                mensagem: '',
                sucesso: false,
                produto_id: '',
                produto_nome: '',
                produto_descricao: '',
                produto_preco: '',
                produto_unidade_medida: '',
                produto_ativo: false,
                async submitProduto() {
                    const form = document.getElementById('editarProdutoForm');
                    const formData = new FormData(form);
                    
                    // Converter dados para objeto
                    const data = {
                        nome: formData.get('nome'),
                        descricao: formData.get('descricao'),
                        preco: parseFloat(formData.get('preco')),
                        unidade_medida: formData.get('unidade_medida'),
                        ativo: formData.get('ativo') ? true : false,
                    };
                    
                    try {
                        const response = await fetch(`/produtos/${this.produto_id}`, {
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
                            this.mensagem = result.message || 'Produto atualizado com sucesso!';
                            this.sucesso = true;
                            
                            // Aguardar 1.5 segundos e depois recarregar
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            const result = await response.json();
                            this.mensagem = result.message || 'Erro ao atualizar produto.';
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

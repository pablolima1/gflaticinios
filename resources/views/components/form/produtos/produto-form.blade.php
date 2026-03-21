<form id="produtoForm" action="{{ route('produtos.store') }}" method="POST" class="space-y-4" x-data="produtoFormHandler()" @submit.prevent="submitProduto">
    @csrf
    <x-common.component-card title="Preencha os dados do produto">
        <!-- Nome -->
        <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                Nome *
            </label>
            <input name="nome" type="text" placeholder="Nome do produto"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" required />
        </div>
        <!-- Descrição -->
        <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                Descrição
            </label>
            <input name="descricao" type="text" placeholder="Descrição do produto"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
        </div>
        <!-- Preço -->
        <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                Preço *
            </label>
            <input name="preco" type="number" step="0.01" min="0" placeholder="0,00"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" required />
        </div>
        <!-- Unidade de Medida -->
        <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                Unidade de Medida
            </label>
            <input name="unidade_medida" type="text" placeholder="Ex: kg, litro, unidade"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
        </div>
        <!-- Ativo -->
        <div class="flex items-center">
            <input name="ativo" type="checkbox" value="1" checked class="mr-2" />
            <label class="text-sm font-medium text-gray-700 dark:text-gray-400">Ativo</label>
        </div>
        <x-ui.button type="submit">Cadastrar Produto</x-ui.button>
    </x-common.component-card>
</form>
<script>
    function produtoFormHandler() {
        return {
            async submitProduto() {
                const form = document.getElementById('produtoForm');
                const formData = new FormData(form);
                const data = Object.fromEntries(formData.entries());
                data.ativo = formData.get('ativo') ? 1 : 0;
                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(data)
                    });
                    if (response.ok) {
                        form.reset();
                        window.dispatchEvent(new CustomEvent('close-modal-produto'));
                        window.location.reload();
                    } else {
                        const error = await response.json();
                        alert(error.message || 'Erro ao cadastrar produto.');
                    }
                } catch (e) {
                    alert('Erro ao cadastrar produto.');
                }
            }
        }
    }
</script>

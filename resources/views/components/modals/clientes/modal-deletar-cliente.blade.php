<div class="p-6 dark:bg-transparent lg:p-10"
    x-data="deletarClienteFormHandler()"
    x-effect="cliente_id = $store.cliente.id; cliente_nome = $store.cliente.nome;">

    <h2 class="mb-6 text-lg font-bold text-gray-800 dark:text-white">Confirmar Deleção</h2>
    
    <template x-if="mensagem">
        <div :class="{'bg-green-100 text-green-800': sucesso, 'bg-red-100 text-red-800': !sucesso}" class="rounded-lg px-4 py-2 mb-4 text-sm font-semibold">
            <span x-text="mensagem"></span>
        </div>
    </template>

    <div class="mb-6">
        <p class="text-gray-700 dark:text-gray-300 mb-4">
            Tem certeza que deseja deletar o cliente <strong x-text="cliente_nome" class="text-red-600 dark:text-red-400"></strong>?
        </p>
        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-lg p-4">
            <p class="text-sm text-yellow-800 dark:text-yellow-200">
                <strong>Atenção:</strong> Esta ação não pode ser desfeita. O cliente será removido permanentemente do sistema.
            </p>
        </div>
    </div>

    <form id="deletarClienteForm" @submit.prevent="submitDelete">
        <input type="hidden" x-model="cliente_id" name="cliente_id">
        
        <div class="flex justify-end gap-3">
            <button type="button" class="px-4 py-2 border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition font-medium" @click="open = false">
                Cancelar
            </button>
            <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition font-medium">
                Deletar Permanentemente
            </button>
        </div>
    </form>

    <script>
        function deletarClienteFormHandler() {
            return {
                mensagem: '',
                sucesso: false,
                cliente_id: '',
                cliente_nome: '',
                async submitDelete() {
                    const form = document.getElementById('deletarClienteForm');
                    
                    try {
                        const response = await fetch(`/clientes/${this.cliente_id}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });
                        
                        if (response.ok) {
                            const result = await response.json();
                            this.mensagem = result.message || 'Cliente deletado com sucesso!';
                            this.sucesso = true;
                            
                            // Aguardar 1.5 segundos e depois recarregar
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            const result = await response.json();
                            this.mensagem = result.message || 'Erro ao deletar cliente.';
                            this.sucesso = false;
                        }
                    } catch (err) {
                        console.error('Erro:', err);
                        this.mensagem = 'Erro ao processar deleção.';
                        this.sucesso = false;
                    }
                }
            }
        }
    </script>
</div>

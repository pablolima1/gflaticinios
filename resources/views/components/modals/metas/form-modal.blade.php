@props(['meta' => null])

<x-ui.modal @open-meta-modal.window="open = true" 
    @open-meta-edit-modal-internal.window="openEditMode($event.detail)"
    class="max-w-[700px] max-h-[90vh] overflow-y-auto">
    <div class="relative w-full rounded-3xl bg-white p-6 dark:bg-gray-900 lg:p-10" x-data="metaFormHandler()">
        <!-- Título -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-800 dark:text-white" x-text="isEdit ? 'Editar Meta' : 'Cadastro de Meta'"></h2>
            <button @click="open = false" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Mensagens -->
        <template x-if="mensagem">
            <div :class="{'bg-green-100 text-green-800': sucesso, 'bg-red-100 text-red-800': !sucesso}" 
                class="rounded-lg px-4 py-2 mb-4 text-sm font-semibold">
                <span x-text="mensagem"></span>
            </div>
        </template>

        <!-- Formulário -->
        <form id="metaForm" class="grid grid-cols-1 gap-4" @submit.prevent="submitMeta">
            <!-- Mês/Ano -->
            <div class="col-span-1">
                <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">
                    Período (Mês/Ano)
                </label>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <select name="mes" x-model="formData.mes" 
                            class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-blue-800 transition-all">
                            <option value="">Selecione o mês</option>
                            <option value="1">Janeiro</option>
                            <option value="2">Fevereiro</option>
                            <option value="3">Março</option>
                            <option value="4">Abril</option>
                            <option value="5">Maio</option>
                            <option value="6">Junho</option>
                            <option value="7">Julho</option>
                            <option value="8">Agosto</option>
                            <option value="9">Setembro</option>
                            <option value="10">Outubro</option>
                            <option value="11">Novembro</option>
                            <option value="12">Dezembro</option>
                        </select>
                    </div>
                    <div>
                        <input type="number" name="ano" x-model.number="formData.ano" placeholder="Ano"
                            min="2020" max="2099"
                            class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-blue-800 transition-all" />
                    </div>
                </div>
            </div>

            <!-- Valor da Meta -->
            <div class="col-span-1">
                <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">
                    Valor da Meta
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                        R$
                    </span>
                    <input type="number" name="valor_meta" x-model.number="formData.valor_meta" 
                        placeholder="0,00" step="0.01" min="0"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent pl-12 pr-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-blue-800 transition-all" />
                </div>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    <span x-text="'Valor formatado: R$ ' + (formData.valor_meta || 0).toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2})"></span>
                </p>
            </div>

            <!-- Status -->
            <div class="col-span-1">
                <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">
                    Status
                </label>
                <select name="status" x-model="formData.status"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-blue-800 transition-all">
                    <option value="ativa">Ativa</option>
                    <option value="inativa">Inativa</option>
                </select>
            </div>

            <!-- Botões -->
            <div class="flex justify-end gap-3 mt-2">
                <x-ui.button type="button" variant="secondary" size="sm" @click="open = false">
                    Cancelar
                </x-ui.button>
                <button type="submit" 
                    class="inline-flex items-center justify-center font-medium gap-2 rounded-lg transition px-4 py-3 text-sm bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 disabled:bg-brand-300 disabled:cursor-not-allowed disabled:opacity-50"
                    :disabled="isSubmitting"
                    x-text="isSubmitting ? 'Salvando...' : (isEdit ? 'Atualizar' : 'Salvar')">
                </button>
            </div>
        </form>

        <script>
            function metaFormHandler() {
                return {
                    formData: {
                        mes: '',
                        ano: new Date().getFullYear(),
                        valor_meta: '',
                        status: 'ativa',
                    },
                    mensagem: '',
                    sucesso: false,
                    isEdit: false,
                    isSubmitting: false,
                    metaId: null,

                    init() {
                        // Listener para abrir modo criar
                        window.addEventListener('open-meta-modal', () => {
                            this.resetForm();
                            this.isEdit = false;
                            this.metaId = null;
                        });

                        // Listener para abrir modo editar
                        window.addEventListener('open-meta-edit-modal-internal', (e) => {
                            this.openEditMode(e.detail);
                        });
                    },

                    resetForm() {
                        this.formData = {
                            mes: '',
                            ano: new Date().getFullYear(),
                            valor_meta: '',
                            status: 'ativa',
                        };
                        this.mensagem = '';
                        this.sucesso = false;
                    },

                    openEditMode(metaData) {
                        const dataInicio = new Date(metaData.data_inicio);
                        this.formData.mes = String(dataInicio.getMonth() + 1);
                        this.formData.ano = dataInicio.getFullYear();
                        this.formData.valor_meta = parseFloat(metaData.valor_meta);
                        this.formData.status = metaData.status;
                        this.isEdit = true;
                        this.metaId = metaData.id;
                        this.mensagem = '';
                        this.sucesso = false;
                    },

                    async submitMeta() {
                        this.isSubmitting = true;
                        
                        // Validação
                        if (!this.formData.mes || !this.formData.ano || !this.formData.valor_meta) {
                            this.mensagem = 'Por favor, preencha todos os campos obrigatórios.';
                            this.sucesso = false;
                            this.isSubmitting = false;
                            return;
                        }

                        // Construir datas
                        const mesNum = parseInt(this.formData.mes);
                        const anoNum = parseInt(this.formData.ano);
                        const dataInicio = new Date(anoNum, mesNum - 1, 1).toISOString().split('T')[0];
                        
                        // Último dia do mês
                        const ultimoDia = new Date(anoNum, mesNum, 0).getDate();
                        const dataFim = new Date(anoNum, mesNum - 1, ultimoDia).toISOString().split('T')[0];

                        const data = {
                            valor_meta: this.formData.valor_meta,
                            data_inicio: dataInicio,
                            data_fim: dataFim,
                            status: this.formData.status,
                        };

                        try {
                            const method = this.isEdit ? 'PUT' : 'POST';
                            const url = this.isEdit ? `/metas/${this.metaId}` : '/metas';

                            const response = await fetch(url, {
                                method: method,
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify(data)
                            });

                            if (response.ok) {
                                this.mensagem = this.isEdit ? 'Meta atualizada com sucesso!' : 'Meta criada com sucesso!';
                                this.sucesso = true;
                                
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1200);
                            } else {
                                const errorData = await response.json();
                                this.mensagem = errorData.message || 'Ocorreu um erro. Tente novamente.';
                                this.sucesso = false;
                            }
                        } catch (err) {
                            console.error('Erro:', err);
                            this.mensagem = 'Erro ao processar a requisição. Tente novamente.';
                            this.sucesso = false;
                        } finally {
                            this.isSubmitting = false;
                        }
                    }
                }
            }
        </script>
    </div>
</x-ui.modal>


@props(['clientes'])

<div x-data="{
    form: {
        cliente_id: ''
    },
    errors: {},
    validar() {
        this.errors = {};
        if (!this.form.cliente_id || this.form.cliente_id.trim() === '') {
            this.errors.cliente_id = 'Cliente é obrigatório';
        }
        return Object.keys(this.errors).length === 0;
    },
    submit() {
        if (this.validar()) {
            this.$el.querySelector('form').submit();
        }
    }
}">
    <form action="{{ route('clientes.store') }}" method="POST" class="space-y-4">
        @csrf
        <x-common.component-card title="Preencha os campos">
            <!-- Selecionar Cliente -->
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Cliente *
                </label>
                <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent">
                    <select name="cliente_id" x-model="form.cliente_id" @change="isOptionSelected = true"
                        :class="errors.cliente_id ? 'border-red-500 ring-red-500/10' : ''"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                        <option value="">Selecione um cliente</option>
                        @forelse($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                        @empty
                            <option value="" disabled>Nenhum cliente disponível</option>
                        @endforelse
                    </select>
                    <span
                        class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                        <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </div>
                <span x-show="errors.cliente_id" class="text-red-500 text-sm mt-1" x-text="errors.cliente_id"></span>
            </div>

            <!-- Numero do Processo -->
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Numero do Processo
                </label>
                <input name="numero_proceso" type="text" placeholder="65455545787" x-model="form.nome"
                    @blur="validar()" :class="errors.nome ? 'border-red-500 ring-red-500/10' : ''"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                <span x-show="errors.nome" class="text-red-500 text-sm mt-1" x-text="errors.nome"></span>
            </div>

            <!-- Esfera -->
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Esfera
                </label>
                <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent">
                    <select
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                        :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                        @change="isOptionSelected = true">
                        <option value="judicial" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                            Judicial
                        </option>
                        <option value="extrajudicial" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                            Extrajudicial
                        </option>
                    </select>
                    <span
                        class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                        <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </div>
            </div>

            <!-- Tipo do Processo -->
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Tipo do Processo *
                </label>
                <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent">
                    <select name="tipo_processo" x-model="form.tipo_processo" @change="isOptionSelected = true"
                        :class="errors.tipo_processo ? 'border-red-500 ring-red-500/10' : ''"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                        <option value="">Selecione um Tipo</option>
                        @forelse($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                        @empty
                            <option value="" disabled>Nenhum cliente disponível</option>
                        @endforelse
                    </select>
                    <span
                        class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                        <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </div>
                <span x-show="errors.cliente_id" class="text-red-500 text-sm mt-1" x-text="errors.cliente_id"></span>
            </div>

            <!-- Subtipo Processo -->
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Subtipo do Processo
                </label>
                <input name="numero_proceso" type="text" placeholder="Digite" x-model="form.nome" @blur="validar()"
                    :class="errors.nome ? 'border-red-500 ring-red-500/10' : ''"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                <span x-show="errors.nome" class="text-red-500 text-sm mt-1" x-text="errors.nome"></span>
            </div>

            <hr>

            <!-- Valor Total -->
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Valor Total
                </label>
                <input name="valor_total" type="text" placeholder="65455545787"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                <span x-show="errors.nome" class="text-red-500 text-sm mt-1" x-text="errors.nome"></span>
            </div>

            <x-ui.button type="button" @click="submit()">Adicionar Processo</x-ui.button>
        </x-common.component-card>
    </form>
</div>

@props(['tipodespesa'])

<form action="{{ route('tipos-despesas.update' , ['id' => $tipodespesa->id]) }}" method="POST" class="space-y-4">
    @csrf
    <x-common.component-card title="Preencha os dados do tipo de despesa">
    <!-- Nome do Tipo de Despesa -->
    <div>
        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
            Nome do Tipo de Despesa *
        </label>
        <input name="nome" type="text" placeholder="Fulano da Silva" value="{{ $tipodespesa->nome }}"
            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
    </div>

    <!-- Descrição -->
    <div>
        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
            Descrição *
        </label>
        <input name="descricao" type="text" placeholder="Descrição do tipo de despesa" value="{{ $tipodespesa->descricao }}"
            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
    </div>
    <x-ui.button type="submit">Editar Tipo de Despesa</x-ui.button>
</x-common.component-card>
</form>

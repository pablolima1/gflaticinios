<div class="p-6 dark:bg-transparent lg:p-10">
    <h2 class="mb-6 text-lg font-bold text-gray-800 dark:text-white">Nova Venda</h2>
    <form id="vendaForm" class="grid grid-cols-1 gap-4">
        <div class="col-span-1">
            <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Cliente</label>
            <input type="text" name="cliente" placeholder="Digite o cliente"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 transition-all" required />
        </div>
        <div class="col-span-1">
            <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Produto</label>
            <input type="text" name="produto" placeholder="Digite o produto"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 transition-all" required />
        </div>
        <div class="col-span-1">
            <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Quantidade</label>
            <input type="number" name="quantidade" min="1" placeholder="Quantidade"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 transition-all" required />
        </div>
        <div class="col-span-1">
            <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Valor</label>
            <input type="number" name="valor" min="0" step="0.01" placeholder="Valor"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 transition-all" required />
        </div>
        <div class="col-span-1">
            <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Data</label>
            <input type="date" name="data"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 transition-all" required />
        </div>
        <div class="flex justify-end mt-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Salvar</button>
        </div>
    </form>
</div>

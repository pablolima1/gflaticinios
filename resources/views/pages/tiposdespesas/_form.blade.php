@props(['action', 'method' => 'POST', 'buttonText' => 'Salvar', 'tipo' => null])

<form action="{{ $action }}" method="POST" class="space-y-6">
    @csrf
    @if(strtoupper($method) !== 'POST')
        @method($method)
    @endif

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome *</label>
            <input type="text" name="nome" value="{{ old('nome', $tipo->nome ?? '') }}" required class="mt-2 h-12 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-900 shadow-theme-xs focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
        </div>

        <div class="sm:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descrição</label>
            <textarea name="descricao" rows="4" class="mt-2 w-full rounded-xl border border-gray-300 bg-transparent px-4 py-3 text-sm text-gray-900 shadow-theme-xs focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">{{ old('descricao', $tipo->descricao ?? '') }}</textarea>
        </div>
    </div>

    <div class="flex flex-col gap-3 pt-4 sm:flex-row sm:justify-end">
        <a href="{{ route('tipos-despesas.index') }}" class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-600 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-white/5">Cancelar</a>
        <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-4 py-3 text-sm font-medium text-white transition hover:bg-brand-600">{{ $buttonText }}</button>
    </div>
</form>

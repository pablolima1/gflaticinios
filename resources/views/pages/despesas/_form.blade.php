@props(['action', 'method' => 'POST', 'buttonText' => 'Salvar', 'despesa' => null, 'tiposdespesas' => []])

<form action="{{ $action }}" method="POST" class="space-y-6">
    @csrf
    @if(strtoupper($method) !== 'POST')
        @method($method)
    @endif

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de Despesa *</label>
            <select name="tipo_despesa_id" required class="mt-2 h-12 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-900 shadow-theme-xs focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                <option value="" disabled {{ old('tipo_despesa_id', $despesa->tipo_despesa_id ?? '') == '' ? 'selected' : '' }}>Selecione o tipo</option>
                @foreach($tiposdespesas as $tipo)
                    <option value="{{ $tipo->id }}" {{ (string)old('tipo_despesa_id', $despesa->tipo_despesa_id ?? '') === (string)$tipo->id ? 'selected' : '' }}>{{ $tipo->nome }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descrição *</label>
            <input
                type="text"
                name="descricao"
                value="{{ old('descricao', $despesa->descricao ?? '') }}"
                required
                class="mt-2 h-12 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-900 shadow-theme-xs focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
            />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Valor *</label>
            <input
                type="number"
                name="valor"
                step="0.01"
                min="0.01"
                value="{{ old('valor', $despesa->valor ?? '') }}"
                required
                class="mt-2 h-12 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-900 shadow-theme-xs focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
            />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data da Despesa *</label>
            <input
                type="date"
                name="data_despesa"
                value=""
                required
                class="mt-2 h-12 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-900 shadow-theme-xs focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
            />
        </div>

        <div class="sm:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Observações</label>
            <textarea
                name="observacoes"
                rows="4"
                class="mt-2 w-full rounded-xl border border-gray-300 bg-transparent px-4 py-3 text-sm text-gray-900 shadow-theme-xs focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
            >{{ old('observacoes', $despesa->observacoes ?? '') }}</textarea>
        </div>
    </div>

    <div class="flex flex-col gap-3 pt-4 sm:flex-row sm:justify-end">
        <a href="{{ route('despesas.index') }}" class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-600 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-white/5">
            Cancelar
        </a>
        <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-4 py-3 text-sm font-medium text-white transition hover:bg-brand-600">
            {{ $buttonText }}
        </button>
    </div>
</form>

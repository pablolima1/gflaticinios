@props(['metas'])

<div x-data="metaTableHandler()">
    <div class="rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">
        <!-- Header -->
        <div class="flex flex-col gap-2 px-5 mb-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Lista de Metas</h3>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-hidden">
            <div class="max-w-full px-5 overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-gray-200 border-y dark:border-gray-700">
                            <th scope="col"
                                class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">
                                Período</th>
                            <th scope="col"
                                class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">
                                Valor da Meta</th>
                            <th scope="col"
                                class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">
                                Valor Atingido</th>
                            <th scope="col"
                                class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">
                                Progresso</th>
                            <th scope="col"
                                class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">
                                Status</th>
                            <th scope="col" class="relative px-4 py-3 capitalize">
                                <span class="sr-only">Ações</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($metas as $meta)
                        <tr>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ \Carbon\Carbon::createFromDate($meta->data_inicio->year, $meta->data_inicio->month, 1)->format('M/Y') }}
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    R$ {{ number_format($meta->valor_meta, 2, ',', '.') }}
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500 dark:text-gray-400" x-data="{ progresso: {{ $meta->progresso() }} }">
                                    R$ <span x-text="progresso.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2})"></span>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div x-data="{ 
                                    progresso: {{ $meta->progresso() }},
                                    percentual: {{ ($meta->valor_meta > 0 ? ($meta->progresso() / $meta->valor_meta) * 100 : 0) }}
                                }">
                                    <div class="flex items-center gap-2">
                                        <div class="w-24 h-2 bg-gray-200 rounded-full dark:bg-gray-700 overflow-hidden">
                                            <div class="h-full bg-green-500 rounded-full transition-all"
                                                :style="'width: ' + Math.min(percentual, 100) + '%'"></div>
                                        </div>
                                        <span class="text-sm font-medium text-gray-600 dark:text-gray-300 w-12"
                                            x-text="percentual.toFixed(1) + '%'"></span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span :class="{
                                    'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400': '{{ $meta->status }}' === 'ativa',
                                    'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400': '{{ $meta->status }}' === 'inativa'
                                }"
                                    class="px-3 py-1 text-xs font-semibold rounded-full">
                                    {{ ucfirst($meta->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-sm font-medium text-right whitespace-nowrap">
                                <div class="flex justify-center relative">
                                    <x-common.table-dropdown>
                                        <x-slot name="button">
                                            <button type="button" id="options-menu" aria-haspopup="true"
                                                aria-expanded="true" class="text-gray-500 dark:text-gray-400">
                                                <svg class="fill-current" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.99902 10.245C6.96552 10.245 7.74902 11.0285 7.74902 11.995V12.005C7.74902 12.9715 6.96552 13.755 5.99902 13.755C5.03253 13.755 4.24902 12.9715 4.24902 12.005V11.995C4.24902 11.0285 5.03253 10.245 5.99902 10.245ZM17.999 10.245C18.9655 10.245 19.749 11.0285 19.749 11.995V12.005C19.749 12.9715 18.9655 13.755 17.999 13.755C17.0325 13.755 16.249 12.9715 16.249 12.005V11.995C16.249 11.0285 17.0325 10.245 17.999 10.245ZM13.749 11.995C13.749 11.0285 12.9655 10.245 11.999 10.245C11.0325 10.245 10.249 11.0285 10.249 11.995V12.005C10.249 12.9715 11.0325 13.755 11.999 13.755C12.9655 13.755 13.749 12.9715 13.749 12.005V11.995Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </button>
                                        </x-slot>

                                        <x-slot name="content">
                                            <button @click="openMetaEditModal({{ $meta->id }})" 
                                                class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300" 
                                                type="button" role="menuitem">
                                                Editar
                                            </button>
                                            <button @click="deleteMetaConfirm({{ $meta->id }})" 
                                                class="flex w-full px-3 py-2 font-medium text-left text-red-500 rounded-lg text-theme-xs hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/10" 
                                                type="button" role="menuitem">
                                                Deletar
                                            </button>
                                        </x-slot>
                                    </x-common.table-dropdown>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Nenhuma meta cadastrada ainda.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function metaTableHandler() {
            return {
                async openMetaEditModal(metaId) {
                    try {
                        const response = await fetch(`/metas/${metaId}`);
                        const meta = await response.json();
                        
                        // Store the meta in window for access in modal
                        window.editingMeta = meta;
                        
                        // Dispatch events: primeiro abre o modal, depois enche com dados
                        window.dispatchEvent(new CustomEvent('open-meta-modal'));
                        setTimeout(() => {
                            window.dispatchEvent(new CustomEvent('open-meta-edit-modal-internal', { detail: meta }));
                        }, 100);
                    } catch (err) {
                        console.error('Erro ao buscar meta:', err);
                        alert('Erro ao carregar os dados da meta.');
                    }
                },

                async deleteMetaConfirm(metaId) {
                    if (confirm('Tem certeza que deseja deletar esta meta?')) {
                        try {
                            const response = await fetch(`/metas/${metaId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            });

                            if (response.ok) {
                                alert('Meta deletada com sucesso!');
                                window.location.reload();
                            } else {
                                alert('Erro ao deletar a meta.');
                            }
                        } catch (err) {
                            console.error('Erro ao deletar meta:', err);
                            alert('Erro ao deletar a meta.');
                        }
                    }
                }
            }
        }
    </script>
</div>

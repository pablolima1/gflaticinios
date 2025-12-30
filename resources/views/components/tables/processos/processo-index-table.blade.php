@props(['processos'])

<div x-data="{

    processo: {
        id: null,
        numero_processo: '',
        cliente_nome: '',
        esfera: '',
        tipo_processo_nome: '',
        status: '',
        created_at: '',
        cliente: {
            nome: ''
        },
        tipo_processo: {
            nome: ''
        }
    },

    pagamento: {
        id: null,
        valor_total: '',
        valor_entrada: '',
        valor_parcelado: '',
        quantidade_parcelas: '',
        parcelas: []
    },
    
    async getDetalhesProcesso(id) {
        try {
            const response = await fetch(`/processos/${id}/detalhes`);
            const data = await response.json();

            this.processo.numero_processo = data.processo.numero_processo;
            this.processo.cliente.nome = data.processo.cliente.nome;
            this.processo.esfera = data.processo.esfera;
            this.processo.tipo_processo.nome = data.processo.tipo_processo.nome;
            this.processo.subtipo_processo = data.processo.subtipo_processo;
            this.processo.status = data.processo.status;
            this.processo.created_at = data.processo.created_at;

            this.pagamento.valor_total = data.pagamento[0].valor_total;
            this.pagamento.valor_entrada = data.pagamento[0].valor_entrada;
            this.pagamento.valor_parcelado = data.pagamento[0].valor_parcelado;
            this.pagamento.quantidade_parcelas = data.pagamento[0].quantidade_parcelas;
            this.pagamento.data_pagamento_entrada = data.pagamento[0].data_pagamento_entrada;
            
            this.pagamento.parcelas = data.pagamento[0].parcelas;

        } catch (e) {
            console.error('Erro ao buscar dados do processo', e);
        }
    }
 }" class="space-y-6">
    <div class="rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">
        <!-- Header -->
        <div class="flex flex-col gap-2 px-5 mb-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Lista dos Processos</h3>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <form>
                    <div class="relative">
                        <button type="button" class="absolute -translate-y-1/2 left-4 top-1/2">
                            <svg class="fill-gray-500 dark:fill-gray-400" width="20" height="20" viewBox="0 0 20 20"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M3.04199 9.37381C3.04199 5.87712 5.87735 3.04218 9.37533 3.04218C12.8733 3.04218 15.7087 5.87712 15.7087 9.37381C15.7087 12.8705 12.8733 15.7055 9.37533 15.7055C5.87735 15.7055 3.04199 12.8705 3.04199 9.37381ZM9.37533 1.54218C5.04926 1.54218 1.54199 5.04835 1.54199 9.37381C1.54199 13.6993 5.04926 17.2055 9.37533 17.2055C11.2676 17.2055 13.0032 16.5346 14.3572 15.4178L17.1773 18.2381C17.4702 18.531 17.945 18.5311 18.2379 18.2382C18.5308 17.9453 18.5309 17.4704 18.238 17.1775L15.4182 14.3575C16.5367 13.0035 17.2087 11.2671 17.2087 9.37381C17.2087 5.04835 13.7014 1.54218 9.37533 1.54218Z"
                                    fill="" />
                            </svg>
                        </button>
                        <input type="text" placeholder="Search..."
                            class="h-[42px] w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-[42px] pr-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-blue-800 xl:w-[300px]" />
                    </div>
                </form>
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
                                Numero do Processo</th>
                            <th scope="col"
                                class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">
                                Cliente</th>
                            <th scope="col"
                                class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">
                                Esfera</th>
                            <th scope="col"
                                class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">
                                Tipo do Processo</th>
                            <th scope="col"
                                class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">
                                Status Pagamento</th>
                            <th scope="col"
                                class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">
                                Criado Em</th>
                            <th scope="col" class="relative px-4 py-3 capitalize">
                                <span class="sr-only">Ações</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($processos as $processo)
                        <tr>
                            <td class="py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $processo->numero_processo }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $processo->cliente->nome }}
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ ucfirst($processo->esfera) }}
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $processo->tipoProcesso->nome }}
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                @if($processo->status == 'aberto')
                                <span class="px-2 py-1 text-sm font-medium text-yellow-800 bg-yellow-100 rounded-full dark:bg-yellow-900 dark:text-yellow-300">
                                    Criado
                                </span>
                                @elseif($processo->status == 'andamento')
                                <span class="px-2 py-1 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">
                                    Em Andamento
                                </span>
                                @else
                                <span class="px-2 py-1 text-sm font-medium text-green-800 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-300">
                                    Finalizado
                                </span>
                                @endif
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $processo->created_at->format('d/m/Y - H:i') }}
                                </div>
                            </td>
                            <td class="px-4 py-4 text-sm font-medium text-right whitespace-nowrap">
                                <div class="flex justify-center relative">
                                    <x-common.table-dropdown>
                                        <x-slot name="button">
                                            <button type="button" id="options-menu" aria-haspopup="true"
                                                aria-expanded="true" class="text-gray-500 dark:text-gray-400'">
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
                                            <a href="#"
                                                @click="$dispatch('open-profile-address-modal')"
                                                x-on:click="
                                                    getDetalhesProcesso({{ $processo->id }});
                                                "
                                                class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                                                role="menuitem">
                                                Exibir Detalhes
                                            </a>
                                            <a href="#"
                                                class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                                                role="menuitem">
                                                Editar
                                            </a>
                                        </x-slot>
                                    </x-common.table-dropdown>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                Nenhum processo encontrado.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination Laravel -->
        <div class="mt-4">
            {!! $processos->links() !!}
        </div>
    </div>

    <x-ui.modal @open-profile-address-modal.window="open = true" :isOpen="false" class="max-w-[700px] max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-6">
                        Detalhes do Processo
                    </h4>

                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3 lg:gap-7 2xl:gap-x-32">
                        <div>
                            <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Número do Processo</p>
                            <p class="text-sm font-medium text-gray-800 dark:text-white/90" x-text="processo.numero_processo"></p>
                        </div>

                        <div>
                            <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Cliente</p>
                            <p class="text-sm font-medium text-gray-800 dark:text-white/90" x-text="processo.cliente.nome"></p>
                        </div>

                        <div>
                            <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Tipo do Processo</p>
                            <p class="text-sm font-medium text-gray-800 dark:text-white/90" x-text="processo.tipo_processo.nome"></p>
                        </div>

                        <div>
                            <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Esfera</p>
                            <p class="text-sm font-medium text-gray-800 dark:text-white/90" x-text="processo.esfera"></p>
                        </div>

                        <div>
                            <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Subtipo do Processo</p>
                            <p class="text-sm font-medium text-gray-800 dark:text-white/90" x-text="processo.subtipo_processo"></p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-6">
                            Pagamentos
                        </h4>

                        <div class="grid grid-cols-1 gap-4 lg:grid-cols-3 lg:gap-7 2xl:gap-x-32">
                            <div>
                                <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Valor Total</p>
                                <p class="text-sm font-medium text-gray-800 dark:text-white/90" x-text="'R$ ' + pagamento.valor_total"></p>
                            </div>

                            <div>
                                <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Valor da Entrada</p>
                                <p class="text-sm font-medium text-gray-800 dark:text-white/90" x-text="'R$ ' + pagamento.valor_entrada"></p>
                            </div>

                            <div>
                                <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Quantidade de Parcelas</p>
                                <p class="text-sm font-medium text-gray-800 dark:text-white/90" x-text="pagamento.quantidade_parcelas"></p>
                            </div>

                            <div>
                                <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Data de Entrada</p>
                                <p class="text-sm font-medium text-gray-800 dark:text-white/90" x-text="pagamento.data_pagamento_entrada"></p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-6">
                            Parcelas
                        </h4>
                        <template x-for="(parcela, index) in pagamento.parcelas" :key="index">
                            <div class="mb-4 p-4 border border-gray-200 rounded-lg dark:border-gray-700">
                                <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                    Parcela <span x-text="index + 1"></span>
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Valor: R$ <span x-text="parcela.valor_parcela"></span>
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Valor Restante: R$ <span x-text="parcela.valor_restante"></span>
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Data de Vencimento: <span x-text="parcela.vencimento"></span>
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Status: <span x-text="parcela.status"></span>
                                </p>
                            </div>
                            
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </x-ui.modal>

</div>
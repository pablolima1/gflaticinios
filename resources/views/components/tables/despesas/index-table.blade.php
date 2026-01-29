@props(['despesas', 'tiposdespesas'])

<div x-data="despesasAlpineJs()" x-init="">
    <div class="rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">
        <!-- Header -->
        <div class="flex flex-col gap-2 px-5 mb-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Despesas</h3>
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
                                Tipo Despesa</th>
                            <th scope="col"
                                class="px-4 py-3 font-normal text-gray-500 text-end text-theme-sm dark:text-gray-400">
                                Valor da Despesa</th>
                            <th scope="col"
                                class="px-4 py-3 font-normal text-gray-500 text-end text-theme-sm dark:text-gray-400">
                                Status da Despesa</th>
                            <th scope="col"
                                class="px-4 py-3 font-normal text-gray-500 text-end text-theme-sm dark:text-gray-400">
                                Data da Criação</th>
                            <th scope="col" class="relative px-4 py-3 capitalize">
                                <span class="sr-only">Ações</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($despesas as $despesa)

                        <tr>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $despesa->tipo->nome }}
                                </div>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-800 text-end dark:text-white/90 whitespace-nowrap">
                                R$ {{ number_format($despesa->valor, 2, ',', '.') }}
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-800 text-end dark:text-white/90 whitespace-nowrap">
                                @if($despesa->status == 'paga')
                                <span class="px-2 py-1 text-sm font-medium text-green-800 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-300">
                                    Pago
                                </span>
                                @else
                                <span class="px-2 py-1 text-sm font-medium text-red-800 bg-red-100 rounded-full dark:bg-red-900 dark:text-red-300">
                                    Pendente
                                </span>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-800 text-end dark:text-white/90 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($despesa->created_at)->format('d/m/Y') }}
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
                                                @click="$dispatch('open-registrar-pagamento-modal')"
                                                x-on:click="
                                                    getDetalhesPagamento({{ $despesa->id }});
                                                "
                                                class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                                                role="menuitem">
                                                Editar Despesa
                                            </a>
                                            <a href="#"
                                                x-on:click="
                                                    despesa.id = {{ $despesa->id }}; 
                                                    $dispatch('open-delete-despesa-modal');
                                                "
                                                class="flex w-full px-3 py-2 font-medium text-left text-red-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-red-700 dark:hover:bg-white/5 dark:hover:text-red-400"
                                                role="menuitem">
                                                Excluir Despesa
                                            </a>
                                        </x-slot>
                                    </x-common.table-dropdown>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                Nenhuma Entrada Encontrada para o Mês selecionado.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <x-ui.button @click="$dispatch('open-registrar-despesa-modal')">Add Nova Despesa</x-ui.button>
    </div>

    <x-ui.modal @open-registrar-despesa-modal.window="open = true" :isOpen="false" class="max-w-[700px] max-h-[90vh] overflow-y-auto">
        <div class="relative w-full rounded-3xl bg-white p-6 dark:bg-gray-900 lg:p-10">
            <!-- close btn -->
            <button @click="open = false" class="group absolute right-3 top-3 z-999 flex h-9.5 w-9.5 items-center justify-center rounded-full bg-gray-200 text-gray-500 transition-colors hover:bg-gray-300 hover:text-gray-500 dark:bg-gray-800 dark:hover:bg-gray-700 sm:right-6 sm:top-6 sm:h-11 sm:w-11">
                <svg class="transition-colors fill-current group-hover:text-gray-600 dark:group-hover:text-gray-200" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.04289 16.5413C5.65237 16.9318 5.65237 17.565 6.04289 17.9555C6.43342 18.346 7.06658 18.346 7.45711 17.9555L11.9987 13.4139L16.5408 17.956C16.9313 18.3466 17.5645 18.3466 17.955 17.956C18.3455 17.5655 18.3455 16.9323 17.955 16.5418L13.4129 11.9997L17.955 7.4576C18.3455 7.06707 18.3455 6.43391 17.955 6.04338C17.5645 5.65286 16.9313 5.65286 16.5408 6.04338L11.9987 10.5855L7.45711 6.0439C7.06658 5.65338 6.43342 5.65338 6.04289 6.0439C5.65237 6.43442 5.65237 7.06759 6.04289 7.45811L10.5845 11.9997L6.04289 16.5413Z" fill=""></path>
                </svg>
            </button>

            <form @submit.prevent="submitForm" class="mt-4">
                @csrf

                <h4 class="mb-6 text-lg font-medium text-gray-800 dark:text-white/90">
                    Registrar Despesa
                </h4>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Tipo da Despesa *
                    </label>
                    <select name="tipo_despesa_id" x-model="form.tipo_despesa_id"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                        <option value="" disabled selected>Selecione o Tipo da Despesa</option>
                        @foreach ($tiposdespesas as $tipodespesa)
                        <option value="{{ $tipodespesa->id }}">{{ $tipodespesa->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-2 mt-4">
                    <div class="col-span-1">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Valor da Despesa
                        </label>
                        <input type="text" x-model="formData.valor" x-on:input="form.valor = $maskMoney($event.target)" placeholder="0,00"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                    </div>

                    <div class="col-span-1">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Data do Pagamento
                            </label>

                            <x-form.date-picker-custom x-ref="datePick" id="date_pick" name="data_despesa" placeholder="Date Picker"
                                defaultDate="{{ now()->format('d-m-Y') }}" />
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end w-full gap-3 mt-6">
                    <button @click="open = false" type="button" class="flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 shadow-theme-xs transition-colors hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200 sm:w-auto">
                        Fechar
                    </button>
                    <button type="submit" class="flex justify-center w-full px-4 py-3 text-sm font-medium text-white rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600 sm:w-auto">
                        Registrar Despesa
                    </button>
                </div>
            </form>
        </div>
    </x-ui.modal>

    <x-ui.modal @open-delete-despesa-modal.window="open = true" class="max-w-[700px] max-h-[90vh] overflow-y-auto">
        <div>
            <form method="POST" class="p-6 mt-4" :action="`/despesa/${despesa.id}/delete`">
                @csrf
                @method('POST')
                <p class="mb-6 text-sm text-gray-600 dark:text-gray-400">
                    Tem certeza que deseja excluir esta despesa? Esta ação não pode ser desfeita.
                </p>
                <div class="flex justify-end mt-4">
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">
                        Excluir
                    </button>
                </div>
            </form>
        </div>
    </x-ui.modal>

    <script>
        function despesasAlpineJs() {
            return {
                open: false,

                despesa: {
                    id: null,
                },

                form: {
                    tipo_despesa_id: '',
                    valor: '',
                    data_despesa: '',
                },
                formData: {
                    _token: '{{ csrf_token() }}',
                    tipo_despesa_id: '',
                    valor: '',
                    data_despesa: '',
                },

                async submitForm() {
                    try {
                        let dataToSubmit = JSON.parse(JSON.stringify(this.formData));

                        // Sincronizar o tipo_despesa_id do form
                        dataToSubmit.tipo_despesa_id = this.form.tipo_despesa_id;

                        // Limpar a formatação do valor_pagamento (de "1.600,00" para "1600.00")
                        if (dataToSubmit.valor) {
                            let valor = dataToSubmit.valor.toString();
                            // Remove tudo que não é dígito
                            let apenasNumeros = valor.replace(/\D/g, '');
                            // Converte para decimal (centavos)
                            dataToSubmit.valor = parseFloat(apenasNumeros) / 100;
                        }

                        // Lógica do Date Picker
                        let dateInput = this.$refs.datePick?.querySelector('[name="data_despesa"]') ||
                            this.$refs.datePick?.querySelector('input') ||
                            document.querySelector('[name="data_despesa"]');

                        if (dateInput?.value) {
                            dataToSubmit.data_despesa = dateInput.value;
                        }

                        console.log('Dados a enviar:', dataToSubmit);

                        const response = await fetch(`/despesa`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': dataToSubmit._token
                            },
                            body: JSON.stringify(dataToSubmit)
                        });

                        if (!response.ok) throw new Error('Erro ao registrar despesa');

                        const responseText = await response.text();
                        if (responseText) {
                            const data = JSON.parse(responseText);
                            console.log('Sucesso:', data);
                        }

                        this.open = false;
                        window.location.reload();

                    } catch (e) {
                        console.error('Erro ao registrar despesa', e);
                    }
                }
            }
        }
    </script>
</div>
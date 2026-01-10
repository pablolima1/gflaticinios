@props(['clientes', 'tipos_processos'])

<div x-data="pagamentoForm()">
    <form action="{{ route('processos.store') }}" method="POST" class="space-y-4">
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
                <input name="numero_processo" type="text" placeholder="123456789"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
            </div>

            <!-- Esfera -->
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Esfera *
                </label>
                <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent">
                    <select
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                        :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                        name="esfera"
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
                    <select name="tipo_processo_id" x-model="form.tipo_processo_id"
                        @change="isOptionSelected = true"
                        :class="errors.tipo_processo_id ? 'border-red-500 ring-red-500/10' : ''"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                        <option value="">Selecione um Tipo</option>
                        @forelse($tipos_processos as $tipo)
                        <option value="{{ $tipo->id }}">{{ $tipo->nome }}</option>
                        @empty
                        <option value="" disabled>Nenhum tipo disponível</option>
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
                <span x-show="errors.tipo_processo_id" class="text-red-500 text-sm mt-1" x-text="errors.tipo_processo_id"></span>
            </div>

            <!-- Subtipo Processo -->
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Subtipo do Processo
                </label>
                <input name="subtipo_processo" type="text" placeholder="Digite"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                <span x-show="errors.subtipo_processo" class="text-red-500 text-sm mt-1" x-text="errors.subtipo_processo"></span>
            </div>

            <!-- Separator PAGAMENTO -->
            <hr class="my-4 border-gray-200 dark:border-gray-700" />

            <!-- Título Pagamento -->
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                Pagamento
            </h3>

            <!-- Tipos de Pagamento -->
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Tipo de Pagamento
                </label>
                <div class="flex gap-6">
                    <!-- À vista -->
                    <label
                        class="flex items-center cursor-pointer text-sm font-medium text-gray-700 dark:text-gray-400">
                        <input type="radio" name="tipo_pagamento" value="avista" x-model="form.tipo_pagamento"
                            class="sr-only" />
                        <div :class="form.tipo_pagamento === 'avista' ? 'border-brand-500 bg-brand-500' :
                            'bg-transparent border-gray-300 dark:border-gray-700'"
                            class="mr-3 flex h-5 w-5 items-center justify-center rounded-full border-[1.25px]">
                            <span class="h-2 w-2 rounded-full"
                                :class="form.tipo_pagamento === 'avista' ? 'bg-white' : 'bg-white dark:bg-[#171f2e]'"></span>
                        </div>
                        À vista
                    </label>
                    <!-- À Prazo -->
                    <label
                        class="flex items-center cursor-pointer text-sm font-medium text-gray-700 dark:text-gray-400">
                        <input type="radio" name="tipo_pagamento" value="aprazo" x-model="form.tipo_pagamento"
                            class="sr-only" />
                        <div :class="form.tipo_pagamento === 'aprazo' ? 'border-brand-500 bg-brand-500' :
                            'bg-transparent border-gray-300 dark:border-gray-700'"
                            class="mr-3 flex h-5 w-5 items-center justify-center rounded-full border-[1.25px]">
                            <span class="h-2 w-2 rounded-full"
                                :class="form.tipo_pagamento === 'aprazo' ? 'bg-white' : 'bg-white dark:bg-[#171f2e]'"></span>
                        </div>
                        À Prazo
                    </label>
                </div>
            </div>

            <!-- Valor Total (a vista) -->
            <div x-show="form.tipo_pagamento === 'avista'">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Valor Total <span x-show="form.tipo_pagamento === 'aprazo'">(Parcelado)</span>
                </label>
                <input type="text" name="valor_total" x-on:input="form.valor_total = $maskMoney($event.target)" placeholder="0,00"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                <span x-show="errors.nome" class="text-red-500 text-sm mt-1" x-text="errors.nome"></span>
            </div>

            <div x-data="{ switcherPagoNoAto: true }" x-show="form.tipo_pagamento === 'avista'">
                <div>
                    <label for="toggle2"
                        class="flex cursor-pointer items-center gap-3 text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                        <div class="relative">
                            <input type="hidden" name="switcherPagoNoAto" value="0">
                            <input type="checkbox" name="switcherPagoNoAto" id="toggle2" class="sr-only" value="1" x-model="switcherPagoNoAto" />
                            <div class="block h-6 w-11 rounded-full"
                                :class="switcherPagoNoAto ? 'bg-brand-500 dark:bg-brand-500' : 'bg-gray-200 dark:bg-white/10'">
                            </div>
                            <div :class="switcherPagoNoAto ? 'translate-x-full' : 'translate-x-0'"
                                class="shadow-theme-sm absolute top-0.5 left-0.5 h-5 w-5 rounded-full bg-white duration-300 ease-linear">
                            </div>
                        </div>

                        Pagamento Já Realizado ? (Pagamento realizado na data de criação do processo)
                    </label>
                </div>

                <!-- Data do Pagamento  (somente a vista)-->
                <div x-show="form.tipo_pagamento === 'avista' && !switcherPagoNoAto" class="mt-4">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Data do Pagamento
                    </label>

                    <x-form.date-picker-custom id="date_pick" name="date_pagamento" placeholder="Date Picker"
                        defaultDate="{{ now()->format('d-m-Y') }}" />
                </div>
            </div>

            <!-- Valor Parcelado (somente a prazo) -->
            <div x-show="form.tipo_pagamento === 'aprazo'">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Valor Parcelado
                </label>
                <input name="valor_parcelado" type="text" x-on:input="form.valor_parcelado = $maskMoney($event.target)" placeholder="0,00"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                <span x-show="errors.nome" class="text-red-500 text-sm mt-1" x-text="errors.nome"></span>
            </div>


            <div x-data="{ switcherToggle: false }" x-show="form.tipo_pagamento === 'aprazo'">
                <div>
                    <label for="toggle1"
                        class="flex cursor-pointer items-center gap-3 text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                        <div class="relative">
                            <input type="checkbox" name="switcherToggle" id="toggle1" class="sr-only" @change="switcherToggle = !switcherToggle" />
                            <div class="block h-6 w-11 rounded-full"
                                :class="switcherToggle ? 'bg-brand-500 dark:bg-brand-500' : 'bg-gray-200 dark:bg-white/10'">
                            </div>
                            <div :class="switcherToggle ? 'translate-x-full' : 'translate-x-0'"
                                class="shadow-theme-sm absolute top-0.5 left-0.5 h-5 w-5 rounded-full bg-white duration-300 ease-linear">
                            </div>
                        </div>

                        Inserir valor de entrada
                    </label>
                </div>

                <!-- Valor da Entrada (somente a prazo) -->
                <div class="mt-4" x-show="form.tipo_pagamento === 'aprazo' && switcherToggle">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Valor da Entrada
                    </label>
                    <input name="valor_entrada" type="text" x-on:input="form.valor_entrada = $maskMoney($event.target)" placeholder="0,00"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                    <span x-show="errors.nome" class="text-red-500 text-sm mt-1" x-text="errors.nome"></span>
                </div>

                <!-- Data da Entrada (somente a prazo) -->
                <div class="mt-4" x-show="form.tipo_pagamento === 'aprazo' && switcherToggle">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Data da Entrada
                    </label>

                    <x-form.date-picker-custom id="date_pick" name="date_entrada" placeholder="Date Picker"
                        defaultDate="{{ now()->format('d-m-Y') }}" />
                </div>

                <!-- Valor Total (somente a prazo) -->
                <div class="mt-4" x-show="form.tipo_pagamento === 'aprazo' && switcherToggle">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Valor Total (Parcelado + Entrada)
                    </label>
                    <input readonly type="text" name="valor_total_a_prazo" :value="calcularValorTotalAPrazo()" x-on:input="form.valor_total_a_prazo = $maskMoney($event.target)" placeholder="0,00"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                </div>
            </div>

            <!-- Vencimento 1° Parcela (somente a prazo) -->
            <div x-show="form.tipo_pagamento === 'aprazo'">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Vencimento 1° Parcela
                </label>

                <x-form.date-picker-custom id="date_pick" name="data_vencimento_1parcela" placeholder="Date Picker"
                    defaultDate="{{ now()->format('d-m-Y') }}" />
            </div>

            <!-- Quantidade das Parcelas (somente a prazo) -->
            <div x-show="form.tipo_pagamento === 'aprazo'">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Quantidade das Parcelas
                </label>
                <input x-model.number="form.quantidade_parcelas" type="number" name="quantidade_parcelas" placeholder="1" min="1" max="30"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                <span x-show="errors.nome" class="text-red-500 text-sm mt-1" x-text="errors.nome"></span>
            </div>

            <!-- Quantidade das Parcelas -->
            {{-- <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Quantidade das Parcelas
                </label>
                <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent">
                    <select
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                        :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                        @change="isOptionSelected = true">
                        <option value="1" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                            1X
                        </option>
                        <option value="2" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                            2X
                        </option>
                        <option value="3" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                            3X
                        </option>
                        <option value="4" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                            4X
                        </option>
                        <option value="5" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                            5X
                        </option>
                        <option value="6" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                            6X
                        </option>
                    </select>
                    <span
                        class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                        <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </div>
            </div> --}}

            <!-- Valor das Parcelas (somente a prazo)-->
            <div x-show="form.tipo_pagamento === 'aprazo'">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Valor das Parcelas
                </label>
                <input type="text" name="valor_parcela" :value="calcularValorParcela()"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                    readonly />
                <span x-show="errors.nome" class="text-red-500 text-sm mt-1" x-text="errors.nome"></span>
            </div>

            <x-ui.button type="submit" @click="submit()">Adicionar Processo</x-ui.button>
        </x-common.component-card>
    </form>
</div>

<script>
    function pagamentoForm() {
        return {
            valor_total: 0,
            quantidade_parcelas: 1,

            form: {
                cliente_id: '',
                tipo_processo_id: '',
                tipo_pagamento: 'avista',
                valor_total: 0,
                valor_entrada: 0,
                valor_parcelado: 0,
                quantidade_parcelas: 1,
                switcherToggle: false,
            },

            errors: {},

            calcularValorParcela() {
                if (!this.form.quantidade_parcelas || this.form.quantidade_parcelas === 0) {
                    return 'R$ 0.00';
                }
                const valor = this.form.valor_parcelado / this.form.quantidade_parcelas;
                return this.form.quantidade_parcelas + ' x de ' + 'R$ ' + valor.toFixed(2).replace('.', ',');
            },

            calcularValorTotalAPrazo() {
                return 'R$ ' + (this.form.valor_parcelado + this.form.valor_entrada).toFixed(2).replace('.', ',');
            }
        }
    }
</script>
@extends('layouts.app')

@section('content')
<div>
    <x-ui.button x-on:click="$dispatch('open-modal'); console.log('Abrindo modal de cadastro de cliente')" variant="primary" size="md">
        Adicionar Cliente
    </x-ui.button>
    <x-ui.modal x-on:open-modal.window="open = true" class="max-w-[700px] max-h-[90vh] overflow-y-auto">
        <div class="relative w-full rounded-3xl bg-white p-6 dark:bg-gray-900 lg:p-10">
            <!-- Formulário de cadastro de cliente aqui -->
            <h2 class="mb-6 text-lg font-bold text-gray-800 dark:text-white">Cadastro de Cliente</h2>
            <form id="clienteForm" class="grid grid-cols-1 gap-4" x-data="clienteFormHandler()" @submit.prevent="submitCliente">
                <template x-if="mensagem">
                    <div :class="{'bg-green-100 text-green-800': sucesso, 'bg-red-100 text-red-800': !sucesso}" class="rounded-lg px-4 py-2 mb-2 text-sm font-semibold">
                        <span x-text="mensagem"></span>
                    </div>
                </template>
                <div class="col-span-1">
                    <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Nome do Cliente</label>
                    <input type="text" name="nome" placeholder="Digite o nome"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 transition-all" />
                </div>
                <div class="col-span-1">
                    <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Telefone</label>
                    <input type="text" name="telefone" placeholder="Digite o telefone"
                        x-model="telefone"
                        x-on:input="telefone = $telefoneMask($event.target.value); $event.target.value = telefone"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 transition-all" />
                </div>
                <div class="col-span-1" x-data="{ telefone: '' }">
                    <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Data de Nascimento</label>
                    <x-form.date-picker-custom name="data_nascimento" label="" placeholder="Selecione a data" />
                </div>
                <div class="col-span-1">
                    <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Endereço</label>
                    <input type="text" name="endereco" placeholder="Digite o endereço"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 transition-all" />
                </div>
                <div class="flex justify-end mt-2">
                    <x-ui.button type="submit" variant="primary" size="sm">Salvar</x-ui.button>
                </div>
            </form>
            <script>
                function clienteFormHandler() {
                    return {
                        mensagem: '',
                        sucesso: false,
                        async submitCliente() {
                            const form = document.getElementById('clienteForm');
                            const formData = new FormData(form);
                            const data = Object.fromEntries(formData.entries());
                            // Para pegar a data do date-picker, ajuste conforme integração
                            // Exemplo: data.data_nascimento = ...
                            try {
                                const response = await fetch('/clientes', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                    },
                                    body: JSON.stringify(data)
                                });
                                if (response.ok) {
                                    this.mensagem = 'Cliente cadastrado com sucesso!';
                                    this.sucesso = true;
                                    form.reset();
                                    setTimeout(() => {
                                        this.mensagem = '';
                                        window.dispatchEvent(new CustomEvent('close-modal'));
                                        window.location.reload();
                                    }, 1200);
                                } else {
                                    this.mensagem = 'Ocorreu um erro ao cadastrar o cliente. Por favor, contate o administrador.';
                                    this.sucesso = false;
                                }
                            } catch (err) {
                                this.mensagem = 'Ocorreu um erro ao cadastrar o cliente. Por favor, contate o administrador.';
                                this.sucesso = false;
                            }
                        }
                    }
                }
            </script>
            </form>
        </div>
        </x-components.ui.modal>
</div>
<div class="container mx-auto py-8">
    <x-tables.clientes.cliente-table :clientes="$clientes" />
</div>
@endsection
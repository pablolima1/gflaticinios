@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <div class="mb-6">
            <x-ui.button x-on:click="$dispatch('open-modal-produto')" variant="primary" size="md">
                Cadastrar Produto
            </x-ui.button>
            <x-ui.modal x-on:open-modal-produto.window="open = true" class="max-w-[700px] max-h-[90vh] overflow-y-auto">
                <div class="relative w-full rounded-3xl bg-white p-6 dark:bg-gray-900 lg:p-10">
                    <h2 class="mb-6 text-lg font-bold text-gray-800 dark:text-white">Cadastro de Produto</h2>
                    <form id="produtoForm" class="grid grid-cols-1 gap-4" x-data="produtoFormHandler()" @submit.prevent="submitProduto">
                        <div class="col-span-1">
                            <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Nome do Produto</label>
                            <input type="text" name="nome" placeholder="Digite o nome"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full max-w-[350px] rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 transition-all" />
                        </div>
                        <div class="col-span-1">
                            <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Descrição</label>
                            <input type="text" name="descricao" placeholder="Digite a descrição"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full max-w-[350px] rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 transition-all" />
                        </div>
                        <div class="col-span-1">
                            <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Preço</label>
                            <input type="number" step="0.01" min="0" name="preco" placeholder="Digite o preço"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full max-w-[350px] rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 transition-all" />
                        </div>
                        <div class="col-span-1">
                            <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Unidade de Medida</label>
                            <input type="text" name="unidade_medida" placeholder="Ex: kg, litro, unidade"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full max-w-[350px] rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 transition-all" />
                        </div>
                        <div class="col-span-1 flex items-center">
                            <input name="ativo" type="checkbox" value="1" checked class="mr-2" />
                            <label class="text-xs font-semibold text-gray-700 dark:text-gray-300">Ativo</label>
                        </div>
                        <div class="flex justify-end mt-2">
                            <x-ui.button type="submit" variant="primary" size="sm">Salvar</x-ui.button>
                        </div>
                    </form>
                    <script>
                        function produtoFormHandler() {
                            return {
                                async submitProduto() {
                                    const form = document.getElementById('produtoForm');
                                    const formData = new FormData(form);
                                    const data = Object.fromEntries(formData.entries());
                                    data.ativo = formData.get('ativo') ? 1 : 0;
                                    try {
                                        const response = await fetch('/produtos', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-Requested-With': 'XMLHttpRequest',
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                            },
                                            body: JSON.stringify(data)
                                        });
                                        if (response.ok) {
                                            form.reset();
                                            window.dispatchEvent(new CustomEvent('close-modal-produto'));
                                            window.location.reload();
                                        } else {
                                            const error = await response.json();
                                            alert('Erro ao cadastrar: ' + (error.message || 'Erro desconhecido'));
                                        }
                                    } catch (err) {
                                        alert('Erro ao cadastrar: ' + err);
                                    }
                                }
                            }
                        }
                    </script>
                </div>
            </x-ui.modal>
        </div>
        <x-tables.produtos.produto-table :produtos="$produtos" />
    </div>
@endsection

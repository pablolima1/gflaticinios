@props(['produtos'])

<div x-data="produtoTableHandler()">
    <div class="rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">
        <!-- Header -->
        <div class="flex flex-col gap-2 px-5 mb-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Lista de Produtos</h3>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <form>
                    <div class="relative">
                        <button type="button" class="absolute -translate-y-1/2 left-4 top-1/2">
                            <svg class="fill-gray-500 dark:fill-gray-400" width="20" height="20"
                                viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M3.04199 9.37381C3.04199 5.87712 5.87735 3.04218 9.37533 3.04218C12.8733 3.04218 15.7087 5.87712 15.7087 9.37381C15.7087 12.8705 12.8733 15.7055 9.37533 15.7055C5.87735 15.7055 3.04199 12.8705 3.04199 9.37381ZM9.37533 1.54218C5.04926 1.54218 1.54199 5.04835 1.54199 9.37381C1.54199 13.6993 5.04926 17.2055 9.37533 17.2055C11.2676 17.2055 13.0032 16.5346 14.3572 15.4178L17.1773 18.2381C17.4702 18.531 17.945 18.5311 18.2379 18.2382C18.5308 17.9453 18.5309 17.4704 18.238 17.1775L15.4182 14.3575C16.5367 13.0035 17.2087 11.2671 17.2087 9.37381C17.2087 5.04835 13.7014 1.54218 9.37533 1.54218Z"
                                    fill="" />
                            </svg>
                        </button>
                        <input type="text" placeholder="Buscar..."
                            class="h-[42px] w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-[42px] pr-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-blue-800 xl:w-[300px]" />
                    </div>
                </form>
            </div>
                <!-- Modal de Cadastro de Produto -->
                <x-ui.modal x-show="openProdutoModal" @close-modal-produto.window="openProdutoModal = false" class="max-w-[700px] max-h-[90vh] overflow-y-auto" x-data="{ openProdutoModal: false }" @open-modal-produto.window="openProdutoModal = true">
                    <div class="relative w-full rounded-3xl bg-white p-6 dark:bg-gray-900 lg:p-10">
                        <h2 class="mb-6 text-lg font-bold text-gray-800 dark:text-white">Cadastro de Produto</h2>
                        <x-form.produtos.produto-form />
                        <div class="flex justify-end mt-2">
                            <x-ui.button type="button" variant="secondary" size="sm" x-on:click="openProdutoModal = false">Fechar</x-ui.button>
                        </div>
                    </div>
                </x-ui.modal>
        </div>

        <!-- Table -->
        <div class="overflow-hidden">
            <div class="max-w-full px-5 overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-gray-200 border-y dark:border-gray-700">
                            <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">Nome</th>
                            <th scope="col" class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">Preço</th>
                            <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">Descrição</th>
                            <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">Data de Criação</th>
                            <th scope="col" class="relative px-4 py-3 capitalize"><span class="sr-only">Ações</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($produtos as $produto)
                            <tr>
                                <td class="py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $produto->nome }}</div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">R$ {{ number_format($produto->preco, 2, ',', '.') }}</div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $produto->descricao }}</div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $produto->created_at }}</div>
                                </td>
                                <td class="px-4 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <div class="flex justify-center relative">
                                        <x-common.table-dropdown>
                                            <x-slot name="button">
                                                <button type="button" id="options-menu" aria-haspopup="true" aria-expanded="true" class="text-gray-500 dark:text-gray-400'">
                                                    <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.99902 10.245C6.96552 10.245 7.74902 11.0285 7.74902 11.995V12.005C7.74902 12.9715 6.96552 13.755 5.99902 13.755C5.03253 13.755 4.24902 12.9715 4.24902 12.005V11.995C4.24902 11.0285 5.03253 10.245 5.99902 10.245ZM17.999 10.245C18.9655 10.245 19.749 11.0285 19.749 11.995V12.005C19.749 12.9715 18.9655 13.755 17.999 13.755C17.0325 13.755 16.249 12.9715 16.249 12.005V11.995C16.249 11.0285 17.0325 10.245 17.999 10.245ZM13.749 11.995C13.749 11.0285 12.9655 10.245 11.999 10.245C11.0325 10.245 10.249 11.0285 10.249 11.995V12.005C10.249 12.9715 11.0325 13.755 11.999 13.755C12.9655 13.755 13.749 12.9715 13.749 12.005V11.995Z" fill="currentColor" />
                                                    </svg>
                                                </button>
                                            </x-slot>

                                            <x-slot name="content">
                                                <button @click="openProdutoEditModal({{ $produto->id }})" class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300" type="button">Editar</button>
                                                <button @click="openProdutoDeleteModal({{ $produto->id }}, '{{ $produto->nome }}')" class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300" type="button">Deletar</button>
                                            </x-slot>
                                        </x-common.table-dropdown>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginação Laravel -->
        <div class="mt-4">
            {!! $produtos->links() !!}
        </div>
    </div>

    <!-- Modal de Edição de Produto -->
    <x-ui.modal x-on:open-modal-editar-produto.window="open = true" class="max-w-[700px] max-h-[90vh] overflow-y-auto">
        @include('components.modals.produtos.modal-editar-produto')
    </x-ui.modal>

    <!-- Modal de Deleção de Produto -->
    <x-ui.modal x-on:open-modal-deletar-produto.window="open = true" class="max-w-[500px]">
        @include('components.modals.produtos.modal-deletar-produto')
    </x-ui.modal>

    <script>
        // Inicializar store IMEDIATAMENTE, não esperar pelo alpine:init
        if (!window.alpineStoreProduct) {
            window.alpineStoreProduct = {
                id: '',
                nome: '',
                descricao: '',
                preco: '',
                unidade_medida: '',
                ativo: false
            };
            console.log('Store de produto inicializado:', window.alpineStoreProduct);
        }

        document.addEventListener('alpine:init', () => {
            Alpine.store('produto', {
                id: '',
                nome: '',
                descricao: '',
                preco: '',
                unidade_medida: '',
                ativo: false
            });
            console.log('Alpine.store("produto") criado');
        });

        function produtoTableHandler() {
            return {
                async openProdutoEditModal(id) {
                    console.log('Abrindo modal de edição para produto:', id);
                    try {
                        const response = await fetch(`/produtos/${id}/edit`);
                        console.log('Response status:', response.status);
                        if (response.ok) {
                            const data = await response.json();
                            console.log('Dados do produto:', data);
                            Alpine.store('produto').id = data.id;
                            Alpine.store('produto').nome = data.nome;
                            Alpine.store('produto').descricao = data.descricao || '';
                            Alpine.store('produto').preco = data.preco;
                            Alpine.store('produto').unidade_medida = data.unidade_medida || '';
                            Alpine.store('produto').ativo = data.ativo;
                            console.log('Store atualizado, disparando evento de abertura...');
                            window.dispatchEvent(new CustomEvent('open-modal-editar-produto'));
                        } else {
                            console.error('Erro na resposta:', response.statusText);
                        }
                    } catch (err) {
                        console.error('Erro ao carregar produto:', err);
                    }
                },
                openProdutoDeleteModal(id, nome) {
                    console.log('Abrindo modal de deleção para produto:', id, nome);
                    Alpine.store('produto').id = id;
                    Alpine.store('produto').nome = nome;
                    window.dispatchEvent(new CustomEvent('open-modal-deletar-produto'));
                }
            }
        }
    </script>
</div>

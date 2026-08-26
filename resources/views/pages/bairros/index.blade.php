@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Bairros</h1>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Gerencie os bairros disponíveis para os clientes.</p>
            </div>
            <x-ui.button x-on:click="$dispatch('open-modal-bairro')" variant="primary" size="md">
                Cadastrar Bairro
            </x-ui.button>
        </div>

        <x-ui.modal x-on:open-modal-bairro.window="open = true" class="max-w-[500px] max-h-[90vh] overflow-y-auto">
            <div class="relative w-full rounded-3xl bg-white p-6 dark:bg-gray-900 lg:p-10">
                <h2 class="mb-6 text-lg font-bold text-gray-800 dark:text-white">Cadastro de Bairro</h2>
                <form id="bairroForm" class="grid grid-cols-1 gap-4" x-data="bairroFormHandler()" @submit.prevent="submitBairro">
                    <template x-if="mensagem">
                        <div :class="{'bg-green-100 text-green-800': sucesso, 'bg-red-100 text-red-800': !sucesso}" class="rounded-lg px-4 py-2 text-sm font-semibold">
                            <span x-text="mensagem"></span>
                        </div>
                    </template>
                    <div>
                        <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">Nome do Bairro *</label>
                        <input type="text" name="nome" placeholder="Digite o nome do bairro" required
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 transition-all" />
                    </div>
                    <div class="flex justify-end gap-3 mt-2">
                        <button type="button" x-on:click="open = false" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
                            Cancelar
                        </button>
                        <x-ui.button type="submit" variant="primary" size="sm">Salvar</x-ui.button>
                    </div>
                </form>
                <script>
                    function bairroFormHandler() {
                        return {
                            mensagem: '',
                            sucesso: false,
                            async submitBairro() {
                                const form = document.getElementById('bairroForm');
                                const data = Object.fromEntries(new FormData(form).entries());

                                try {
                                    const response = await fetch('{{ route('bairros.store') }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-Requested-With': 'XMLHttpRequest',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                        },
                                        body: JSON.stringify(data)
                                    });

                                    if (response.ok) {
                                        this.mensagem = 'Bairro cadastrado com sucesso!';
                                        this.sucesso = true;
                                        form.reset();
                                        setTimeout(() => window.location.reload(), 800);
                                    } else {
                                        const error = await response.json();
                                        this.mensagem = error.errors?.nome?.[0] || error.message || 'Erro ao cadastrar bairro.';
                                        this.sucesso = false;
                                    }
                                } catch (error) {
                                    this.mensagem = 'Erro ao cadastrar bairro.';
                                    this.sucesso = false;
                                }
                            }
                        };
                    }
                </script>
            </div>
        </x-ui.modal>

        @if(session('success'))
            <div class="mb-4 rounded-2xl border border-green-200 bg-green-50 px-4 py-4 text-sm text-green-800 dark:border-green-800 dark:bg-green-900/20 dark:text-green-200">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="overflow-x-auto p-4 sm:p-6">
                <table class="min-w-full border-separate border-spacing-0 text-left text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 dark:bg-gray-900 dark:text-gray-400">
                            <th class="px-4 py-3 font-medium">Nome</th>
                            <th class="px-4 py-3 font-medium text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse($bairros as $bairro)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/70">
                                <td class="px-4 py-4 text-gray-700 dark:text-white/90">{{ $bairro->nome }}</td>
                                <td class="px-4 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('bairros.edit', $bairro) }}" class="rounded-lg border border-blue-500 bg-blue-50 px-3 py-2 text-sm font-medium text-blue-700 transition hover:bg-blue-100 dark:border-blue-400 dark:bg-blue-500/10 dark:text-blue-200 dark:hover:bg-blue-500/20">
                                            Editar
                                        </a>
                                        <form action="{{ route('bairros.destroy', $bairro) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este bairro?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white transition hover:bg-red-700">
                                                Excluir
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-4 py-10 text-center text-sm text-gray-500 dark:text-gray-400">Nenhum bairro registrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-gray-200 bg-gray-50 px-4 py-4 text-right dark:border-gray-800 dark:bg-white/5">
                {{ $bairros->links() }}
            </div>
        </div>
    </div>
@endsection
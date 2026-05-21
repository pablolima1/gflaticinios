@props(['totalAnualVendas' => 0])
@php
    $anoAtual = now()->year;
@endphp
<div class="rounded-2xl border border-gray-200 bg-gray-100 dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="shadow-default rounded-2xl bg-white px-5 pb-11 pt-5 dark:bg-gray-900 sm:px-6 sm:pt-6">
        <div class="flex justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Movimentação Anual
                </h3>
                <p class="mt-1 text-theme-sm text-gray-500 dark:text-gray-400">
                    Ano de {{ $anoAtual }}
                </p>
            </div>
            <!-- Dropdown Menu -->
            <x-common.dropdown-menu />
            <!-- End Dropdown Menu -->
        </div>
        <div class="mt-8 flex items-center justify-center">
            <div class="text-center">
                <p class="text-theme-sm text-gray-500 dark:text-gray-400">
                    Total de Vendas
                </p>
                <p class="mt-2 text-4xl font-bold text-gray-800 dark:text-white/90">
                    R$ {{ number_format($totalAnualVendas, 2, ',', '.') }}
                </p>
            </div>
        </div>
        <p class="mx-auto mt-6 w-full max-w-[380px] text-center text-sm text-gray-500 dark:text-gray-400">
            Total geral de vendas registradas no período de 01 de janeiro a 31 de dezembro.
        </p>
    </div>
</div>

@props(['totalAnualVendas' => 0, 'totalAnualDespesas' => 0, 'lucroAnual' => 0, 'anoSelecionado' => null])
@php
    $anoAtual = now()->year;
    $anoSelecionado = $anoSelecionado ?? $anoAtual;
    $percentualLucro = $totalAnualVendas > 0 ? round(($lucroAnual / $totalAnualVendas) * 100, 2) : 0;
@endphp
<div class="rounded-2xl border border-gray-200 bg-gray-100 dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="shadow-default rounded-2xl bg-white px-5 pb-6 pt-5 dark:bg-gray-900 sm:px-6 sm:pt-6">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Movimentação Anual
                </h3>
                <div class="mt-3 flex gap-2 items-center">
                    <label class="text-theme-sm text-gray-500 dark:text-gray-400">Filtrar por ano:</label>
                    <select onchange="window.location.href='?year=' + this.value" 
                            class="px-3 py-1 text-theme-sm rounded-lg border border-gray-300 bg-white dark:bg-gray-900 dark:border-gray-700 dark:text-white/90">
                            @for($i = now()->year; $i >= 2020; $i--)
                            <option value="{{ $i }}" {{ $i == $anoSelecionado ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>
            <!-- Dropdown Menu -->
            <x-common.dropdown-menu />
            <!-- End Dropdown Menu -->
        </div>

        <!-- Visual Indicator -->
        <div class="relative mt-6 h-3 overflow-hidden rounded-full bg-gray-200 dark:bg-gray-800">
            @php
                $vendedorWidth = $totalAnualVendas > 0 ? ($totalAnualVendas / ($totalAnualVendas + $totalAnualDespesas)) * 100 : 0;
                $despesaWidth = $totalAnualDespesas > 0 ? 100 - $vendedorWidth : 0;
            @endphp
            <div class="h-full flex">
                @if($totalAnualVendas > 0)
                    <div class="bg-success-600" style="width: {{ $vendedorWidth }}%"></div>
                @endif
                @if($totalAnualDespesas > 0)
                    <div class="bg-error-600" style="width: {{ $despesaWidth }}%"></div>
                @endif
            </div>
        </div>

        <p class="mt-3 text-center text-sm text-gray-500 dark:text-gray-400">
            Lucro Líquido: <span class="font-semibold {{ $lucroAnual >= 0 ? 'text-success-600 dark:text-success-500' : 'text-error-600 dark:text-error-500' }}">{{ $percentualLucro }}%</span>
        </p>
    </div>

    <!-- Three Column Layout with Dividers -->
    <div class="flex items-center justify-center gap-5 px-6 py-3.5 sm:gap-8 sm:py-5">
        <!-- Vendas Column -->
        <div>
            <p class="mb-1 text-center text-theme-xs text-gray-500 dark:text-gray-400 sm:text-sm">
                Vendas
            </p>
            <p class="flex items-center justify-center gap-1 text-base font-semibold text-gray-800 dark:text-white/90 sm:text-lg">
                R${{ number_format($totalAnualVendas, 0, ',', '.') }}
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.26816 2.3368C7.4056 2.1808 7.60686 2.0824 7.8311 2.0824C7.83148 2.0824 7.83187 2.0824 7.83226 2.0824C8.02445 2.0822 8.21671 2.1553 8.36339 2.3019L12.3635 6.29924C12.6565 6.59203 12.6567 7.0669 12.3639 7.3599C12.0711 7.6529 11.5962 7.6531 11.3032 7.3603L8.5811 4.64L8.5811 13.5C8.5811 13.9142 8.24531 14.25 7.8311 14.25C7.41688 14.25 7.0811 13.9142 7.0811 13.5L7.0811 4.6444L4.36354 7.36025C4.07055 7.6531 3.59568 7.653 3.30288 7.3599C3.01008 7.0669 3.01023 6.5921 3.30321 6.2993L7.26816 2.3368Z" fill="#039855" />
                </svg>
            </p>
        </div>

        <!-- Vertical Divider -->
        <div class="h-7 w-px bg-gray-200 dark:bg-gray-800"></div>

        <!-- Despesas Column -->
        <div>
            <p class="mb-1 text-center text-theme-xs text-gray-500 dark:text-gray-400 sm:text-sm">
                Despesas
            </p>
            <p class="flex items-center justify-center gap-1 text-base font-semibold text-gray-800 dark:text-white/90 sm:text-lg">
                R${{ number_format($totalAnualDespesas, 0, ',', '.') }}
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.73184 13.6632C8.5944 13.8192 8.39314 13.9176 8.1689 13.9176C8.16852 13.9176 8.16813 13.9176 8.16774 13.9176C7.97555 13.9178 7.78329 13.8447 7.63661 13.6981L3.63648 9.70076C3.34349 9.40797 3.34333 8.9331 3.63612 8.6401C3.92891 8.34711 4.40378 8.34694 4.69677 8.63973L7.4189 11.36L7.4189 2.5C7.4189 2.08579 7.75469 1.75 8.1689 1.75C8.58312 1.75 8.9189 2.08579 8.9189 2.5L8.9189 11.3556L11.6365 8.63975C11.9295 8.34695 12.4043 8.3471 12.6971 8.64009C12.9899 8.93307 12.9898 9.40794 12.6968 9.70075L8.73184 13.6632Z" fill="#D92D20" />
                </svg>
            </p>
        </div>

        <!-- Vertical Divider -->
        <div class="h-7 w-px bg-gray-200 dark:bg-gray-800"></div>

        <!-- Lucro Column -->
        <div>
            <p class="mb-1 text-center text-theme-xs text-gray-500 dark:text-gray-400 sm:text-sm">
                Lucro
            </p>
            <p class="flex items-center justify-center gap-1 text-base font-semibold {{ $lucroAnual >= 0 ? 'text-success-600 dark:text-success-500' : 'text-error-600 dark:text-error-500' }} sm:text-lg">
                R${{ number_format($lucroAnual, 0, ',', '.') }}
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.26816 {{ $lucroAnual >= 0 ? '2.3368' : '13.6632' }}C7.4056 {{ $lucroAnual >= 0 ? '2.1808' : '13.8192' }} 7.60686 {{ $lucroAnual >= 0 ? '2.0824' : '13.9176' }} 7.8311 {{ $lucroAnual >= 0 ? '2.0824' : '13.9176' }}C7.83148 {{ $lucroAnual >= 0 ? '2.0824' : '13.9176' }} 7.83187 {{ $lucroAnual >= 0 ? '2.0824' : '13.9176' }} 7.83226 {{ $lucroAnual >= 0 ? '2.0824' : '13.9176' }}C8.02445 {{ $lucroAnual >= 0 ? '2.0822' : '13.9178' }} 8.21671 {{ $lucroAnual >= 0 ? '2.1553' : '13.8447' }} 8.36339 {{ $lucroAnual >= 0 ? '2.3019' : '13.6981' }}L12.3635 {{ $lucroAnual >= 0 ? '6.29924' : '9.70076' }}C12.6565 {{ $lucroAnual >= 0 ? '6.59203' : '9.40797' }} 12.6567 {{ $lucroAnual >= 0 ? '7.0669' : '8.9331' }} 12.3639 {{ $lucroAnual >= 0 ? '7.3599' : '8.6401' }}C12.0711 {{ $lucroAnual >= 0 ? '7.6529' : '8.34711' }} 11.5962 {{ $lucroAnual >= 0 ? '7.6531' : '8.34694' }} 11.3032 {{ $lucroAnual >= 0 ? '7.3603' : '8.63973' }}L8.5811 {{ $lucroAnual >= 0 ? '4.64' : '11.36' }}L8.5811 {{ $lucroAnual >= 0 ? '13.5' : '2.5' }}C8.5811 {{ $lucroAnual >= 0 ? '13.9142' : '2.08579' }} 8.24531 {{ $lucroAnual >= 0 ? '14.25' : '1.75' }} 7.8311 {{ $lucroAnual >= 0 ? '14.25' : '1.75' }}C7.41688 {{ $lucroAnual >= 0 ? '14.25' : '1.75' }} 7.0811 {{ $lucroAnual >= 0 ? '13.9142' : '2.08579' }} 7.0811 {{ $lucroAnual >= 0 ? '13.5' : '2.5' }}L7.0811 {{ $lucroAnual >= 0 ? '4.6444' : '11.3556' }}L4.36354 {{ $lucroAnual >= 0 ? '7.36025' : '8.63975' }}C4.07055 {{ $lucroAnual >= 0 ? '7.6531' : '8.34695' }} 3.59568 {{ $lucroAnual >= 0 ? '7.653' : '8.3471' }} 3.30288 {{ $lucroAnual >= 0 ? '7.3599' : '8.64009' }}C3.01008 {{ $lucroAnual >= 0 ? '7.0669' : '8.93307' }} 3.01023 {{ $lucroAnual >= 0 ? '6.5921' : '9.40794' }} 3.30321 {{ $lucroAnual >= 0 ? '6.2993' : '9.70075' }}L7.26816 {{ $lucroAnual >= 0 ? '2.3368' : '13.6632' }}Z" fill="currentColor" />
                </svg>
            </p>
        </div>
    </div>
</div>

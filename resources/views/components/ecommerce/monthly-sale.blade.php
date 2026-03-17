@php
    use App\Models\Venda;
    $meses = [];
    $valores = [];
    for ($i = 0; $i < 6; $i++) {
        $data = now()->subMonths($i);
        $mes = $data->format('m/Y');
        $inicio = $data->copy()->startOfMonth();
        $fim = $data->copy()->endOfMonth();
        $total = Venda::whereBetween('data_venda', [$inicio, $fim])->sum('valor_total');
        $meses[] = $mes;
        $valores[] = $total;
    }
    $meses = array_reverse($meses);
    $valores = array_reverse($valores);
@endphp
<div
    class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-5 pt-5 sm:px-6 sm:pt-6 dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
            Vendas Mensais
        </h3>

        <!-- Dropdown Menu -->
        <x-common.dropdown-menu />
        <!-- End Dropdown Menu -->
    </div>

    <div class="max-w-full overflow-x-auto custom-scrollbar">
        <div id="chartOne" class="-ml-5 h-full min-w-[690px] pl-2 xl:min-w-full"
            data-meses='{{ json_encode($meses) }}'
            data-valores='{{ json_encode($valores) }}'></div>
    </div>
</div>



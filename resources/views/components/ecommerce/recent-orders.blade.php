@props(['products' => [], 'clients' => []])

@php
    $defaultProducts = [
        [
            'name' => 'Macbook Pro 13"',
            'variants' => 2,
            'image' => '/images/product/product-01.jpg',
            'category' => 'Notebook',
            'price' => 'R$2399,00',
            'status' => 'Entregue',
        ],
        [
            'name' => 'Apple Watch Ultra',
            'variants' => 1,
            'image' => '/images/product/product-02.jpg',
            'category' => 'Relógio',
            'price' => 'R$879,00',
            'status' => 'Pendente',
        ],
        [
            'name' => 'iPhone 15 Pro Max',
            'variants' => 2,
            'image' => '/images/product/product-03.jpg',
            'category' => 'Smartphone',
            'price' => 'R$1869,00',
            'status' => 'Entregue',
        ],
        [
            'name' => 'iPad Pro 3ª Geração',
            'variants' => 2,
            'image' => '/images/product/product-04.jpg',
            'category' => 'Eletrônicos',
            'price' => 'R$1699,00',
            'status' => 'Cancelado',
        ],
        [
            'name' => 'Airpods Pro 2ª Geração',
            'variants' => 1,
            'image' => '/images/product/product-05.jpg',
            'category' => 'Acessórios',
            'price' => 'R$240,00',
            'status' => 'Entregue',
        ],
    ];
    
    // Se clients foi passado, monta a lista de clientes para a tabela
    $clientsList = !empty($clients) ? $clients : [];
    $productsList = !empty($products) ? $products : $defaultProducts;
    
    // Helper function for status classes
    $getStatusClasses = function($status) {
        $baseClasses = 'rounded-full px-2 py-0.5 text-theme-xs font-medium';
        
        return match($status) {
            'Entregue' => $baseClasses . ' bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500',
            'Pendente' => $baseClasses . ' bg-warning-50 text-warning-600 dark:bg-warning-500/15 dark:text-orange-400',
            'Cancelado' => $baseClasses . ' bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500',
            default => $baseClasses . ' bg-gray-50 text-gray-600 dark:bg-gray-500/15 dark:text-gray-400',
        };
    };
@endphp


<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6">
    <div class="mb-4">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Clientes que mais compraram</h3>
    </div>
    <div class="max-w-full overflow-x-auto custom-scrollbar">
        <table class="min-w-full">
            <thead>
                <tr class="border-t border-gray-100 dark:border-gray-800">
                    <th class="py-3 text-left">
                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Nome</p>
                    </th>
                    <th class="py-3 text-left">
                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Total de Compras</p>
                    </th>
                    <th class="py-3 text-left">
                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Valor Total</p>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($clientsList as $client)
                    <tr class="border-t border-gray-100 dark:border-gray-800">
                        <td class="py-3 whitespace-nowrap">
                            <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">{{ $client->nome }}</p>
                        </td>
                        <td class="py-3 whitespace-nowrap">
                            <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $client->total_vendas }}</p>
                        </td>
                        <td class="py-3 whitespace-nowrap">
                            <p class="text-gray-500 text-theme-sm dark:text-gray-400">R${{ number_format($client->total_gasto, 2, ',', '.') }}</p>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-3 text-center text-gray-500">Nenhum cliente encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
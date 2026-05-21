<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obter ano selecionado do query parameter ou usar ano atual
        $year = (int) $request->query('year', now()->year);
        
        // Validar se o ano é válido (permitir anos no passado e atual)
        if ($year < 2000 || $year > now()->addYear()->year) {
            $year = now()->year;
        }

        // Buscar os clientes que mais compraram
        $topClientes = \App\Models\Cliente::select('clientes.id', 'clientes.nome')
            ->leftJoin('vendas', 'clientes.id', '=', 'vendas.cliente_id')
            ->selectRaw('COUNT(vendas.id) as total_vendas, COALESCE(SUM(vendas.valor_total),0) as total_gasto')
            ->groupBy('clientes.id', 'clientes.nome')
            ->orderByDesc('total_gasto')
            ->take(5)
            ->get();

        // Buscar aniversariantes do mês
        $birthdays = \App\Models\Cliente::whereMonth('data_nascimento', now()->month)
            ->orderByRaw('DAY(data_nascimento)')
            ->get();
        
        // Calcular total anual de vendas para o ano selecionado
        $totalAnualVendas = \App\Models\Venda::whereBetween('data_venda', [
            now()->setYear($year)->startOfYear(),
            now()->setYear($year)->endOfYear()
        ])->sum('valor_total');
        
        // Calcular total anual de despesas para o ano selecionado
        $totalAnualDespesas = \App\Models\Despesa::whereBetween('data_despesa', [
            now()->setYear($year)->startOfYear(),
            now()->setYear($year)->endOfYear()
        ])->sum('valor');

        // Calcular lucro anual
        $lucroAnual = $totalAnualVendas - $totalAnualDespesas;
        
        return view('pages.dashboard.ecommerce', [
            'topClientes' => $topClientes,
            'birthdays' => $birthdays,
            'totalAnualVendas' => $totalAnualVendas,
            'totalAnualDespesas' => $totalAnualDespesas,
            'lucroAnual' => $lucroAnual,
            'anoSelecionado' => (int)$year
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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

        // Calcular total anual de vendas
        $totalAnualVendas = \App\Models\Venda::whereBetween('data_venda', [
            now()->startOfYear(),
            now()->endOfYear()
        ])->sum('valor_total');

        return view('pages.dashboard.ecommerce', [
            'topClientes' => $topClientes,
            'birthdays' => $birthdays,
            'totalAnualVendas' => $totalAnualVendas
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

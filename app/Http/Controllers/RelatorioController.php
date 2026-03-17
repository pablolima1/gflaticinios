<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    public function vendas(Request $request)
    {
        // Lógica para relatório de vendas
        return view('relatorios.vendas');
    }

    public function despesas(Request $request)
    {
        // Lógica para relatório de despesas
        return view('relatorios.despesas');
    }

    public function pedidosRecorrentes(Request $request)
    {
        // Lógica para relatório de pedidos recorrentes
        return view('relatorios.pedidos-recorrentes');
    }

    public function pagamentos(Request $request)
    {
        // Lógica para relatório de pagamentos
        return view('relatorios.pagamentos');
    }

    public function clientes(Request $request)
    {
        // Lógica para relatório de clientes
        return view('relatorios.clientes');
    }

    public function produtos(Request $request)
    {
        // Lógica para relatório de produtos
        return view('relatorios.produtos');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Services\VendaService;
use Illuminate\Http\Request;

class VendaController extends Controller
{
    public function __construct(private Venda $venda, private VendaService $vendaService)
    {
    }

    public function index()
    {
        // Busca as últimas 10 vendas registradas com seus relacionamentos, em ordem decrescente de cadastro
        $vendas = $this->venda
            ->with(['cliente', 'usuario', 'itensVenda.produto'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Separa vendas de hoje das outras datas
        $hoje = now()->startOfDay();
        $vendasRecentes = [
            'hoje' => $vendas->filter(fn($v) => $v->created_at->startOfDay()->eq($hoje)),
            'outrosDias' => $vendas->filter(fn($v) => !$v->created_at->startOfDay()->eq($hoje))
        ];

        return view('pages.vendas.index', compact('vendasRecentes'));
    }

    public function create()
    {
        return view('vendas.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
            'valor' => 'required|numeric|min:0',
            'status_pagamento' => 'required|in:pago,anotado',
        ]);

        try {
            $userId = auth()->id();
            $dataOriginal = str_replace('/', '-', $request->input('data'));
            $dataFormatada = date('Y-m-d', strtotime($dataOriginal));
            
            $valorTotal = $validatedData['valor'] * $validatedData['quantidade'];
            $isPago = $validatedData['status_pagamento'] === 'pago';

            // Prepara dados da venda
            $vendaData = [
                'cliente_id' => $validatedData['cliente_id'],
                'usuario_id' => $userId,
                'data_venda' => $dataFormatada,
                'tipo_pagamento' => $isPago ? 'vista' : 'prazo',
                'status' => $isPago ? 'pago' : 'pendente',
                'valor_total' => $valorTotal,
                'observacoes' => null,
            ];

            // Prepara dados dos itens
            $itensData = [[
                'produto_id' => $validatedData['produto_id'],
                'quantidade' => $validatedData['quantidade'],
                'preco_unitario' => $validatedData['valor'],
                'subtotal' => $valorTotal,
            ]];

            // Prepara dados do pagamento (se for "pago")
            $pagamentoData = $isPago ? [
                'valor' => $valorTotal,
                'forma_pagamento' => 'vista',
                'data_pagamento' => now(),
                'observacoes' => 'Pagamento registrado na venda',
            ] : null;

            // Usa o service para criar venda com pagamento
            $venda = $this->vendaService->criarVenda($vendaData, $itensData, $pagamentoData);

            return response()->json(['message' => 'Venda cadastrada com sucesso!'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao cadastrar venda.', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Venda $venda)
    {
        $validatedData = $request->validate([
            // Adicione regras de validação conforme o modelo
        ]);

        $venda->update($validatedData);

        return redirect()->route('vendas.index')->with('success', 'Venda atualizada com sucesso!');
    }

    public function destroy(Venda $venda)
    {
        $venda->delete();
        return redirect()->route('vendas.index')->with('success', 'Venda removida com sucesso!');
    }

    public function pendentes(Request $request)
    {
        // Recebe mês no formato 'YYYY-MM' ou usa mês atual
        $mesParam = $request->query('mes', now()->format('Y-m'));
        
        // Valida formato do mês
        if (!preg_match('/^\d{4}-\d{2}$/', $mesParam)) {
            $mesParam = now()->format('Y-m');
        }

        // Calcula primeiro e último dia do mês
        $inicio = \Carbon\Carbon::createFromFormat('Y-m', $mesParam)->startOfMonth();
        $fim = \Carbon\Carbon::createFromFormat('Y-m', $mesParam)->endOfMonth();

        // Constrói a query base
        $query = $this->venda
            ->where('status', 'pendente')
            ->where('tipo_pagamento', 'prazo')
            ->whereBetween('data_venda', [$inicio, $fim])
            ->with(['cliente', 'usuario', 'itensVenda.produto', 'pagamentos']);

        // Filtro opcional por cliente
        if ($request->has('cliente_id') && $request->cliente_id) {
            $query->where('cliente_id', $request->cliente_id);
        }

        // Ordenação e paginação
        $vendas = $query->orderBy('data_venda', 'desc')->paginate(50);

        // Busca clientes únicos do período para o filtro
        $clientesDisponiveis = $this->venda
            ->where('status', 'pendente')
            ->where('tipo_pagamento', 'prazo')
            ->whereBetween('data_venda', [$inicio, $fim])
            ->with('cliente')
            ->distinct()
            ->pluck('cliente_id')
            ->map(fn($id) => $this->venda->where('cliente_id', $id)->with('cliente')->first()->cliente)
            ->sortBy('nome');

        return view('pages.vendas.pendentes', compact('vendas', 'mesParam', 'clientesDisponiveis'));
    }

    public function concluidas(Request $request)
    {
        // Constrói a query base para vendas finalizadas
        $query = $this->venda
            ->where(function($q) {
                $q->where('tipo_pagamento', 'vista')
                  ->orWhere('status', 'pago');
            })
            ->with(['cliente', 'usuario', 'itensVenda.produto', 'pagamentos']);

        // Filtro opcional por cliente
        if ($request->has('cliente_id') && $request->cliente_id) {
            $query->where('cliente_id', $request->cliente_id);
        }

        // Ordenação e paginação
        $vendas = $query->orderBy('data_venda', 'desc')->paginate(50);

        // Busca clientes únicos de todas as vendas finalizadas para o filtro
        $clientesDisponiveis = $this->venda
            ->where(function($q) {
                $q->where('tipo_pagamento', 'vista')
                  ->orWhere('status', 'pago');
            })
            ->with('cliente')
            ->distinct()
            ->pluck('cliente_id')
            ->map(fn($id) => $this->venda->where('cliente_id', $id)->with('cliente')->first()->cliente)
            ->sortBy('nome');

        return view('pages.vendas.concluidas', compact('vendas', 'clientesDisponiveis'));
    }
}

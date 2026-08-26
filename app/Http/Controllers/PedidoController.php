<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Bairro;
use App\Models\ItemPedido;
use App\Models\Pedido;
use App\Models\Produto;
use App\Services\VendaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function __construct(private Pedido $pedido, private VendaService $vendaService)
    {
    }

    public function index(Request $request)
    {
        $query = $this->pedido->with(['cliente.bairro', 'itensPedido.produto'])->orderBy('data_entrega');

        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }

        if ($request->filled('status')) {
            $status = $request->status;

            if ($status === 'atrasado') {
                $query->where('status', '!=', 'entregue')->whereDate('data_entrega', '<', now()->toDateString());
            } elseif ($status === 'hoje') {
                $query->where('status', '!=', 'entregue')->whereDate('data_entrega', now()->toDateString());
            } elseif ($status === 'proximo') {
                $query->where('status', '!=', 'entregue')->whereDate('data_entrega', '>', now()->toDateString());
            } else {
                $query->where('status', $status);
            }
        }

        $dataInicio = $request->filled('data_inicio') ? $this->normalizarData($request->data_inicio) : null;
        $dataFim = $request->filled('data_fim') ? $this->normalizarData($request->data_fim) : null;

        if ($dataInicio && $dataFim) {
            $query->whereBetween('data_entrega', [$dataInicio, $dataFim]);
        }

        $pedidos = $query->get();
        $clientes = Cliente::orderBy('nome')->get();

        return view('pedidos.index', compact('pedidos', 'clientes'));
    }

    public function create()
    {
        $clientes = Cliente::with('bairro')->orderBy('nome')->get();
        $bairros = Bairro::orderBy('nome')->get();
        $produtos = Produto::where('ativo', true)->orderBy('nome')->get();

        return view('pedidos.create', compact('clientes', 'bairros', 'produtos'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'bairro_id' => 'nullable|exists:bairros,id',
            'data_entrega' => 'required',
            'observacoes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.produto_id' => 'required|exists:produtos,id',
            'items.*.quantidade' => 'required|integer|min:1',
            'items.*.valor_unitario' => 'required|numeric|min:0',
        ]);

        $dataEntrega = $this->normalizarData($validatedData['data_entrega']);

        $pedido = DB::transaction(function () use ($validatedData, $dataEntrega) {
            $cliente = Cliente::findOrFail($validatedData['cliente_id']);
            $cliente->update(['bairro_id' => $validatedData['bairro_id'] ?? null]);

            $pedido = Pedido::create([
                'cliente_id' => $validatedData['cliente_id'],
                'data_entrega' => $dataEntrega,
                'status' => 'pendente',
                'observacoes' => $validatedData['observacoes'] ?? null,
                'valor_total' => 0,
            ]);

            $total = 0;

            foreach ($validatedData['items'] as $itemData) {
                $valorTotalItem = (float) $itemData['quantidade'] * (float) $itemData['valor_unitario'];
                $total += $valorTotalItem;

                $pedido->itensPedido()->create([
                    'produto_id' => $itemData['produto_id'],
                    'quantidade' => $itemData['quantidade'],
                    'valor_unitario' => $itemData['valor_unitario'],
                    'valor_total' => $valorTotalItem,
                ]);
            }

            $pedido->valor_total = $total;
            $pedido->save();

            return $pedido;
        });

        return redirect()->route('pedidos.index')->with('success', 'Pedido criado com sucesso!');
    }

    public function edit(Pedido $pedido)
    {
        $pedido->load(['cliente', 'itensPedido.produto']);
        $clientes = Cliente::orderBy('nome')->get();
        $produtos = Produto::where('ativo', true)->orderBy('nome')->get();

        return view('pedidos.edit', compact('pedido', 'clientes', 'produtos'));
    }

    public function update(Request $request, Pedido $pedido)
    {
        $validatedData = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'data_entrega' => 'required',
            'observacoes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.produto_id' => 'required|exists:produtos,id',
            'items.*.quantidade' => 'required|integer|min:1',
            'items.*.valor_unitario' => 'required|numeric|min:0',
        ]);

        $dataEntrega = $this->normalizarData($validatedData['data_entrega']);

        DB::transaction(function () use ($pedido, $validatedData, $dataEntrega) {
            $pedido->update([
                'cliente_id' => $validatedData['cliente_id'],
                'data_entrega' => $dataEntrega,
                'observacoes' => $validatedData['observacoes'] ?? null,
            ]);

            $pedido->itensPedido()->delete();

            $total = 0;
            foreach ($validatedData['items'] as $itemData) {
                $valorTotalItem = (float) $itemData['quantidade'] * (float) $itemData['valor_unitario'];
                $total += $valorTotalItem;

                $pedido->itensPedido()->create([
                    'produto_id' => $itemData['produto_id'],
                    'quantidade' => $itemData['quantidade'],
                    'valor_unitario' => $itemData['valor_unitario'],
                    'valor_total' => $valorTotalItem,
                ]);
            }

            $pedido->valor_total = $total;
            $pedido->save();
        });

        return redirect()->route('pedidos.index')->with('success', 'Pedido atualizado com sucesso!');
    }

    public function destroy(Pedido $pedido)
    {
        DB::transaction(function () use ($pedido) {
            $pedido->itensPedido()->delete();
            $pedido->delete();
        });

        return redirect()->route('pedidos.index')->with('success', 'Pedido removido com sucesso!');
    }

    public function marcarComoEntregue(Pedido $pedido)
    {
        if ($pedido->venda_id) {
            return redirect()->route('pedidos.index')->with('error', 'Este pedido já foi convertido em venda.');
        }

        $this->entregarComVenda($pedido, true);

        return redirect()->route('pedidos.index')->with('success', 'Pedido entregue e venda concluída!');
    }

    public function entregarParaPagarDepois(Pedido $pedido)
    {
        if ($pedido->venda_id) {
            return redirect()->route('pedidos.index')->with('error', 'Este pedido já foi convertido em venda.');
        }

        $this->entregarComVenda($pedido, false);

        return redirect()->route('pedidos.index')->with('success', 'Pedido entregue e venda lançada como pendente!');
    }

    private function entregarComVenda(Pedido $pedido, bool $pago): void
    {
        DB::transaction(function () use ($pedido, $pago) {
            $pedido->loadMissing('itensPedido');

            $valorTotal = (float) $pedido->valor_total;
            $vendaData = [
                'cliente_id' => $pedido->cliente_id,
                'usuario_id' => auth()->id(),
                'data_venda' => now(),
                'tipo_pagamento' => $pago ? 'vista' : 'prazo',
                'status' => $pago ? 'pago' : 'pendente',
                'valor_total' => $valorTotal,
                'observacoes' => 'Venda gerada a partir do pedido #' . $pedido->id,
            ];

            $itensData = $pedido->itensPedido->map(fn (ItemPedido $item) => [
                'produto_id' => $item->produto_id,
                'quantidade' => $item->quantidade,
                'preco_unitario' => $item->valor_unitario,
                'subtotal' => $item->valor_total,
            ])->all();

            $pagamentoData = $pago ? [
                'valor' => $valorTotal,
                'forma_pagamento' => 'vista',
                'data_pagamento' => now(),
                'observacoes' => 'Pagamento registrado na entrega do pedido #' . $pedido->id,
            ] : null;

            $venda = $this->vendaService->criarVenda($vendaData, $itensData, $pagamentoData);

            $pedido->update([
                'status' => 'entregue',
                'entregue_em' => now(),
                'venda_id' => $venda->id,
            ]);
        });
    }

    private function normalizarData(string $valor): string
    {
        if (empty($valor)) {
            return now()->toDateString();
        }

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $valor)) {
            return $valor;
        }

        $formatado = str_replace('/', '-', trim($valor));

        return date('Y-m-d', strtotime($formatado));
    }
}

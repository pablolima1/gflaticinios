<?php

namespace App\Http\Controllers;

use App\Models\PedidoRecorrente;
use App\Models\Pedido;
use App\Models\Produto;
use App\Services\PedidoRecorrenteService;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PedidoRecorrenteController extends Controller
{
    public function __construct(
        private PedidoRecorrente $pedidoRecorrente,
        private PedidoRecorrenteService $service,
    ) {}

    public function index()
    {
        $pedidosRecorrentes = $this->pedidoRecorrente
            ->with(['cliente', 'produto'])
            ->where('ativo', true)
            ->orderBy('created_at', 'desc')
            ->get();
        $clientes = \App\Models\Cliente::orderBy('nome')->get(['id', 'nome']);
        $produtos = Produto::where('ativo', true)->orderBy('nome')->get(['id', 'nome', 'preco']);

        return view('pedidos_recorrentes.index', compact('pedidosRecorrentes', 'clientes', 'produtos'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cliente_id' => ['required', 'exists:clientes,id'],
            'produto_id' => ['required', Rule::exists('produtos', 'id')->where('ativo', true)],
            'quantidade' => ['required', 'integer', 'min:1'],
            'frequencia' => ['required', Rule::in(['semanal', 'quinzenal', 'mensal'])],
            'data_inicio' => ['required', 'date_format:d/m/Y'],
            'dia_semana' => ['required', 'integer', 'between:0,6'],
        ]);
        $validatedData['data_inicio'] = CarbonImmutable::createFromFormat('!d/m/Y', $validatedData['data_inicio'])->toDateString();

        DB::transaction(function () use ($validatedData) {
            $intervaloDias = match ($validatedData['frequencia']) {
                'semanal' => 7,
                'quinzenal' => 14,
                'mensal' => 30,
            };

            $recorrencia = $this->pedidoRecorrente->create([
                'cliente_id' => $validatedData['cliente_id'],
                'produto_id' => $validatedData['produto_id'],
                'quantidade' => $validatedData['quantidade'],
                'intervalo_dias' => $intervaloDias,
                'frequencia' => $validatedData['frequencia'],
                'dia_semana' => $validatedData['dia_semana'],
                'data_inicio' => $validatedData['data_inicio'],
                'proxima_entrega' => $validatedData['data_inicio'],
                'ativo' => true,
            ]);

            $produto = Produto::findOrFail($validatedData['produto_id']);
            $this->service->gerarPedidos($recorrencia, $produto);
        });

        return redirect()->route('pedidos-recorrentes.index')->with('success', 'Recorrência criada e pedidos gerados para os próximos seis meses.');
    }

    public function destroy(PedidoRecorrente $pedidoRecorrente)
    {
        DB::transaction(function () use ($pedidoRecorrente) {
            $pedidosFuturos = Pedido::where('pedido_recorrente_id', $pedidoRecorrente->id)
                ->where('status', 'pendente')
                ->whereDate('data_entrega', '>=', now()->toDateString())
                ->get();

            foreach ($pedidosFuturos as $pedido) {
                $pedido->itensPedido()->delete();
                $pedido->delete();
            }

            $pedidoRecorrente->delete();
        });

        return redirect()->route('pedidos-recorrentes.index')->with('success', 'Recorrência removida e pedidos futuros pendentes excluídos.');
    }
}

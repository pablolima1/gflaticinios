<?php

namespace App\Http\Controllers;

use App\Services\ClienteService;
use App\Services\ProcessoService;
use App\Services\TipoProcessoService;
use Illuminate\Http\Request;

class ProcessoController extends Controller
{
    public function __construct(
        private ProcessoService $processoService,
        private ClienteService $clienteService,
        private TipoProcessoService $tipoProcessoService
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $processos = $this->processoService->all();
        return view('pages.processos.index', compact('processos'));
    }

    public function balancoBalancete(Request $request)
    {
        $processos = $this->processoService->processosMesAno($request->all());
        //dd($processos);

        $receitaPrevista = $processos->sum('valor_parcela');
        $receitaRecebida = $receitaPrevista - $processos->sum('valor_restante');

        $mes = $request->input('mes', date('m'));
        $ano = $request->input('ano', date('Y'));

        return view('pages.processos.balanco-balancete.index', compact('processos', 'mes', 'ano', 'receitaPrevista', 'receitaRecebida'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = $this->clienteService->allSemPaginacao();
        $tipos_processos = $this->tipoProcessoService->allSemPaginacao();

        return view('pages.processos.create', compact('clientes', 'tipos_processos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            /* $validated = $request->validate([
                'cliente_id' => 'required|exists:clientes,id',
                'tipo_processo_id' => 'required|exists:tipos_processos,id',
                'numero_processo' => 'nullable|string|max:255',
                'esfera' => 'nullable|in:judicial,extrajudicial',
                'subtipo_processo' => 'nullable|string|max:255',
                'valor_total' => 'nullable|numeric|min:0',
                'valor_entrada' => 'nullable|numeric|min:0',
                'quantidade_parcelas' => 'nullable|integer|min:1|max:30',
                'valor_parcelas' => 'nullable|numeric|min:0',
                'data_entrada' => 'nullable|date',
            ]); */

            //dd($request->all());

            $this->processoService->create($request->all());

            return redirect()
                ->route('processos.index')
                ->with('success', 'Processo criado com sucesso!');


            /* return redirect()
                ->route('processos.show', $processo->id)
                ->with('success', 'Processo criado com sucesso!'); */
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $processo = $this->processoService->find($id);

        if (!$processo) {
            return redirect()
                ->route('processos.index')
                ->with('error', 'Processo não encontrado');
        }

        return view('pages.processos.show', compact('processo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $processo = $this->processoService->find($id);

        if (!$processo) {
            return redirect()
                ->route('processos.index')
                ->with('error', 'Processo não encontrado');
        }

        $clientes = $this->clienteService->allSemPaginacao();
        $tipos_processos = $this->tipoProcessoService->allSemPaginacao();

        return view('pages.processos.edit', compact('processo', 'clientes', 'tipos_processos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validated = $request->validate([
                'cliente_id' => 'required|exists:clientes,id',
                'tipo_processo_id' => 'required|exists:tipos_processos,id',
                'numero_processo' => 'nullable|string|max:255',
                'esfera' => 'nullable|in:judicial,extrajudicial',
                'subtipo_processo' => 'nullable|string|max:255',
                'valor_total' => 'nullable|numeric|min:0',
                'valor_entrada' => 'nullable|numeric|min:0',
                'quantidade_parcelas' => 'nullable|integer|min:1|max:30',
                'valor_parcelas' => 'nullable|numeric|min:0',
                'data_entrada' => 'nullable|date',
            ]);

            $processo = $this->processoService->update($id, $validated);

            return redirect()
                ->route('processos.show', $processo->id)
                ->with('success', 'Processo atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->processoService->delete($id);

            return redirect()
                ->route('processos.index')
                ->with('success', 'Processo deletado com sucesso!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }


    public function detalhes(string $id)
    {
        $processo = $this->processoService->find($id)->load('cliente', 'tipoProcesso');
        $pagamento = $processo->pagamentos()->with('parcelas')->get();
        
        return response()->json([
            'processo' => $processo,
            'pagamento' => $pagamento,
        ]);
    }
}

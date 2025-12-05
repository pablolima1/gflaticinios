<?php

namespace App\Http\Controllers;

use App\Services\ClienteService;
use App\Services\ProcessoService;
use Illuminate\Http\Request;

class ProcessoController extends Controller
{
    public function __construct(
        private ProcessoService $processoService,
        private ClienteService $clienteService
        )
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $processos = $this->processoService->all();
        return view('pages.processos.index', compact('processos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = $this->clienteService->allSemPaginacao();
        
        return view('pages.processos.create', compact('clientes'));
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

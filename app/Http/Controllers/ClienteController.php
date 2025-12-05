<?php

namespace App\Http\Controllers;

use App\Services\ClienteService;
use Illuminate\Http\Request;

class ClienteController extends Controller
{

    public function __construct(private ClienteService $clienteService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = $this->clienteService->all();

        return view('pages.administracao.clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.administracao.clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:20|unique:clientes,cpf',
            'email' => 'required|email|unique:clientes,email',
            'telefone' => 'nullable|string|max:20',
        ]);

        $this->clienteService->registerUser($data);

        return redirect()->route('clientes.index')->with('success', 'Cliente criado com sucesso!');
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
        $cliente = $this->clienteService->find($id);
        return view('pages.administracao.clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->clienteService->update($request->all(), $id);
        return redirect()->route('clientes.index')->with('success', 'Cliente atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->clienteService->delete($id);
        return redirect()->route('clientes.index')->with('success', 'Cliente deletado com sucesso!');
    }
}

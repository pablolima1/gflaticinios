<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private User $user)
    {
    }

    public function index()
    {
        $usuarios = $this->user->paginate(10);
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // Adicione regras de validação conforme o modelo
        ]);

        $this->user->create($validatedData);

        return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso!');
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            // Adicione regras de validação conforme o modelo
        ]);

        $user->update($validatedData);

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuário removido com sucesso!');
    }
}

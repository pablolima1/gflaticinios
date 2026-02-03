<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Http\Request;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function index()
    {
    
        if (auth()->user() && auth()->user()->tipo_usuario_id === 1) {
            return view('pages.auth.signup', ['title' => 'Sign Up']);
        } else {
            return redirect()->route('dashboard')->with('error', 'Acesso negado.');
        }
    }

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'tipo_usuario_id' => 2, // Definindo o tipo de usuário padrão como 2 (Cliente)
        ]);
    }
}

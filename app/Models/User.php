<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'tipo_usuario_id',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function tipoUsuario()
    {
        return $this->belongsTo(TipoUsuario::class, 'tipo_usuario_id');
    }

    public function clientesCriados()
    {
        return $this->hasMany(Cliente::class, 'responsavel_criacao');
    }

    public function processosResponsaveis()
    {
        return $this->hasMany(Processo::class, 'usuario_responsavel_id');
    }

    public function pagamentosCriados()
    {
        return $this->hasMany(Pagamento::class, 'usuario_criador_id');
    }

    public function registrosParcelas()
    {
        return $this->hasMany(ParcelaPagamento::class, 'usuario_registrou_id');
    }
}

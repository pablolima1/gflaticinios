<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoUsuario;

class TipoUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoUsuario::firstOrCreate(
            ['nome' => 'Administrador'],
            ['descricao' => 'Usuário com permissões administrativas']
        );

        TipoUsuario::firstOrCreate(
            ['nome' => 'Normal'],
            ['descricao' => 'Usuário com permissões padrão']
        );
    }
}

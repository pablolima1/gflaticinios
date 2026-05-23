<?php

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| A minimal set of routes for a clean project with authentication.
| Keep only login/signup and a single authenticated home view.
|
*/

// redirect root to login page
Route::get('/', fn() => redirect()->route('signin'));

// authentication pages (Tailadmin login/signup views)
Route::get('/signin', function () {
    return view('pages.auth.signin', ['title' => 'Login']);
})->name('signin');

Route::get('/signup', [CreateNewUser::class, 'index'])->name('signup');

// any routes below require authentication
Route::middleware('auth')->group(function () {
    // simple dashboard placeholder
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Rotas de relatórios
    Route::group(['prefix' => 'relatorios'], function () {
        Route::get('/vendas', [\App\Http\Controllers\RelatorioController::class, 'vendas'])->name('relatorios.vendas');
        Route::get('/despesas', [\App\Http\Controllers\RelatorioController::class, 'despesas'])->name('relatorios.despesas');
        Route::get('/pedidos-recorrentes', [\App\Http\Controllers\RelatorioController::class, 'pedidosRecorrentes'])->name('relatorios.pedidosRecorrentes');
        Route::get('/pagamentos', [\App\Http\Controllers\RelatorioController::class, 'pagamentos'])->name('relatorios.pagamentos');
        Route::get('/clientes', [\App\Http\Controllers\RelatorioController::class, 'clientes'])->name('relatorios.clientes');
        Route::get('/produtos', [\App\Http\Controllers\RelatorioController::class, 'produtos'])->name('relatorios.produtos');
    });

    // Grupo de rotas de despesas
    Route::group(['prefix' => 'despesas'], function () {
        Route::get('/', [\App\Http\Controllers\DespesaController::class, 'index'])->name('despesas.index');
        Route::get('/create', [\App\Http\Controllers\DespesaController::class, 'create'])->name('despesas.create');
        Route::post('/', [\App\Http\Controllers\DespesaController::class, 'store'])->name('despesas.store');
        Route::get('/{despesa}/edit', [\App\Http\Controllers\DespesaController::class, 'edit'])->name('despesas.edit');
        Route::put('/{despesa}', [\App\Http\Controllers\DespesaController::class, 'update'])->name('despesas.update');
        Route::delete('/{despesa}', [\App\Http\Controllers\DespesaController::class, 'destroy'])->name('despesas.destroy');
    });

    // Grupo de rotas para gerenciar tipos de despesa
    Route::group(['prefix' => 'tipos-despesas'], function () {
        Route::get('/', [\App\Http\Controllers\TipoDespesaController::class, 'index'])->name('tipos-despesas.index');
        Route::get('/create', [\App\Http\Controllers\TipoDespesaController::class, 'create'])->name('tipos-despesas.create');
        Route::post('/', [\App\Http\Controllers\TipoDespesaController::class, 'store'])->name('tipos-despesas.store');
        Route::get('/{tipo}/edit', [\App\Http\Controllers\TipoDespesaController::class, 'edit'])->name('tipos-despesas.edit');
        Route::put('/{tipo}', [\App\Http\Controllers\TipoDespesaController::class, 'update'])->name('tipos-despesas.update');
        Route::delete('/{tipo}', [\App\Http\Controllers\TipoDespesaController::class, 'destroy'])->name('tipos-despesas.destroy');
    });

    // Grupo de rotas de vendas
    Route::group(['prefix' => 'vendas'], function () {
        Route::get('/', [\App\Http\Controllers\VendaController::class, 'index'])->name('vendas.index');
        Route::get('/create', [\App\Http\Controllers\VendaController::class, 'create'])->name('vendas.create');
        Route::post('/', [\App\Http\Controllers\VendaController::class, 'store'])->name('vendas.store');
        Route::put('/{venda}', [\App\Http\Controllers\VendaController::class, 'update'])->name('vendas.update');
        Route::delete('/{venda}', [\App\Http\Controllers\VendaController::class, 'destroy'])->name('vendas.destroy');
        Route::get('/pendentes', [\App\Http\Controllers\VendaController::class, 'pendentes'])->name('vendas.pendentes');
        Route::get('/concluidas', [\App\Http\Controllers\VendaController::class, 'concluidas'])->name('vendas.concluidas');
        // Subgrupo de pagamentos
        Route::group(['prefix' => 'pagamentos'], function () {
            Route::get('/', [\App\Http\Controllers\PagamentoController::class, 'index'])->name('pagamentos.index');
            Route::get('/create', [\App\Http\Controllers\PagamentoController::class, 'create'])->name('pagamentos.create');
            Route::post('/', [\App\Http\Controllers\PagamentoController::class, 'store'])->name('pagamentos.store');
            Route::put('/{pagamento}', [\App\Http\Controllers\PagamentoController::class, 'update'])->name('pagamentos.update');
            Route::delete('/{pagamento}', [\App\Http\Controllers\PagamentoController::class, 'destroy'])->name('pagamentos.destroy');
        });
    });
    Route::group(['prefix' => 'clientes'], function () {
        Route::get('/', [\App\Http\Controllers\ClienteController::class, 'index'])->name('clientes.index');
        Route::get('/create', [\App\Http\Controllers\ClienteController::class, 'create'])->name('clientes.create');
        Route::get('/{cliente}/edit', [\App\Http\Controllers\ClienteController::class, 'show'])->name('clientes.show');
        Route::post('/', [\App\Http\Controllers\ClienteController::class, 'store'])->name('clientes.store');
        Route::put('/{cliente}', [\App\Http\Controllers\ClienteController::class, 'update'])->name('clientes.update');
        Route::delete('/{cliente}', [\App\Http\Controllers\ClienteController::class, 'destroy'])->name('clientes.destroy');
    });

    Route::group(['prefix' => 'produtos'], function () {
        Route::get('/', [\App\Http\Controllers\ProdutoController::class, 'index'])->name('produtos.index');
        Route::get('/create', [\App\Http\Controllers\ProdutoController::class, 'create'])->name('produtos.create');
        Route::get('/{produto}/edit', [\App\Http\Controllers\ProdutoController::class, 'show'])->name('produtos.show');
        Route::post('/', [\App\Http\Controllers\ProdutoController::class, 'store'])->name('produtos.store');
        Route::put('/{produto}', [\App\Http\Controllers\ProdutoController::class, 'update'])->name('produtos.update');
        Route::delete('/{produto}', [\App\Http\Controllers\ProdutoController::class, 'destroy'])->name('produtos.destroy');
    });

    Route::group(['prefix' => 'usuarios'], function () {
        Route::get('/', [\App\Http\Controllers\UserController::class, 'index'])->name('usuarios.index');
        Route::get('/create', [\App\Http\Controllers\UserController::class, 'create'])->name('usuarios.create');
        Route::post('/', [\App\Http\Controllers\UserController::class, 'store'])->name('usuarios.store');
        Route::put('/{usuario}', [\App\Http\Controllers\UserController::class, 'update'])->name('usuarios.update');
        Route::delete('/{usuario}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('usuarios.destroy');
    });

    Route::group(['prefix' => 'metas'], function () {
        Route::get('/', [\App\Http\Controllers\MetaController::class, 'index'])->name('metas.index');
        Route::get('/{meta}', [\App\Http\Controllers\MetaController::class, 'show'])->name('metas.show');
        Route::post('/', [\App\Http\Controllers\MetaController::class, 'store'])->name('metas.store');
        Route::put('/{meta}', [\App\Http\Controllers\MetaController::class, 'update'])->name('metas.update');
        Route::delete('/{meta}', [\App\Http\Controllers\MetaController::class, 'destroy'])->name('metas.destroy');
    });

    Route::group(['prefix' => 'vendas'], function () {
        Route::group(['prefix' => 'pagamentos'], function () {
            Route::get('/', [\App\Http\Controllers\PagamentoController::class, 'index'])->name('pagamentos.index');
            Route::get('/create', [\App\Http\Controllers\PagamentoController::class, 'create'])->name('pagamentos.create');
            Route::post('/', [\App\Http\Controllers\PagamentoController::class, 'store'])->name('pagamentos.store');
            Route::put('/{pagamento}', [\App\Http\Controllers\PagamentoController::class, 'update'])->name('pagamentos.update');
            Route::delete('/{pagamento}', [\App\Http\Controllers\PagamentoController::class, 'destroy'])->name('pagamentos.destroy');
        });
    });

    // Rotas API para selects dinâmicos
    Route::get('/api/clientes', [\App\Http\Controllers\ClienteController::class, 'apiList'])->name('api.clientes');
    Route::get('/api/produtos', [\App\Http\Controllers\ProdutoController::class, 'apiList'])->name('api.produtos');

    // Endpoint para versículo do dia
    Route::get('/biblia/versiculo-dia', [\App\Http\Controllers\BibliaController::class, 'versiculoDoDia'])->name('biblia.versiculoDoDia');

    // add additional authenticated routes here as needed
});

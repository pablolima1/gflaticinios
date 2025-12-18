<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProcessoController;
use App\Http\Controllers\TipoProcessoController;

Route::group(['middleware' => ['auth']], function () {
    // dashboard pages
    /* Route::get('/', function () {
        return view('pages.dashboard.ecommerce', ['title' => 'BML Advogados']);
    })->name('dashboard'); */

    Route::get('/home', function () {
        return view('pages.dashboard.ecommerce', ['title' => 'BML Advogados']);
    })->name('dashboard');

    Route::get('/', [ProcessoController::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'clientes'], function () {
        Route::get('/', [ClienteController::class, 'index'])->name('clientes.index');
        Route::get('/create', [ClienteController::class, 'create'])->name('clientes.create');
        Route::post('/', [ClienteController::class, 'store'])->name('clientes.store');
        Route::get('/{id}', [ClienteController::class, 'show'])->name('clientes.show');
        Route::get('/{id}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');
        Route::post('/{id}', [ClienteController::class, 'update'])->name('clientes.update');
        Route::get('/{id}/delete', [ClienteController::class, 'destroy'])->name('clientes.destroy');
    });

    Route::group(['prefix' => 'tipos-processos'], function () {
        Route::get('/', [TipoProcessoController::class, 'index'])->name('tipos-processos.index');
        Route::get('/create', [TipoProcessoController::class, 'create'])->name('tipos-processos.create');
        Route::post('/', [TipoProcessoController::class, 'store'])->name('tipos-processos.store');
        Route::get('/{id}', [TipoProcessoController::class, 'show'])->name('tipos-processos.show');
        Route::get('/{id}/edit', [TipoProcessoController::class, 'edit'])->name('tipos-processos.edit');
        Route::post('/{id}', [TipoProcessoController::class, 'update'])->name('tipos-processos.update');
        Route::get('/{id}/delete', [TipoProcessoController::class, 'destroy'])->name('tipos-processos.destroy');
    });

    Route::group(['prefix' => 'processos'], function () {
        Route::get('/', [ProcessoController::class, 'index'])->name('processos.index');
        Route::get('/create', [ProcessoController::class, 'create'])->name('processos.create');
        Route::post('/', [ProcessoController::class, 'store'])->name('processos.store');
        Route::get('/{id}', [ProcessoController::class, 'show'])->name('processos.show');
        Route::get('/{id}/edit', [ProcessoController::class, 'edit'])->name('processos.edit');
        Route::post('/{id}', [ProcessoController::class, 'update'])->name('processos.update');
        Route::post('/{id}/delete', [ProcessoController::class, 'destroy'])->name('processos.destroy');

        
    });

    Route::get('/balanco-balancete', [ProcessoController::class, 'balancoBalancete'])->name('processos.balanco-balancete');

// calender pages
    Route::get('/calendar', function () {
        return view('pages.calender', ['title' => 'Calendar']);
    })->name('calendar');

// profile pages
    Route::get('/profile', function () {
        return view('pages.profile', ['title' => 'Profile']);
    })->name('profile');

// form pages
    Route::get('/form-elements', function () {
        return view('pages.form.form-elements', ['title' => 'Form Elements']);
    })->name('form-elements');

// tables pages
    Route::get('/basic-tables', function () {
        return view('pages.tables.basic-tables', ['title' => 'Basic Tables']);
    })->name('basic-tables');

// pages

    Route::get('/blank', function () {
        return view('pages.blank', ['title' => 'Blank']);
    })->name('blank');

// error pages
    Route::get('/error-404', function () {
        return view('pages.errors.error-404', ['title' => 'Error 404']);
    })->name('error-404');

// chart pages
    Route::get('/line-chart', function () {
        return view('pages.chart.line-chart', ['title' => 'Line Chart']);
    })->name('line-chart');

    Route::get('/bar-chart', function () {
        return view('pages.chart.bar-chart', ['title' => 'Bar Chart']);
    })->name('bar-chart');

    // ui elements pages
    Route::get('/alerts', function () {
        return view('pages.ui-elements.alerts', ['title' => 'Alerts']);
    })->name('alerts');

    Route::get('/avatars', function () {
        return view('pages.ui-elements.avatars', ['title' => 'Avatars']);
    })->name('avatars');

    Route::get('/badge', function () {
        return view('pages.ui-elements.badges', ['title' => 'Badges']);
    })->name('badges');

    Route::get('/buttons', function () {
        return view('pages.ui-elements.buttons', ['title' => 'Buttons']);
    })->name('buttons');

    Route::get('/image', function () {
        return view('pages.ui-elements.images', ['title' => 'Images']);
    })->name('images');

    Route::get('/videos', function () {
        return view('pages.ui-elements.videos', ['title' => 'Videos']);
    })->name('videos');

});

// authentication pages
Route::get('/signin', function () {
    return view('pages.auth.signin', ['title' => 'Sign In']);
})->name('signin');

Route::get('/signup', function () {
    return view('pages.auth.signup', ['title' => 'Sign Up']);
})->name('signup');

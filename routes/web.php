<?php

use App\Actions\Fortify\CreateNewUser;
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
Route::get('/', fn () => redirect()->route('signin'));

// authentication pages (Tailadmin login/signup views)
Route::get('/signin', function () {
    return view('pages.auth.signin', ['title' => 'Sign In']);
})->name('signin');

Route::get('/signup', [CreateNewUser::class, 'index'])->name('signup');

// any routes below require authentication
Route::middleware('auth')->group(function () {
    // simple dashboard placeholder
    Route::get('/home', function () {
        return view('pages.dashboard.ecommerce'); // or replace with Tailadmin home
    })->name('home');

    // add additional authenticated routes here as needed
});


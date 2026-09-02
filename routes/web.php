<?php

use App\Http\Controllers\ComentariosController;
use App\Http\Controllers\ComunidadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoticiasController;
use App\Http\Controllers\ProblemasController;
use App\Http\Middleware\EnsureTeamMembership;
use App\Http\Middleware\SetTeamUrlDefaults;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
| 'home' es la landing pública (nexus_community).
*/

Route::view('/', 'nexus_community')->name('home');

/*
|--------------------------------------------------------------------------
| Rutas de configuración
|--------------------------------------------------------------------------
| Se registran ANTES del grupo con prefijo {current_team}.
*/

require __DIR__.'/settings.php';

/*
|--------------------------------------------------------------------------
| Rutas por equipo
|--------------------------------------------------------------------------
*/

Route::prefix('{current_team}')
    ->middleware([
        'auth',
        'verified',
        SetTeamUrlDefaults::class,
        EnsureTeamMembership::class,
    ])
    ->group(function (): void {
        Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');

        Route::resource('noticias', NoticiasController::class);
        Route::resource('comentarios', ComentariosController::class);
        Route::resource('comunidad', ComunidadController::class);
        Route::resource('problemas', ProblemasController::class);
    });

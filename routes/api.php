<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LivrosController;

Route::group(['prefix' => 'v1'], function () {
    // rotas para login
    Route::group([
        'prefix' => 'auth',
    ], function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);
    });

    Route::group([
        'middleware' => 'apiJwt',
        'prefix' => 'livros',
    ], function () {
        Route::post('/', [LivrosController::class, 'store']);
        Route::get('/', [LivrosController::class, 'index']);
        Route::get('/{id}/importar-indices-xml', [LivrosController::class, 'gerarXml']);


  
    });




});

<?php

use App\Models\Usuario as ModelsUsuario;
use App\Http\Controllers\API\Usuario as APIUsuario;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

//prefix define um prefixo comum para todas as rotas dentro do grupo
//group agrupa rotas sob um prefixo
Route::prefix('api/v1')->group(function () {
    Route::get('lista', function () {
        //criando um log que ficará armazenado em storage/logs/laravel.log se a execução do programa entrar nesta linha
        Log::info('O caminho api/v1/lista foi acessado com êxito');
        return ModelsUsuario::listar(5);
    });

    //executado um método post na rota api/v1/cadastrar a função salvar da classe controller Usuario dentro da pasta API será chamada
    Route::post('cadastrar',  [APIUsuario::class, 'salvar']);
});

<?php

use App\Http\Controllers\Usuario;
use Illuminate\Support\Facades\Route;

//definição de rota para uma view, é executado uma função anônima que retorna o nome do arquivo php a ser renderizado
// Route::get('/', function () {
//     return view('welcome');
// });

//definição de rotas para um controlador (Usuario) utiliza a sintaxe de array, passando o nome da classe e a função que vc quer executar
Route::get('/', function () {
    return view('usuario/cadastro');
})->name('home');
//posso apelidar a rota, se eu quiser, através do método estático name de Route
Route::post('/salvar', [Usuario::class, 'salvar'])->name('save');

Route::get('/deletar', [Usuario::class, 'loadDeletar'])->name('delete.form');

Route::delete('/deletar', [Usuario::class, 'delete'])->name('delete');

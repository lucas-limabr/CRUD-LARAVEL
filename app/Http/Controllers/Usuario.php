<?php

namespace App\Http\Controllers;

//existem 2 classes em pastas diferentes (controller e model) com o mesmo nome: usuario, como foi utilizado aqui a classe Usuario de outra pasta, ela foi apelidada aqui
use App\Models\Usuario as ModelsUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Usuario extends Controller
{
    public function salvar(Request $request)
    {
        //método da classe Request para fazer validação simples de campos de formulário
        $request->validate([
            "nome" => "required",
            "email" => "required|email|unique:usuario,email",
            "senha" => "required|min:5"
        ]);
        //o ideal é utilizar o Validation Form Request (documentação laravel) para criar e personalizar as validações

        //método de depuração, que exibe todos os dados de uma request http
        //dd($request->all());

        //apenas se passado pela validação acima, os dados via post do formulário são enviados para a classe Usuario do Model para enfim salvar em banco de dados
        if (ModelsUsuario::cadastrar($request)) {
            return view('usuario/sucesso', ["username" => $request->input('nome')]);
        } else {
            echo "<h3>Falha ao armazenar os dados, operação não concluída</h3>";
        }
    }
}

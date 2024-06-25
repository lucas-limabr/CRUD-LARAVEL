<?php

namespace App\Http\Controllers;

//existem 2 classes em pastas diferentes (controller e model) com o mesmo nome: usuario, como foi utilizado aqui a classe Usuario de outra pasta, ela foi apelidada aqui
use App\Models\Usuario as ModelsUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class Usuario extends Controller
{
    public function salvar(Request $request)
    {
        //método da classe Request para fazer validação simples de campos de formulário antes de passar para o BD
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

    public function loadDeletar()
    {
        return view('usuario/deletar');
    }
    public function delete(Request $request)
    {
        //validação mais complexa utilizando a classe Validator
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:usuario,id', // Substitua your_table pelo nome da sua tabela
        ]);

        if ($validator->fails()) {
            return redirect()->route('delete.form')
                ->withErrors($validator)
                ->withInput();
        }

        // se o return for diferente de zero executa
        if (ModelsUsuario::deletar($request)) {
            return redirect()->route('delete.form')->with('successo', 'Deletado com sucesso!');
        }
    }
}

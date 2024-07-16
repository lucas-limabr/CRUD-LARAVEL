<?php

namespace App\Http\Controllers;

//existem 2 classes em pastas diferentes (controller e model) com o mesmo nome: usuario, como foi utilizado aqui a classe Usuario de outra pasta, ela foi apelidada aqui
use App\Models\Usuario as ModelsUsuario;
use App\Rules\MaxRegistros;
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

    public function loadListar()
    {
        //tenho que passar para esta view todos os registros buscados no Model
        return view('usuario/listar');
    }

    public function loadDeletar()
    {
        return view('usuario/deletar');
    }

    public function loadCadastrar(){
        return view('usuario/cadastro');
    }

    public function delete(Request $request)
    {
        //validação mais complexa utilizando a classe Validator
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:usuario,id'
        ]);

        if ($validator->fails()) {
            return redirect()->route('delete.form')
                ->withErrors($validator)
                //usado para repopular os dados que o usuário tinha preenchido
                ->withInput();
        }

        // se o return for diferente de zero executa
        if (ModelsUsuario::deletar($request)) {
            return redirect()->route('delete.form')->with('successo', 'Deletado com sucesso!');
        } else {
            return redirect()->route('delete.form')->with('error', 'Não foi possível deletar');
        }
    }

    public function listar(Request $request)
    {
        $all_registers = $request->input('all_registers');
        
        $rules = [
            //a chave/input qtd_registros passará por uma validação personalizada. Um de seus valores será a invocação do construtor MaxRegistros
            //operador ternário: se all_registers estiver true, a validação irá deixar o campo qtd_registros aceitar nulo, senão, não aceita nulo e vale mais algumas regras para ele
            "qtd_registros" => $all_registers ? 'nullable' : ["required", "integer", "min:1", new MaxRegistros()],
            "id" => "required_without_all:nome,email,data",
            "nome" => "required_without_all:id,email,data",
            "email" => "required_without_all:id,nome,data",
            "data" => "required_without_all:id,nome,email",
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('load_list')
                ->withErrors($validator)
                ->withInput();
        }

        //$campos receberá um array, assim, a variável já assume o seu tipo. o que eu não posso fazer aqui é tipar a variável, fazendo isso: $campos[] = aí o seu conteúdo seria um array associativo, e o método select lá em Model não espera receber um array associativo, e sim, um array simples
        $campos = $this->camposPesquisados($request);

        $registros = ModelsUsuario::listagemPersonalizada($request, $campos);

        //por fim, retorno para a view os registros buscados no BD. Lá, estes dados serão renderizados conforme necessário
        return view('usuario/listar', [
            'registros' => $registros,
            'campos' => $campos,
        ]);
    }

    private function camposPesquisados(Request $request)
    {
        //correspondência entre os names dos inputs e os campos na tabela do BD
        $campos_in_table = [
            'id' => 'id',
            'nome' => 'nome',
            'email' => 'email',
            'data' => 'data_cadastro'
        ];

        //neste array só será armazenado os campos escolhidos pelo usuário
        $campos = [];

        // Verifica quais campos foram selecionados e os adiciona
        foreach ($campos_in_table as $key => $value) {
            if ($request->has($key)) {
                $campos[] = $value;
            }
        }

        return $campos;
    }

    public function loadAtualizar(){
        return view('usuario/atualizar');
    }
}

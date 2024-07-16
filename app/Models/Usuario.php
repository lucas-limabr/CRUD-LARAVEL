<?php

namespace App\Models;

use Illuminate\Support\Facades\Config;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

//o Eloquent ORM é o responsável pela abstração dos comandos sql do laravel, ele implementa toda a comunicação do BD
//pesquisar mais sobre queryBuilder na documentação do Laravel
class Usuario extends Model
{
    use HasFactory;

    //variáveis que estão definidas na classe Model para a conexão e uso de tabelas do BD nesta classe
    protected $connection = "sqlite";
    protected $table = "usuario";

    public static function listar(int $limite)
    {
        //método que vai criar o comando select retornando estes campos
        $sql = self::select([
            "id",
            "nome",
            "email",
            "senha",
            "data_cadastro",
        ])

            ->limit($limite);

        //dump and die. Função usada apenas para fins de depuração, ela executa o argumento da função, no caso, o método toSql que retorna uma string que é a sql pura gerada
        //dd($sql->toSql());

        //função dump para exibir o valor de uma variável , mas não mata a execução do programa
        //dump($sql->get());
        //returnando um objeto query builder
        return $sql->get();
    }

    public static function listagemPersonalizada(Request $request, array $campos)
    {
        //é smp indicado usar uma query builder
        //O query builder é uma interface que permite construir consultas SQL de maneira programática, utilizando métodos encadeáveis para adicionar cláusulas SELECT, WHERE, ORDER BY, etc.
        //O método query cria uma nova instância do query builder para o modelo no qual é chamado. Isso é útil quando você quer construir uma consulta personalizada que pode incluir diversas cláusulas.

        $query = self::query();

        //select preparado para ser realizado
        $query->select($campos);

        if (!$request->input('all_registers')) {
            //add uma cláusula, limitando a qtd de registros devolvidos, escolhido pelo usuário
            //métodos take e limit do Eloquent fazem a msm coisa, por convenção da comunidade é mais usado o take
            $query->take($request->input('qtd_registros'));
        }

        if ($request->has('nome') && $request->input('ordenacao') != 'vazio') {
            //add mais uma cláusula/condição ao select
            $query->orderBy('nome', $request->input('ordenacao'));
        }

        //método get é para executar finalmente um comando select. Muito importante: o método get da query builder retorna um objeto da classe Collection, que contém um array associativo com, além dos dados da consulta, vários outros dados, que são informações sensíveis. Eu quero retornar apenas os dados da consulta select feita, para isso, eu uso o método do Collection para tranformar essa coleção em um array associativo, contendo apenas os dados da consulta
        return $query->get()->toArray();
    }

    // recebe um objeto Request como parâmetro. Este objeto contém os dados da requisição HTTP (normalmente uma requisição POST)
    public static function cadastrar(Request $request)
    {
        //habilitação da querylog
        //DB::enableQueryLog();

        //método insert de Model retorna true or false para inserção de dados
        $sql = self::insert([
            "nome" => $request->input("nome"),
            "email" => $request->input("email"),
            //classe carbon que extende DateTime, para lidar melhor com datas, principalmente para uso do BD sqlite. Capturo a hora e data de momento do insert na região UTC definido no app_timzone do arquivo .env
            "data_cadastro" => Carbon::now(Config::get('app.timezone')),
            //pegando a senha e a criptografando com método da classe Hash
            "senha" => Hash::make($request->input("senha")),
        ]);

        //hash das funções md5 e sha, são algoritmos de criptografia que geram um hash para uma determinada senha, um hash para uma mesma senha sempré será o mesmo 
        //dd( md5("123"), sha1('123') );

        //hash gerada pela classe Hash do Laravel. Esse hash é extremamente seguro, ele tem como base a api key do arquivo env. A cada atualização de página um hash diferente é gerado para uma mesma senha, sendo único. Hashs diferentes para uma mesma senha, embora sejam visivelmente diferentes, são matematicamente iguais 
        //dd(Hash::make("123"),);

        //dump($sql);
        return $sql;
        //depuração e uso do método que recupera o comando sql gerado 
        //dd(DB::getQueryLog());
    }

    public static function deletar(Request $request)
    {
        //retorna 1 se conseguiu deletar um registro
        return self::destroy($request->id);
    }
}

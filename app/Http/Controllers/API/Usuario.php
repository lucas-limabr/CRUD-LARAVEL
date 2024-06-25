<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Usuario as ModelsUsuario;
use Illuminate\Http\Request;

class Usuario extends Controller
{
    public function salvar(Request $request)
    {   
        if(ModelsUsuario::cadastrar($request)){
            //o retorno idela de uma API não é uma view, e sim, um json, contendo, entre outras coisas, o código de status que o servidor deu como response para aquela solicitação
            return response('ok', 201);
        }
        else{
            return response('erro', 409);
        }
    }
}

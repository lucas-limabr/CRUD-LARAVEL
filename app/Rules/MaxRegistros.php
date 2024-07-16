<?php

namespace App\Rules;

use App\Models\Usuario;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

//esta classe foi uma regra que eu criei com o comando php artisan make:rule
class MaxRegistros implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    protected $total_registros;

    //no construtor eu busquei a quantidade de registros que contém no meu BD
    public function __construct(){
        $this->total_registros = Usuario::count();
    }
    
    //sobrescrevi, ou seja, implementei este método da interface para fazer a validação. Ele recebe o name do input a ser validado e o seu valor correspondente. $fail não recebe nada
    //O Laravel  chamará este método automaticamente
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if($value == 1 && $value > $this->total_registros){
            $fail('Nenhum registro foi encontrado na base de dados.');
        }
        
        if($value > $this->total_registros){
            //a msg de erro é passada para como argumento para a função anônima fail.
            $fail('A quantidade de registros não pode ser maior do que o total disponível.');
        }
    }
}

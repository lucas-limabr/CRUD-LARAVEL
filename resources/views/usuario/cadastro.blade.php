@extends('layout/base')

<link rel="stylesheet" href="{{asset('css/form.css')}}">

@section('title', 'Cadastro de usuário')

@section('conteudo')

    <fieldset>
        <legend>Formulário</legend>
        <form action="{{ route('save') }}" method="POST">
            {{-- token necessário para saber que a requisição que está sendo feita é válida, para segurança. evita bots que mandam requisições post para o servidor --}}
            {{ csrf_field() }}

            <p>
                <label for="nome">Nome: </label>
                <input type="text" name="nome" id="nome">

                {{-- objeto errors acessa métodos de sua classe para capturar os erros de validação definidos no controller e exibir as mensagens para todos os erros existentes  --}}
                @if ($errors->has('nome'))
                    {{-- foreach, pois, podem haver vários erros, e aí eu quero exibir todos eles no html--}}
                    @foreach ($errors->get('nome') as $erro)
                        <strong class="erro">{{ $erro }}</strong>
                    @endforeach
                @endif
            </p>

            <p>
                <label for="nome">Email: </label>
                <input type="email" name="email" id="email">

                @if ($errors->has('email'))
                    @foreach ($errors->get('email') as $erro)
                        <strong>{{ $erro }}</strong>
                    @endforeach
                @endif
            </p>

            <p>
                <label for="nome">Senha: </label>
                <input type="password" name="senha" id="senha">

                @if ($errors->has('senha'))
                    @foreach ($errors->get('senha') as $erro)
                        <strong class="erro">{{ $erro }}</strong>
                    @endforeach
                @endif
            </p>

            <div id="btn-form">
                <button type="submit">Enviar</button>
                <button type="reset">Limpar</button>
            </div>
        </form>
    </fieldset>

    <a href="{{ route('home') }}">Voltar</a>
@endsection



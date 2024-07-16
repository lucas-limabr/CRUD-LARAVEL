@extends('layout/base')

<link rel="stylesheet" href="{{asset('css/form.css')}}">
<link rel="stylesheet" href="{{asset('css/deletar.css')}}">

@section('title', 'Deletar registro')

@section('conteudo')

    <fieldset>
        <legend>Formulário</legend>

        <form action="{{ route('delete') }}" method="POST">

            {{-- token necessário para saber que a requisição que está sendo feita é válida, para segurança. evita bots que mandam requisições post para o servidor --}}
            {{ csrf_field() }}

            @method('DELETE')
            {{-- @method('DELETE') method spoofing: estou forçando este formulário a usar o método delete, que não é suportado diretamente por um formulário. Mas funcionaria sem ele também, eu conseguiria deletar, mas aí teria que colocar um Route::post('delete/' ...) em web.php --}}

            <p>
                <label for="id">ID: </label>
                {{-- função old() para repopular os dados de entrada nos campos do formulário --}}
                <input type="text" name="id" id="id" value="{{ old('id') }}">
                
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <strong>{{ $error }}</strong>
                    @endforeach

                @endif
            </p>

            <div id="btn-form">
                <button type="submit">Enviar</button>
                <button type="reset">Limpar</button>
            </div>
        </form>
    </fieldset>

    <p id="feedback">
        @if (session('successo'))
            <p style="color: green; margin-left: 70px; font-size: 1.4em">{{ session('successo') }}</p>
        @endif
        @if (session('error'))
            <p style="color: red; margin-left: 70px; font-size: 1.4em">{{ session('erro') }}</p>
        @endif
    </p>

    <a href="{{ route('home') }}">Voltar</a>
@endsection

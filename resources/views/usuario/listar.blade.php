@extends('layout/base')

<script src="{{ @asset('js/listar.js') }}"></script>

<link rel="stylesheet" href="{{ asset('css/listar.css') }}">
<link rel="stylesheet" href="{{ asset('css/form.css') }}">

@section('title', 'Listagem')

@section('conteudo')
    <h1>Listagem dos registros</h1>
    <hr>

    <fieldset>
        <legend>Escolha os parâmetros da busca</legend>

        <form action="{{ route('list') }}" method="POST">

            {{ csrf_field() }}

            <p>
                <label for="qtd">Escolha a quantidade de registros que você quer consultar: </label>
                <input type="number" step="1" name="qtd_registros" id="qtd" value="{{ old('qtd_registros') }}">

                @if ($errors->has('qtd_registros'))
                    @foreach ($errors->get('qtd_registros') as $erro)
                        <strong class="erro">{{ $erro }}</strong>
                    @endforeach
                @endif

                <br>
                <input type="checkbox" name="all_registers" id="all_registers">
                <label for="all_registers">Desejo consultar todos os registros</label>
            </p>

            <p>
                <label>Quais os campos você quer consultar? </label>

                {{-- um erro em id é comum a todos os erros dos inputs checkbox, o erro que pelo menos um campo deve ser selecionado --}}
                @if ($errors->has('id'))
                    @foreach ($errors->get('id') as $erro)
                        <strong class="erro">{{ $erro }}</strong>
                    @endforeach
                @endif

                <br>
                <input type="checkbox" name="mark_all" id="mark_all">
                <label for="mark_all">Marcar todas as opções</label>
                <br><br>

                <input type="checkbox" name="id" id="id" class="selecionar" {{ old('id') ? 'checked' : '' }}>
                <label for="id">ID</label>
                <br>

                <input type="checkbox" name="nome" id="nome" class="selecionar" {{ old('nome') ? 'checked' : '' }}>
                <label for="nome">Nome</label>
                <br>

                <input type="checkbox" name="email" id="email" class="selecionar"
                    {{ old('email') ? 'checked' : '' }}>
                <label for="email">Email</label>
                <br>

                <input type="checkbox" name="data" id="data" class="selecionar" {{ old('data') ? 'checked' : '' }}>
                <label for="data">Data e hora do cadastro</label>
            </p>

            <p id="order_nome">
                <label for="order">Como vc deseja ordenar o campo nome?</label>
                <select name="ordenacao" id="order">
                    <option value="vazio">--</option>
                    <option value="asc" {{ old('ordenacao') == 'asc' ? 'selected' : '' }}>Ascendente</option>
                    <option value="desc" {{ old('ordenacao') == 'desc' ? 'selected' : '' }}>Descendente</option>
                </select>
            </p>

            <div id="btn-form">
                <button type="submit">Buscar</button>
                <button type="reset">Limpar</button>
            </div>

        </form>
    </fieldset>

    @if (isset($registros) && count($registros) > 0)
        <div id="tabela">
            <h2>Resultados da busca</h2>
            <table>
                <thead>
                    <tr>
                        @foreach ($campos as $item)
                            @if ($item == 'id')
                                <th>ID</th>
                            @elseif($item == 'nome')
                                <th>Nome</th>
                            @elseif($item == 'email')
                                <th>Email</th>
                            @elseif($item == 'data_cadastro')
                                <th>Data e hora do cadastro</th>
                            @endif
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    {{-- varrendo um array associativo, registro por registro --}}
                    @foreach ($registros as $registro)
                        <tr>
                            {{-- varrendo um aray simples de strings --}}
                            @foreach ($campos as $coluna)
                                <td>{{ $registro[$coluna] }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <a href="{{ route('home') }}">Voltar</a>
@endsection

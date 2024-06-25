<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} - @yield('title')</title>

    {{-- estou utilizando um arquivo css normal para o estilo, mas o ideal é utilizar o mix do laravel para compactar todos os arquivos css e js do projeto, para fins apenas de desempenho, otimizando a velcidade de carregamento --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <header>
        <img src="{{ asset('/img/logo_dio.png') }}" alt="logo da dio">
    </header>

    <main>
        <section>
            @yield('conteudo')
        </section>
    </main>

    <footer>
        <p>
            Todos os direitos reservados &copy; -<a href="https://github.com/lucas-limabr" target="_blank"> Criado por Lucas Lima</a>
        </p>
    </footer>

</body>

</html>

@extends('layout/base')

<link rel="stylesheet" href="{{ asset('css/sucesso.css') }}">

@section('conteudo')
    <h2>Olá {{ $username }}, seu cadastro foi realizado com sucesso!</h2>
    <a href="{{ route('home') }}">Voltar</a>
@endsection

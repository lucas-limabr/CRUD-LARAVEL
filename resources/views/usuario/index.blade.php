@extends('layout/base')
<link rel="stylesheet" href="{{'css/style.css'}}">
<link rel="stylesheet" href="{{'css/index.css'}}">

@section('title', 'Home')

@section('conteudo')
    <a href="{{route('cadastro')}}">
        <div>Create</div>
    </a>
    <a href="{{route('list')}}">
        <div>List</div>
    </a>
    <a href="{{route('update')}}">
        <div>Update</div>
    </a>
    <a href="{{route('delete.form')}}">
        <div>Delete</div>
    </a>
@endsection
@extends('adminlte::page')

@section('title', 'Home')

@section('content_header')
    <div class="card-header">
        <h1>Pesquisa de Satisfação do Cliente!</h1>
    </div>
@stop

@section('content')
    <img src="/img/pss.jpg" class="img-fluid" alt="wallpaper">
    <p>Nosso objetivo é melhorar cada vez mais nosso atendimento proporcinando uma experiência única aos nossos clientes!</p>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop

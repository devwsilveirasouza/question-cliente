@extends('adminlte::page')

@section('title', 'User Register')

@section('content_header')

    <div class="card-header">
        <h1 class="card-title center">Painel de cadastro</h1>
    </div>

@stop

@section('content')
    @if ($status = Session::get('mensagem'))
        <h2> {{ $status }} </h2>
    @endif

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Cadastro de Usuário</h3>
        </div>
        {{-- Formulário de cadastro --}}
        <form class="form-horizontal form_create_user" id="form_create_user" action="{{ route('user.store') }}" method="post">
            @csrf
            <div class="card-body">
                {{-- Nome --}}
                <div class="form-group row">
                    <label for="inputText3" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="name form-control" id="inputText3" name="name" placeholder="Name" />
                        @if ($errors->has('name'))
                            <h6> Favor inserir seu nome! </h6>
                        @endif
                    </div>
                </div>
                {{-- Email --}}
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="email form-control" id="inputEmail3" name="email"
                            placeholder="Email" />
                        @if ($errors->has('name'))
                            <h6> Favor inserir seu email! </h6>
                        @endif
                    </div>
                </div>
                {{-- Senha --}}
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="password form-control" id="inputPassword3" name="password"
                            placeholder="Password" />
                        @if ($errors->has('password'))
                            <h6> Favor inserir sua senha! </h6>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="button-group">
                    <button type="submit" class="addUser btn btn-success btn-sm">Salvar</button>
                    <button type="reset" class="btn btn-danger btn-sm float-right">Limpar</button>
                    <button type="button" class="home_user btn btn-info btn-sm">Home</button>
                </div>
            </div>
        </form>
        {{-- Formulário de cadastro --}}
    </div>

@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/app.css"> --}}
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
@stop

@section('js')
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    {{-- Scripts Users --}}
    <script src="{{ asset('site/user.js') }}"></script>
@stop

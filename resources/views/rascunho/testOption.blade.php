@extends('adminlte::page')

@section('title', 'Cadastrar Opções')

@section('content_header')
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <div class="card-header">
        <h3 class="card-title center">Opções de resposta</h3>
    </div>
@stop

@section('content')
    @if ($status = Session::get('mensagem'))
        <h2> {{ $status }} </h2>
    @endif

    {{-- Em desenvolvimento com campos dinâmicos --}}
    <div class="card card-info">
        <form id="form_create_opcao_pergunta" class="form_create_opcao_pergunta" action="{{ route('perguntasopcao.store') }}"
            method="post">
            @csrf
            <div class="card-header">
                <h3 class="card-title">Cadastrar opções de resposta</h3>
            </div>
            <div class="card-body">
                <div class="input-group mb-3">
                    <div class="input-group-prepend ">
                        <label class="input-group-text" id="basic-addon1">Pergunta</label>

                        <select name="pergunta[]" id="pergunta" class="col-sm-10">
                            @foreach ($perguntas as $pergunta)
                                <option value="{{ $pergunta->id }}">{{ $pergunta->pergunta }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="input">
                        @if ($pergunta->respObrigatoria === 'Sim')
                            <div class="custom-control custom-input custom-control-inline">
                                <!-- Formulário Dinâmico -->
                                <div id="formulario">
                                    <!-- Botão para chamar a função em JS que cria os campos -->
                                    <div class="input-group mb-3">
                                        <div class="col-sm-2">
                                            <label class="custom-control-label" for="customTextInline1">Opção:</label>
                                        </div>
                                        <button class="btn btn-outline-primary btn-success ml-4" type="button"
                                            id="button-addon1" onclick="adicionarCampo()"> + </button>
                                        <input type="text" class="form-control" for="option" name="option[]"
                                            id="option" placeholder="Opção" aria-label="Option"
                                            aria-describedby="button-addon1">
                                    </div>
                                </div>
                                <!-- FIM BLOCO -->
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="col-sm-10">
                    <button type="submit" class="btn_opcao_pergunta btn btn-success float-right" value="Cadastrar"
                        name="cadastrar">Salvar</button>
                </div>
            </div>
        </form>
    </div>

@stop

<!-- Form -->
@section('js')
    <!-- Função adiciona campos -->
    <script type="text/javascript">
        var controleCampo = 1;

        function adicionarCampo() {
            controleCampo++;
            //console.log(controleCampo);

            document.getElementById('formulario').insertAdjacentHTML('beforeend',
                '<div class="input-group mb-3" id="campo' +
                controleCampo +
                '"><div class="col-sm-2"><label class="custom-control-label" for="customTextInline1">Opção:</label> </div> <button type="button" class="btn btn-outline-primary btn-success ml-4" id="button-addon1 ' +
                controleCampo + '" onclick="removerCampo(' + controleCampo +
                ')"> - </button> <input type="text" class="form-control" name="option[]" id="option" placeholder="Opção" /> </div>'
            );
        }

        function removerCampo(idCampo) {
            //console.log("Campo remover: " + idCampo);
            document.getElementById('campo' + idCampo).remove();
        }
    </script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>

@stop
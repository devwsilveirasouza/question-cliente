<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateQuestionRequest;
use Illuminate\Http\Request;

use App\Models\Question;
use App\Models\User;

class QuestionController extends Controller
{
    // Chama view principal das perguntas
    public function indexPerguntas()
    {
        return view('perguntas.index');
    }
    // Realiza a busca e monta os dados do datatable
    public function buscaDados(Request $request)
    {
        ## Leitura dos valores
        $draw                       = $request->get('draw');
        $start                      = $request->get('start');
        $rowperpage                 = $request->get('length'); // Exibição de linhas por págima

        $columnIndex_arr            = $request->get('order');
        $columnName_arr             = $request->get('columns');
        $order_arr                  = $request->get('order');
        $search_arr                 = $request->get('search');

        $columnIndex                = $columnIndex_arr[0]['column']; // Indice da coluna
        $columnName                 = $columnName_arr[$columnIndex]['data']; // Nome da coluna
        $columnSortOrder            = $order_arr[0]['dir']; // Definir ordenação das informações asc ou desc
        $searchValue                = $search_arr['value']; // Valor da pesquisa
        // Total de registros
        $totalRecords               = Question::select('count(*) as allcount')->count();
        // Total de registros com filtros
        $totalRecordswithFilter     = Question::select('count(*) as allcount')
            ->where('pergunta', 'like', '%' . $searchValue . '%')
            ->orWhere('tipoResposta', 'like', '%' . $searchValue . '%')
            ->count();
        // Buscar registros
        $records                    = Question::orderBy($columnName, $columnSortOrder)
            ->where('pergunta', 'like', '%' . $searchValue . '%')
            ->orWhere('tipoResposta', 'like', '%' . $searchValue . '%')
            ->select('questions.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        // Criando o array que vai receber as informações
        $data_arr = array();
        // Atribuindo as informações
        foreach ($records as $record) {
            $id                     = $record->id;
            $pergunta               = $record->pergunta;
            $respObrigatoria        = $record->respObrigatoria;
            $tipoResposta           = $record->tipoResposta;
            $usuario                = $record->user_id;
            $created_at             = \Carbon\Carbon::parse($record->created_at)->format('d/m/Y');

            // Criando os botões
            $btnEdit        = '<button type="button" value="' . $record->id . '" class="edit_pergunta btn btn-warning btn-sm ml-1">Editar</button>';
            $btnDelete      = '<button type="button" value="' . $record->id . '" class="delete_pergunta btn btn-danger btn-sm ml-1">Deletar</button>';
            $btnOption     = '<button type="button" value="' . $record->id . '" class="opcao_create btn btn-success btn-sm ml-1">Opção</button>';
            $btnDetails     = '<button type="button" value="' . $record->id . '" class="details_pergunta btn btn-info btn-sm ml-1">View</button>';

            $buttons                = ['<nobr>' . $btnOption . $btnDetails . $btnEdit . $btnDelete . '</nobr>'];
            // Carregando as informações no array
            $data_arr[] = array(
                "id"                => $id,
                "pergunta"          => $pergunta,
                "respObrigatoria"   => $respObrigatoria,
                "tipoResposta"      => $tipoResposta,
                "usuario"           => $usuario,
                "created_at"        => $created_at,
                "buttons"           => $buttons
            );
        }
        // Envio das informações
        $response = array(
            "draw"                  => intval($draw),
            "iTotalRecords"         => $totalRecords,
            "iTotalDisplayRecords"  => $totalRecordswithFilter,
            "aaData"                => $data_arr
        );
        echo json_encode($response);
        exit;
    }
    //-----------------------------Cadastrar--------------------------------
    /**
     * Chama a view de cadastro de perguntas
     */
    public function create()
    {
        return view('perguntas.create');
    }
    // Cadastra os dados no banco
    public function store(StoreUpdateQuestionRequest $request)
    {
        // $question = $request->all();
        // dd($question);
        $nova_pergunta = new Question();
        //   ---   Campo DB   ----------------------   Campos Input   ---------------------------------   //
        $nova_pergunta->pergunta            = request('pergunta');
        $nova_pergunta->respObrigatoria     = implode(',', request('obrigatoria'));
        $nova_pergunta->tipoResposta        = implode(',', request('tipoResposta'));
        $nova_pergunta->user_id             = request('usuario');

        $nova_pergunta->save();

        return redirect()->route('perguntasopcao.show')
            ->with('mensagem', 'Pergunta cadastrada com sucesso!');
    }
    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\Question  $question
    //  * @return \Illuminate\Http\Response
    //  */
    // /**
    //  * Mostra um registro especifico passando id pela rota
    //  */

    public function show(Question $pergunta)
    {
        /**
         * -- Consulta o id de usuario informado na pergunta e
         * busca o usuario e retorna o name  Users
         **/
        $usuario = User::find($pergunta->user_id);
        // dd($usuario);
        $pergunta->usuario = $usuario->name;

        return view('perguntas.show', ['pergunta' => $pergunta]);
    }
    /**
     * Chama o formulário para editar os dados */
    public function edit($id)
    {
        $perguntas = Question::where('id', $id)->get();

        return view('perguntas.edit', [
            'perguntas' => $perguntas
        ]);
    }
    /**
     * Atualiza os dados enviados pelo formulário de edição
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $pergunta = Question::find($request->id);
        $pergunta->pergunta             = $request->pergunta;
        $pergunta->respObrigatoria      = implode(',', $request->obrigatoria);
        $pergunta->tipoResposta         = implode(',', $request->tipoResposta);
        $pergunta->user_id              = $request->usuario;
        $pergunta->update();

        return redirect()->route('perguntas.index')
            ->with('mensagem', 'Atualização realizada com sucesso!');
    }
    /**
     * Exclui um registro.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function excluir($id)
    {
        // dd($id);
        $pergunta = Question::find($id);
        $pergunta->delete();

        // return redirect()->route('perguntas.index');
            return response()->json([
                'status' => 200,
                'mensagem' => 'Pergunta excluída com sucesso!',
            ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $options = Option::all();

        return view('admin.options.index')
        ->with('options', $options);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.options.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $array = ['error' => ''];

        $rules = [
            'titulo' => 'required|min:3',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $array['error'] =   $validator->messages();
            // return $array;
            return back()->with('mensagem', "Digite pelo menos 3 caracteres para o cadastro.");
        }

        // dd($request->all());
        if(!is_null($request->titulo)) {
            DB::beginTransaction();
            Option::create($request->all());
            DB::commit();
            return redirect()->route('options.index')
            ->with('mensagem', "Opção cadastrada com sucesso!");
        }
        return back()->with('mensagem', "Não foi possível realizar o cadastro.");

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $option = Option::find($id);

        return view('admin.options.edit')
            ->with('option', $option);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $option = Option::find($id);

        if($option) {

        DB::beginTransaction();

        $option->update($request->all());

        DB::commit();

        $request->session()->flash('mensagem', "Opção atualizada com sucesso!");

        return redirect()->route('options.index');

        } else {

            return back()->with('mensagem', "Não foi possível realizar a atualização.");

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $option = Option::find($id);

        DB::beginTransaction();

        $option->delete();

        DB::commit();

        $request->session()->flash('mensagem', "Registro excluído com sucesso!");

        return redirect()->route('options.index');

    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOperadoraRequest;
use App\Models\Operadora;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Util\Test;
use Illuminate\Support\Facades\Validator;

class OperadoraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $operadoras = Operadora::all();
        $operadorasview = [];
        foreach($operadoras as $index =>$operadora){
            $operadorasview[$index] = $operadora;
        }
        return response($operadorasview,200)->header("Access-Control-Allow-Origin", "*");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'descricao' => 'required',
            ],
            $messages = [
            'required' => 'O campo :attribute é obrigatório.',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }else{
            $operadora = new Operadora();
            $operadora->nome = $request->nome;
            $operadora->descricao = $request->descricao;
            $operadora->status = true;
            if($operadora->save()){
                return response($operadora, 201);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Operadora  $operadora
     * @return \Illuminate\Http\Response
     */
    public function show(Operadora $operadora)
    {
        if(Operadora::where('id',$operadora->id)->exists()){
            return response($operadora,200);
        }else{
            return response("",404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Operadora  $operadora
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Operadora  $operadora
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Operadora $operadora)
    {
        if($request->has('nome')){
            $operadora->nome = $request->nome;
        }
        if($request->has('descricao')){
            $operadora->descricao = $request->descricao;
        }
        if($request->has('status')){
            $operadora->status = $request->status;
        }
        if($operadora->save()){
            return response($operadora, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Operadora  $operadora
     * @return \Illuminate\Http\Response
     */
    public function destroy(Operadora $operadora)
    {
        if($operadora->delete()){
            return response('',204);
        }
    }
}

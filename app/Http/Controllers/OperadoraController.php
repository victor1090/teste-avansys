<?php

namespace App\Http\Controllers;

use App\Models\Operadora;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Util\Test;

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
        return $operadoras;
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
        $operadora = new Operadora();
        $operadora->nome = $request->nome;
        $operadora->descricao = $request->descricao;
        $operadora->status = true;
        if($operadora->save()){
            return response($operadora, 201);
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
        if(!isEmpty($request->nome)){
            $operadora->nome = $request->nome;
        }
        if(!isEmpty($request->descricao)){
            $operadora->descricao = $request->descricao;
        }
        if(!isEmpty($request->status)){
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

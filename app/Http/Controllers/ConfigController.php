<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;

use App\Tipouser;
use App\User;

use App\Config;

use stdClass;
use DB;
use Storage;
set_time_limit(600);


class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index1()
    {
        if(accesoUser([1,2])){


            $idtipouser=Auth::user()->tipo_user_id;
            $tipouser=Tipouser::find($idtipouser);

            $modulo="costounitario";

            return view('costounitario.index',compact('tipouser','modulo'));
        }
        else
        {
            return redirect('home');    
        }
    }

    public function index(Request $request)
    {
        /* $buscar=$request->busca; */

        $costoUnitarioKw = Config::where('name', 'costoUnitarioKwToSoles')->first();

          return [
            'costoUnitarioKw'=>$costoUnitarioKw
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id=$request->id;
        $name=$request->name;
        $value=$request->value;

        $result='1';
        $msj='';
        $selector='';

        $input1  = array('value' => $value);
        $reglas1 = array('value' => 'required');

        $validator1 = Validator::make($input1, $reglas1);

        if ($validator1->fails())
        {
            $result='0';
            $msj='Debe ingresar el valor del Costo Unitario Kw/h';
            $selector='txtvalue';
        }
        elseif (!is_numeric($value))
        {
            $result='0';
            $msj='El valor del Costo Unitario Kw/h debe ser numerico';
            $selector='txtvalue';
        }
        else{

            $costoUnitarioKw = Config::where('name', 'costoUnitarioKwToSoles')->first();

            $costoUnitarioKw->value = $value;

            $costoUnitarioKw->save();

            $msj='Costo Unitario Kw/h Actualizado Exitosamente';

        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

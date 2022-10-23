<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;

use App\Tipouser;
use App\User;

use App\Zona;

use stdClass;
use DB;
use Storage;
set_time_limit(600);

class ZonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index1()
    {
        if(accesoUser([1,2,3])){


            $idtipouser=Auth::user()->tipo_user_id;
            $tipouser=Tipouser::find($idtipouser);

            $modulo="zona";

            return view('zona.index',compact('tipouser','modulo'));
        }
        else
        {
            return redirect('home');    
        }
    }


    public function index(Request $request)
    {
        $buscar=$request->busca;

        $queryZero=Zona::where('borrado','0')
        ->where(function($query) use ($buscar){
            $query->where('nombre','like','%'.$buscar.'%');
            $query->orWhere('descripcion','like','%'.$buscar.'%');
            });


        $registros = $queryZero
        ->orderBy('nombre')
        ->orderBy('id')
        ->paginate(50);

          return [
            'pagination'=>[
                'total'=> $registros->total(),
                'current_page'=> $registros->currentPage(),
                'per_page'=> $registros->perPage(),
                'last_page'=> $registros->lastPage(),
                'from'=> $registros->firstItem(),
                'to'=> $registros->lastItem(),
            ],
            'registros'=>$registros
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
        ini_set('memory_limit','256M');
        ini_set('upload_max_filesize','20M');

        $nombre=$request->nombre;
        $descripcion=$request->descripcion;
        $activo=$request->activo;

        $result='1';
        $msj='';
        $selector='';


        $input1  = array('nombre' => $nombre);
        $reglas1 = array('nombre' => 'required');

        $input2  = array('nombre' => $nombre);
        $reglas2 = array('nombre' => 'unique:zonas,nombre'.',1,borrado');

        $input3  = array('descripcion' => $descripcion);
        $reglas3 = array('descripcion' => 'required');

        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);

        if ($validator1->fails())
        {
            $result='0';
            $msj='Debe ingresar el nombre de la Zona';
            $selector='txtnombre';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='El nombre de la Zona ya se encuentra registrado';
            $selector='txtnombre';
        }
        /* elseif ($validator3->fails())
        {
            $result='0';
            $msj='Debe ingresar la Descripción del Diagnóstico CIE 10';
            $selector='txtdescripcion';
        } */
        else{
            $registro = new Zona;

            $registro->nombre=$nombre;
            $registro->descripcion=$descripcion;
            $registro->activo=$activo;
            $registro->borrado='0';

            $registro->save();

            $msj='Nueva Zona Registrada con Éxito';

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
        ini_set('memory_limit','256M');

        $nombre=$request->nombre;
        $descripcion=$request->descripcion;
        $activo=$request->activo;

        $result='1';
        $msj='';
        $selector='';


        
        $input1  = array('nombre' => $nombre);
        $reglas1 = array('nombre' => 'required');

        $input2  = array('nombre' => $nombre);
        $reglas2 = array('nombre' => 'unique:zonas,nombre,'.$id.',id,borrado,0');

        $input3  = array('descripcion' => $descripcion);
        $reglas3 = array('descripcion' => 'required');

        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);

        if ($validator1->fails())
        {
            $result='0';
            $msj='Debe ingresar el nombre de la Zona';
            $selector='txtnombreE';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='El nombre de la Zona ya se encuentra registrado';
            $selector='txtnombreE';
        }
        /* elseif ($validator3->fails())
        {
            $result='0';
            $msj='Debe ingresar la Descripción del Diagnóstico CIE 10';
            $selector='txtdescripcionE';
        } */
        else{

            $registro = Zona::findOrFail($id);

            $registro->nombre=$nombre;
            $registro->descripcion=$descripcion;
            $registro->activo=$activo;

            $registro->save();


        $msj='La Zona ha sido modificada con éxito';

        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function altabaja($id,$estado)
    {
        $result='1';
        $msj='';
        $selector='';

        $registro = Zona::findOrFail($id);
        $registro->activo = $estado;
        $registro->save();

        if(strval($estado)=="0"){
            $msj='La Zona fue dada de Baja exitosamente';
        }elseif(strval($estado)=="1"){
            $msj='La Zona fue dada de Alta exitosamente';
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    public function destroy($id)
    {
        $result='1';
        $msj='1';

        $registro = Zona::findOrFail($id);
        
        //$task->delete();
        $registro->borrado='1';
        $registro->save();

        $msj='Zona eliminada exitosamente';


        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}

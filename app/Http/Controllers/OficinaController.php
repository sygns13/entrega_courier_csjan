<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;

use App\Tipouser;
use App\User;

use App\Oficina;
use App\UserPermiso;

use stdClass;
use DB;
use Storage;
set_time_limit(600);

class OficinaController extends Controller
{
    
    public function index1()
    {
        if(accesoUser([1])){


            $idtipouser=Auth::user()->tipo_user_id;
            $tipouser=Tipouser::find($idtipouser);
            $permiso1 = UserPermiso::where('user_id', Auth::user()->id)->where('permiso_id', '1')->first();
            $permiso2 = UserPermiso::where('user_id', Auth::user()->id)->where('permiso_id', '2')->first();

            $modulo="oficina";

            return view('oficina.index',compact('tipouser','modulo', 'permiso1', 'permiso2'));
        }
        else
        {
            return redirect('home');    
        }
    }

    public function index(Request $request)
    {
        $buscar=$request->busca;

        $queryZero=Oficina::where('borrado','0')
        ->where(function($query) use ($buscar){
            $query->where('nombre','like','%'.$buscar.'%');
            //$query->orWhere('telefono','like','%'.$buscar.'%');
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

    public function store(Request $request)
    {
        ini_set('memory_limit','256M');
        ini_set('upload_max_filesize','20M');

        $nombre=$request->nombre;
        $telefono=$request->telefono;
        $activo=$request->activo;

        $result='1';
        $msj='';
        $selector='';


        $input1  = array('nombre' => $nombre);
        $reglas1 = array('nombre' => 'required');

        $input2  = array('nombre' => $nombre);
        $reglas2 = array('nombre' => 'unique:oficinas,nombre'.',1,borrado');

        $input3  = array('telefono' => $telefono);
        $reglas3 = array('telefono' => 'required');

        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);

        if ($validator1->fails())
        {
            $result='0';
            $msj='Debe ingresar el nombre de la oficina';
            $selector='txtnombre';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='El nombre de la oficina ya se encuentra registrado';
            $selector='txtnombre';
        }
        /* elseif ($validator3->fails())
        {
            $result='0';
            $msj='Debe ingresar la Descripción del Diagnóstico CIE 10';
            $selector='txttelefono';
        } */
        else{
            $registro = new Oficina;

            $registro->nombre=$nombre;
            $registro->telefono=$telefono;
            $registro->activo=$activo;
            $registro->borrado='0';

            $registro->save();

            $msj='Nueva Oficina Registrada con Éxito';

        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }


    public function update(Request $request, $id)
    {
        ini_set('memory_limit','256M');

        $nombre=$request->nombre;
        $telefono=$request->telefono;
        $activo=$request->activo;

        $result='1';
        $msj='';
        $selector='';


        
        $input1  = array('nombre' => $nombre);
        $reglas1 = array('nombre' => 'required');

        $input2  = array('nombre' => $nombre);
        $reglas2 = array('nombre' => 'unique:oficinas,nombre,'.$id.',id,borrado,0');

        $input3  = array('telefono' => $telefono);
        $reglas3 = array('telefono' => 'required');

        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);

        if ($validator1->fails())
        {
            $result='0';
            $msj='Debe ingresar el nombre de la oficina';
            $selector='txtnombreE';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='El nombre de la oficina ya se encuentra registrado';
            $selector='txtnombreE';
        }
        /* elseif ($validator3->fails())
        {
            $result='0';
            $msj='Debe ingresar la Descripción del Diagnóstico CIE 10';
            $selector='txttelefonoE';
        } */
        else{

            $registro = Oficina::findOrFail($id);

            $registro->nombre=$nombre;
            $registro->telefono=$telefono;
            $registro->activo=$activo;

            $registro->save();


        $msj='La Oficina ha sido modificada con éxito';

        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    public function altabaja($id,$estado)
    {
        $result='1';
        $msj='';
        $selector='';

        $registro = Oficina::findOrFail($id);
        $registro->activo = $estado;
        $registro->save();

        if(strval($estado)=="0"){
            $msj='La Oficina fue dada de Baja exitosamente';
        }elseif(strval($estado)=="1"){
            $msj='La Oficina fue dada de Alta exitosamente';
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    public function destroy($id)
    {
        $result='1';
        $msj='1';

        $registro = Oficina::findOrFail($id);
        
        //$task->delete();
        $registro->borrado='1';
        $registro->save();

        $msj='Oficina eliminada exitosamente';


        return response()->json(["result"=>$result,'msj'=>$msj]);
    }


}

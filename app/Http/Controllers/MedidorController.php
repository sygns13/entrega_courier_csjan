<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;

use App\Tipouser;
use App\User;

use App\Zona;
use App\PuestoLocal;
use App\Medidor;
use App\PuestoLocalPersona;

use stdClass;
use DB;
use Storage;
set_time_limit(600);

class MedidorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index1($idMedidor)
    {
        if(accesoUser([1,2,3])){


            $idtipouser=Auth::user()->tipo_user_id;
            $tipouser=Tipouser::find($idtipouser);
            $zonas=Zona::orderBy('id')->where('borrado','0')->get();

            $puesto = PuestoLocal::find($idMedidor);

            $modulo="medidor";

            return view('medidor.index',compact('tipouser','modulo','zonas','puesto'));
        }
        else
        {
            return redirect('home');    
        }
    }

    public function index(Request $request)
    {
        $buscar=$request->busca;
        $puesto_local_id=$request->v1;

        $registros = DB::table('medidors')
     ->join('puesto_locals', 'puesto_locals.id', '=', 'medidors.puesto_local_id')
     /* ->leftjoin('escuelas', 'escuelas.id', '=', 'personals.escuela_id') */
     ->where('puesto_locals.id', $puesto_local_id)
     ->where('medidors.borrado', '0')
     ->where(function($query) use ($buscar){
        $query->where('medidors.serie','like','%'.$buscar.'%');
        $query->orWhere('medidors.descripcion','like','%'.$buscar.'%');
        })
     ->orderBy('medidors.id')
     ->select('medidors.id',
                'medidors.serie',
                'medidors.descripcion',
                'medidors.alta',
                'medidors.baja',
                'medidors.activo',
                'medidors.lectura_ultima',
                'medidors.borrado',
                'medidors.created_at',
                'medidors.updated_at',
                'medidors.puesto_local_id')
     ->paginate(30);

     foreach ($registros as $registro) {
         $registro->lectura_ultima = number_format($registro->lectura_ultima, 2, '.', '');
     }

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

        $serie = $request->serie;
        $descripcion = $request->descripcion;
        $puesto_local_id = $request->puesto_local_id;
        $alta = $request->alta;
        $lectura_ultima = $request->lectura_ultima;

        if($descripcion == null){
            $descripcion = '';
        }

        $result = '1';
        $msj = '';
        $selector = '';

        $input1  = array('serie' => $serie);
        $reglas1 = array('serie' => 'required');

        $input2  = array('serie' => $serie);
        $reglas2 = array('serie' => 'unique:medidors,serie'.',1,borrado');

        $input3  = array('alta' => $alta);
        $reglas3 = array('alta' => 'required');

        $input4  = array('puesto_local_id' => $puesto_local_id);
        $reglas4 = array('puesto_local_id' => 'required');

        $input5  = array('lectura_ultima' => $lectura_ultima);
        $reglas5 = array('lectura_ultima' => 'required');

        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);
        $validator5 = Validator::make($input5, $reglas5);

        if ($validator1->fails())
        {
            $result='0';
            $msj='Debe ingresar la Serie del Medidor';
            $selector='txtserie';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='La serie de medidor ingresda ya se encuentra registrada';
            $selector='txtserie';
        }
        elseif ($validator3->fails())
        {
            $result='0';
            $msj='Debe de ingresar la fecha de alta del medidor';
            $selector='txtalta';
        }
        elseif ($validator4->fails())
        {
            $result='0';
            $msj='Debe de seleccionar un puesto/local';
            $selector='cbupuesto_local_id';
        }
        elseif ($validator5->fails())
        {
            $result='0';
            $msj='Ingrese la lectura anterior del medidor';
            $selector='txtlectura_ultima';
        }
        else{
            $registro = new Medidor;

            $registro->serie=$serie;
            $registro->descripcion=$descripcion;
            $registro->puesto_local_id=$puesto_local_id;
            $registro->alta=$alta;
            $registro->activo='1';
            $registro->lectura_ultima=$lectura_ultima;
            $registro->borrado='0';

            $registro->save();

            $msj='Nuevo Medidor Registrado con Éxito';
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
        ini_set('upload_max_filesize','20M');

        $serie = $request->serie;
        $descripcion = $request->descripcion;
        $alta = $request->alta;
        $lectura_ultima = $request->lectura_ultima;

        if($descripcion == null){
            $descripcion = '';
        }

        $result = '1';
        $msj = '';
        $selector = '';

        $input1  = array('serie' => $serie);
        $reglas1 = array('serie' => 'required');

        $input2  = array('serie' => $serie);
        $reglas2 = array('serie' => 'unique:medidors,serie,'.$id.',id,borrado,0');

        $input3  = array('alta' => $alta);
        $reglas3 = array('alta' => 'required');

        $input5  = array('lectura_ultima' => $lectura_ultima);
        $reglas5 = array('lectura_ultima' => 'required');

        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator5 = Validator::make($input5, $reglas5);

        if ($validator1->fails())
        {
            $result='0';
            $msj='Debe ingresar la Serie del Medidor';
            $selector='txtserieE';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='La serie de medidor ingresda ya se encuentra registrada';
            $selector='txtserieE';
        }
        elseif ($validator3->fails())
        {
            $result='0';
            $msj='Debe de ingresar la fecha de alta del medidor';
            $selector='txtaltaE';
        }
        elseif ($validator5->fails())
        {
            $result='0';
            $msj='Ingrese la lectura anterior del medidor';
            $selector='txtlectura_ultimaE';
        }
        else{
            $registro = Medidor::findOrFail($id);

            $registro->serie=$serie;
            $registro->descripcion=$descripcion;
            $registro->alta=$alta;
            $registro->lectura_ultima=$lectura_ultima;

            $registro->save();

            $msj='Medidor Actualizado con Éxito';
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    public function altabaja(Request $request)
    {
        $id = $request->id;
        $activo = $request->activo;
        $fecha_baja = $request->fecha_baja;

        $result='1';
        $msj='';
        $selector='';

        $input1  = array('fecha_baja' => $fecha_baja);
        $reglas1 = array('fecha_baja' => 'required');

        $validator1 = Validator::make($input1, $reglas1);

        if ($validator1->fails() && intval($activo) == 0)
        {
            $result='0';
            $msj='Debe ingresar la Fecha de Baja del Medidor';
            $selector='txtbajafn';
        }
        else{
            $registro = Medidor::findOrFail($id);
            $registro->activo = $activo;
    
            if($activo == '0'){
                $registro->baja = $fecha_baja;
            }
            else{
                $registro->baja = null;
            }
    
            $registro->save();
    
            if(strval($activo)=="0"){
                $msj='El Medidor fue dado de Baja exitosamente';
            }elseif(strval($activo)=="1"){
                $msj='El Medidor fue dado de Alta exitosamente';
            }
        }

        

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result='1';
        $msj='1';

        $registro = Medidor::findOrFail($id);
        
        $registro->borrado='1';
        $registro->save();

        $msj='Medidor eliminado exitosamente';

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}

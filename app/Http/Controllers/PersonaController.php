<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use Auth;
use DB;

use App\Persona;
use App\Tipouser;
use App\User;


class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index1()
    {
        if(accesoUser([1,2])){


            $idtipouser=Auth::user()->tipouser_id;
            $tipouser=Tipouser::find($idtipouser);


            $modulo="persona";
            return view('persona.index',compact('tipouser','modulo'));
        }
        else
        {
            return redirect('home');           
        }
    }

    public function index2()
    {
        if(accesoUser([1,2,3,4,5])){


            $idtipouser=Auth::user()->tipouser_id;
            $tipouser=Tipouser::find($idtipouser);


            $modulo="reppersonas";
            return view('reppersonas.index',compact('tipouser','modulo'));
        }
        else
        {
            return redirect('home');           
        }
    }


    public function index(Request $request)
    {   
     $buscar=$request->busca;

     $personas = DB::table('personas')
     ->join('tipopersonas', 'tipopersonas.id', '=', 'personas.tipopersona_id')
     ->leftjoin('escuelas', 'escuelas.id', '=', 'personas.escuela_id')
     ->where('personas.borrado','0')
     ->where(function($query) use ($buscar){
        $query->where('personas.nombre','like','%'.$buscar.'%');
        $query->orWhere('personas.dni_ruc','like','%'.$buscar.'%');
        $query->orWhere('personas.codigo_alumno','like','%'.$buscar.'%');
        $query->orWhere('escuelas.nombre','like','%'.$buscar.'%');
        $query->orWhere('tipopersonas.tipo','like','%'.$buscar.'%');
        })
     ->orderBy('personas.nombre')
     ->orderBy('personas.dni_ruc')
     ->select('personas.id','personas.nombre','personas.dni_ruc','personas.codigo_alumno','personas.direccion','personas.escuela_id','personas.tipopersona_id','personas.activo', 'tipopersonas.id as idtip','tipopersonas.tipo','escuelas.nombre as escuela','escuelas.id as idesc')
     ->paginate(30);

     $escuelas=Escuela::where('borrado','0')->where('activo','1')->orderBy('nombre')->get();
     $tipopersonas=Tipopersona::get();

     return [
        'pagination'=>[
            'total'=> $personas->total(),
            'current_page'=> $personas->currentPage(),
            'per_page'=> $personas->perPage(),
            'last_page'=> $personas->lastPage(),
            'from'=> $personas->firstItem(),
            'to'=> $personas->lastItem(),
        ],
        'personas'=>$personas,
        'escuelas'=>$escuelas,
        'tipopersonas'=>$tipopersonas,
    ];
    }


    public function buscarDatosImp(Request $request)
    {   
     $buscar=$request->busca;

     $personas = DB::table('personas')
     ->join('tipopersonas', 'tipopersonas.id', '=', 'personas.tipopersona_id')
     ->leftjoin('escuelas', 'escuelas.id', '=', 'personas.escuela_id')
     ->where('personas.borrado','0')
     ->where(function($query) use ($buscar){
        $query->where('personas.nombre','like','%'.$buscar.'%');
        $query->orWhere('personas.dni_ruc','like','%'.$buscar.'%');
        $query->orWhere('personas.codigo_alumno','like','%'.$buscar.'%');
        $query->orWhere('escuelas.nombre','like','%'.$buscar.'%');
        $query->orWhere('tipopersonas.tipo','like','%'.$buscar.'%');
        })
     ->orderBy('personas.nombre')
     ->orderBy('personas.dni_ruc')
     ->select('personas.id','personas.nombre','personas.dni_ruc','personas.codigo_alumno','personas.direccion','personas.escuela_id','personas.tipopersona_id','personas.activo', 'tipopersonas.id as idtip','tipopersonas.tipo','escuelas.nombre as escuela','escuelas.id as idesc')
     ->get();


     return [

        'dataimp'=>$personas,
    ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function buscarDNI(Request $request)
    {
       $tipoPersona=$request->tipoPersona;
       $tipo_documentoPersona=$request->tipo_documentoPersona;
       $num_documentoPersona=$request->num_documentoPersona;

       $result='1';
       $msj='Complete el Formulario';
       $selector='';
       $idPer="0";
       $persona="";

       $input1  = array('tipoPersona' => $tipoPersona);
       $reglas1 = array('tipoPersona' => 'required');

       $input2  = array('tipo_documentoPersona' => $tipo_documentoPersona);
       $reglas2 = array('tipo_documentoPersona' => 'required');

       $input3  = array('num_documentoPersona' => $num_documentoPersona);
       $reglas3 = array('num_documentoPersona' => 'required');

       $validator1 = Validator::make($input1, $reglas1);
       $validator2 = Validator::make($input2, $reglas2);
       $validator3 = Validator::make($input3, $reglas3);

       if ($validator1->fails())
       {
           $result='0';
           $msj='Seleccione un Tipo de Persona';
           $selector='cbutipoPersona';

       }elseif ($validator2->fails())
       {
           $result='0';
           $msj='Seleccione un Tipo de Documento de Identidad Válido';
           $selector='cbutipo_documentoPersona';

       }
       elseif ($validator3->fails())
       {
           $result='0';
           $msj='Complete un Documento de Identidad Válido (Mínimo 08 caracteres)';
           $selector='txtnum_documentoPersona';

       }
       elseif (strlen($num_documentoPersona)<8)
       {
           $result='0';
           $msj='Complete un Documento de Identidad Válido (Mínimo 08 caracteres)';
           $selector='txtnum_documentoPersona';

       }
       else{

           $personaBuscada=Persona::where('tipo',$tipoPersona)
                                    ->where('tipo_documento',$tipo_documentoPersona)
                                    ->where('num_documento',$num_documentoPersona)
                                    ->where('borrado','0')->get();
           
           foreach ($personaBuscada as $key => $dato) {
               $idPer=$dato->id;
               $result='2';
           }

           $persona=Persona::find($idPer);
       }



       return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector,'idPer'=>$idPer,'persona'=>$persona]);

    }

     public function buscarDocPaciente(Request $request)
     {
        $nro_documento=$request->nro_documento;
        $tipo_documento_paciente_id=$request->tipo_documento_paciente_id;

        $result='0';
        $msj='Complete el Formulario';
        $selector='';
        $idPaciente = 0;
        $paciente="";

        $input1  = array('nro_documento' => $nro_documento);
        $reglas1 = array('nro_documento' => 'required');

        $input2  = array('tipo_documento_paciente_id' => $tipo_documento_paciente_id);
        $reglas2 = array('tipo_documento_paciente_id' => 'required');

        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);


        if ($validator1->fails())
        {
            $result='0';
            $msj='Complete un Documento Válido (Mínimo 08 dígitos)';
            $selector='txtnro_documento';

        }
        elseif ($validator2->fails() || intval($tipo_documento_paciente_id) == 0)
        {
            $result='0';
            $msj='Seleccione un Tipo de Documento';
            $selector='cbutipo_documento_paciente_id';

        }
        elseif (strlen($nro_documento)<8)
        {
            $result='0';
            $msj='Ingrese un Documento válido, mínimo de 08 dígitos';
            $selector='txtnro_documento';

        }
        else{
            $pacienteBuscado=Paciente::where('tipo_documento_paciente_id',$tipo_documento_paciente_id)->where('nro_documento',$nro_documento)->where('borrado','0')->orderBy('id','desc')->get();
            $idPaciente = 0;
            foreach ($pacienteBuscado as $key => $dato) {
                $idPaciente=$dato->id;
                $paciente = $dato;
                $result='1';
                break;
            }
        }



        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector,'idPaciente'=>$idPaciente,'paciente'=>$paciente]);

     }



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
        $nombre=$request->nombre;
        $dni_ruc=$request->dni_ruc;
        $codigo_alumno=$request->codigo_alumno;
        $direccion=$request->direccion;
        $activo=$request->activo;
        $escuela_id=$request->escuela_id;
        $tipopersona_id=$request->tipopersona_id;

        if($escuela_id=="0"){
            $escuela_id=null;
        }



        $result='1';
        $msj='';
        $selector='';

        $input1  = array('nombre' => $nombre);
        $reglas1 = array('nombre' => 'required');

       /* $input2  = array('nombre' => $nombre);
        $reglas2 = array('nombre' => 'unique:escuelas,nombre'.',1,borrado');*/

        $input2  = array('dni_ruc' => $dni_ruc);
        $reglas2 = array('dni_ruc' => 'required');


        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);


        if($tipopersona_id==0){
            $result='0';
            $msj='Seleccione el tipo de Persona';
            $selector='cbstipopersona';
        }
        elseif ($validator1->fails())
        {
            $result='0';
            $msj='Complete el nombre de la Persona';
            $selector='txtnom';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Ingrese el DNI o RUC de la Persona';
            $selector='txtdni';
        }
       
        else{

            $newPersona = new Persona();
            $newPersona->nombre=$nombre;
            $newPersona->dni_ruc=$dni_ruc;
            $newPersona->codigo_alumno=$codigo_alumno;
            $newPersona->direccion=$direccion;
            $newPersona->activo=$activo;
            $newPersona->borrado='0';
            $newPersona->escuela_id=$escuela_id;
            $newPersona->tipopersona_id=$tipopersona_id;

            $newPersona->save();

            $msj='Nueva Persona registrada con éxito';
        }




       //Areaunasam::create($request->all());

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
        $nombre=$request->nombre;
        $dni_ruc=$request->dni_ruc;
        $codigo_alumno=$request->codigo_alumno;
        $direccion=$request->direccion;
        $activo=$request->activo;
        $escuela_id=$request->escuela_id;
        $tipopersona_id=$request->tipopersona_id;

        if($escuela_id=="0"){
            $escuela_id=null;
        }



        $result='1';
        $msj='';
        $selector='';

        $input1  = array('nombre' => $nombre);
        $reglas1 = array('nombre' => 'required');

       /* $input2  = array('nombre' => $nombre);
        $reglas2 = array('nombre' => 'unique:escuelas,nombre'.',1,borrado');*/

        $input2  = array('dni_ruc' => $dni_ruc);
        $reglas2 = array('dni_ruc' => 'required');


        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);


        if($tipopersona_id==0){
            $result='0';
            $msj='Seleccione el tipo de Persona';
            $selector='cbstipopersonaE';
        }
        elseif ($validator1->fails())
        {
            $result='0';
            $msj='Complete el nombre de la Persona';
            $selector='txtnomE';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Ingrese el DNI o RUC de la Persona';
            $selector='txtdniE';
        }
       
        else{

            $newPersona =Persona::findOrFail($id);
            $newPersona->nombre=$nombre;
            $newPersona->dni_ruc=$dni_ruc;
            $newPersona->codigo_alumno=$codigo_alumno;
            $newPersona->direccion=$direccion;
            $newPersona->activo=$activo;
            $newPersona->escuela_id=$escuela_id;
            $newPersona->tipopersona_id=$tipopersona_id;

            $newPersona->save();

            $msj='Nueva Persona registrada con éxito';
        }




       //Areaunasam::create($request->all());

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }


    public function altabaja($id,$activo)
    {
        $result='1';
        $msj='';
        $selector='';

        $update = Persona::findOrFail($id);
        $update->activo=$activo;
        $update->save();

        if(strval($activo)=="0"){
            $msj='La Persona fue Desactivada exitosamente';
        }elseif(strval($activo)=="1"){
            $msj='La Persona fue Activada exitosamente';
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

        $consulta1=DB::table('recibos')
                    ->join('personas', 'recibos.persona_id', '=', 'personas.id')
                    ->where('personas.id',$id)->count();



        if($consulta1>0) {
            $result='0';
            $msj='La Persona Seleccionada no se puede eliminar debido a que cuenta con registros de Recibos registrados en ella';
        }else{
        
        $borrar = Persona::findOrFail($id);
        //$task->delete();

        $borrar->borrado='1';

        $borrar->save();

        $msj='Persona eliminada exitosamente';
     }

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }

    public function obtenerDatos()
    {   


     $autores = DB::table('personas')

     ->where('personas.borrado','0')

     ->orderBy('personas.apellidopat')
     ->orderBy('personas.apellidomat')
     ->orderBy('personas.nombres')
     ->groupBy('personas.doc')
     ->select('personas.id','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono')->get();


     return [
        'autores'=>$autores
    ];
    }

    public function obtenerAutors($id)
    {   


     $autoresRegis = DB::table('personas')
     ->join('autors', 'personas.id', '=', 'autors.persona_id')
     ->join('revistaspublicacions', 'revistaspublicacions.id', '=', 'autors.revistaspublicacion_id')
     ->where('autors.borrado','0')
     ->where('revistaspublicacions.id',$id)

     ->orderBy('personas.apellidopat')
     ->orderBy('personas.apellidomat')
     ->orderBy('personas.nombres')
     ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono','autors.id','autors.cargo','autors.persona_id','autors.revistaspublicacion_id')->get();


     return [
        'autoresRegis'=>$autoresRegis
    ];
    }


}

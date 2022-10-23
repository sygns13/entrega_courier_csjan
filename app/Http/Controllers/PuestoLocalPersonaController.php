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
use App\Persona;

use stdClass;
use DB;
use Storage;
set_time_limit(600);

class PuestoLocalPersonaController extends Controller
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

            $modulo="cliente";

            return view('cliente.index',compact('tipouser','modulo','zonas','puesto'));
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

        $registros = DB::table('puesto_local_personas')
     ->join('puesto_locals', 'puesto_locals.id', '=', 'puesto_local_personas.puesto_local_id')
     ->join('personas', 'personas.id', '=', 'puesto_local_personas.persona_id')
     ->leftJoin('users',  function($join) {
        $join->on('puesto_local_personas.user_id', '=', 'users.id');
    })
     /* ->leftjoin('escuelas', 'escuelas.id', '=', 'personals.escuela_id') */
     ->where('puesto_locals.id', $puesto_local_id)
     ->where('puesto_local_personas.borrado','0')
     ->where(function($query) use ($buscar){
        /* $query->where('personas.tipo_documento','like','%'.$buscar.'%'); */
        $query->Where('personas.num_documento','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidos','like','%'.$buscar.'%');
        $query->orWhere('personas.nombres','like','%'.$buscar.'%');
        $query->orWhere('personas.email','like','%'.$buscar.'%');
        })
     ->orderBy('puesto_local_personas.id')
     ->select('puesto_local_personas.id',
                'puesto_local_personas.vinculo',
                'puesto_local_personas.persona_id',
                'puesto_local_personas.puesto_local_id',
                'puesto_local_personas.inicio',
                'puesto_local_personas.final',
                'puesto_local_personas.activo',
                'puesto_local_personas.borrado',
                'puesto_local_personas.created_at',
                'puesto_local_personas.updated_at',
                'personas.id as idPersona',
                'personas.tipo as tipoPersona',
                'personas.tipo_documento as tipo_documentoPersona',
                'personas.num_documento as num_documentoPersona',
                'personas.apellidos as apellidosPersona',
                'personas.nombres as nombresPersona',
                'personas.telefono as telefonoPersona',
                'personas.direccion as direccionPersona',
                'personas.email as emailPersona',
                'personas.activo as activoPersona',
                'personas.borrado as borradoPersona',
                'personas.created_at as created_atPersona',
                'personas.updated_at as updated_atPersona',

                DB::Raw("IFNULL( `users`.`id` , '0' ) as idUsers"),
                DB::Raw("IFNULL( `users`.`name` , '' ) as name"),
                DB::Raw("IFNULL( `users`.`email` , '0' ) as email"),
                )
     ->paginate(30);

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

        $vinculo = $request->vinculo;
        $persona_id = $request->persona_id;
        $puesto_local_id = $request->puesto_local_id;
        $inicio = $request->inicio;
        $final = $request->final;
        $tipoPersona = $request->tipoPersona;
        $tipo_documentoPersona = $request->tipo_documentoPersona;
        $num_documentoPersona = $request->num_documentoPersona;
        $apellidosPersona = $request->apellidosPersona;
        $nombresPersona = $request->nombresPersona;
        $telefonoPersona = $request->telefonoPersona;
        $direccionPersona = $request->direccionPersona;
        $emailPersona = $request->emailPersona;
        $activo = $request->activo;

        $name=$request->name;
        $password=$request->password;

        if($tipoPersona == '2'){
            $apellidosPersona = '';
        }

        if($telefonoPersona == null){
            $telefonoPersona = '';
        }

        if($direccionPersona == null){
            $direccionPersona = '';
        }

        $result = '1';
        $msj = '';
        $selector = '';

        $input1  = array('tipoPersona' => $tipoPersona);
        $reglas1 = array('tipoPersona' => 'required');
        
        $input2  = array('num_documentoPersona' => $num_documentoPersona);
        $reglas2 = array('num_documentoPersona' => 'required');
        
        $input3  = array('apellidosPersona' => $apellidosPersona);
        $reglas3 = array('apellidosPersona' => 'required');
        
        $input4  = array('nombresPersona' => $nombresPersona);
        $reglas4 = array('nombresPersona' => 'required');
        
        $input5  = array('emailPersona' => $emailPersona);
        $reglas5 = array('emailPersona' => 'required');

        $input6  = array('puesto_local_id' => $puesto_local_id);
        $reglas6 = array('puesto_local_id' => 'required');
        
        $input7  = array('tipo_documentoPersona' => $tipo_documentoPersona);
        $reglas7 = array('tipo_documentoPersona' => 'required');

        $regla02=User::where('name',$name)->where('borrado','0')->count();
        $regla03=User::where('email',$emailPersona)->where('borrado','0')->count();

        $input8  = array('name' => $name);
        $reglas8 = array('name' => 'required');

        $input9  = array('password' => $password);
        $reglas9 = array('password' => 'required');

        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);
        $validator5 = Validator::make($input5, $reglas5);
        $validator6 = Validator::make($input6, $reglas6);
        $validator7 = Validator::make($input7, $reglas7);
        $validator8 = Validator::make($input8, $reglas8);
        $validator9 = Validator::make($input9, $reglas9);

        if ($validator1->fails())
        {
            $result='0';
            $msj='Debe ingresar el tipo de persona';
            $selector='cbutipoPersona';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='Debe ingresar el número de documento de identidad del Cliente';
            $selector='txtnum_documentoPersona';
        }
        elseif ($validator3->fails() && $tipoPersona == '1')
        {
            $result='0';
            $msj='Debe de ingresar los apellidos del Cliente';
            $selector='txtapellidosPersona';
        }
        elseif ($validator4->fails() && $tipoPersona == '1')
        {
            $result='0';
            $msj='Debe de ingresar los nombres del Cliente';
            $selector='txtnombresPersona';
        }
        elseif ($validator4->fails() && $tipoPersona == '2')
        {
            $result='0';
            $msj='Debe de ingresar la Razón Social del Cliente';
            $selector='txtnombresPersona';
        }
        elseif ($validator6->fails())
        {
            $result='0';
            $msj='Debe de seleccionar el puesto/local del cliente';
            $selector='cbupuesto_local_id';
        }
        elseif ($validator7->fails())
        {
            $result='0';
            $msj='Debe de seleccionar el tipo de documento del cliente';
            $selector='cbutipo_documentoPersona';
        }
        elseif($regla02>0){
            $result='0';
            $msj='Ya se encuentra registrado un Usuario con el Username ingresado';
            $selector='txtname';
        }
        elseif($regla03>0){
            $result='0';
            $msj='Ya se encuentra registrado un email con el Username ingresado';
            $selector='txtemail';
        }
        elseif ($validator8->fails()) {
            $result='0';
            $msj='Ingrese el Username del Usuario';
            $selector='txtname';
        }
        elseif ($validator9->fails()) {
            $result='0';
            $msj='Ingrese el Password del usuario';
            $selector='txtpassword';
        }
        else{

            if(intval($persona_id)!=0)
            {
                $editPersona =Persona::find($persona_id);

                if($editPersona->tipo_documento != $tipo_documentoPersona ||
                    $editPersona->num_documento != $num_documentoPersona ||
                    $editPersona->tipo != $tipoPersona
                ){
                    $newPersona = new Persona();
                    $newPersona->tipo=$tipoPersona;
                    $newPersona->tipo_documento=$tipo_documentoPersona;
                    $newPersona->num_documento=$num_documentoPersona;
                    $newPersona->apellidos=$apellidosPersona;
                    $newPersona->nombres=$nombresPersona;
                    $newPersona->telefono=$telefonoPersona;
                    $newPersona->direccion=$direccionPersona;
                    $newPersona->email=$emailPersona;
                    $newPersona->activo='1';
                    $newPersona->borrado='0';

                    $newPersona->save();

                    $persona_id=$newPersona->id;
                }
                else{
                    $editPersona->tipo=$tipoPersona;
                    $editPersona->tipo_documento=$tipo_documentoPersona;
                    $editPersona->num_documento=$num_documentoPersona;
                    $editPersona->apellidos=$apellidosPersona;
                    $editPersona->nombres=$nombresPersona;
                    $editPersona->telefono=$telefonoPersona;
                    $editPersona->direccion=$direccionPersona;
                    $editPersona->email=$emailPersona;
    
                    $editPersona->save();
                } 
            }
            else{
                $newPersona = new Persona();
                $newPersona->tipo=$tipoPersona;
                $newPersona->tipo_documento=$tipo_documentoPersona;
                $newPersona->num_documento=$num_documentoPersona;
                $newPersona->apellidos=$apellidosPersona;
                $newPersona->nombres=$nombresPersona;
                $newPersona->telefono=$telefonoPersona;
                $newPersona->direccion=$direccionPersona;
                $newPersona->email=$emailPersona;
                $newPersona->activo='1';
                $newPersona->borrado='0';

                $newPersona->save();

                $persona_id=$newPersona->id;
            }


            $newUser = new User();
            $newUser->name=$name;
            $newUser->email=$emailPersona;
            $newUser->password=bcrypt($password);
            $newUser->persona_id=$persona_id;
            $newUser->tipo_user_id= '5';
            $newUser->activo=$activo;
            $newUser->borrado='0'; 

            $newUser->save();


            $registro = new PuestoLocalPersona;

            $registro->vinculo=$vinculo;
            $registro->persona_id=$persona_id;
            $registro->puesto_local_id=$puesto_local_id;
            $registro->tipo=$tipoPersona;
            $registro->activo=$activo;
            $registro->borrado='0';
            $registro->user_id=$newUser->id;

            $registro->save();

            $msj='Nuevo Cliente Registrado con Éxito';
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

        $vinculo = $request->vinculo;
        $persona_id = $request->persona_id;
        $inicio = $request->inicio;
        $final = $request->final;
        $tipoPersona = $request->tipoPersona;
        $tipo_documentoPersona = $request->tipo_documentoPersona;
        $num_documentoPersona = $request->num_documentoPersona;
        $apellidosPersona = $request->apellidosPersona;
        $nombresPersona = $request->nombresPersona;
        $telefonoPersona = $request->telefonoPersona;
        $direccionPersona = $request->direccionPersona;
        $emailPersona = $request->emailPersona;
        $activo = $request->activo;

        $idUsers=$request->idUsers;
        $name=$request->name;
        $modifpassword=$request->modifpassword;
        $password=$request->password;

        if($tipoPersona == '2'){
            $apellidosPersona = '';
        }

        if($telefonoPersona == null){
            $telefonoPersona = '';
        }

        if($direccionPersona == null){
            $direccionPersona = '';
        }

        $result = '1';
        $msj = '';
        $selector = '';

        $input1  = array('tipoPersona' => $tipoPersona);
        $reglas1 = array('tipoPersona' => 'required');
        
        $input2  = array('num_documentoPersona' => $num_documentoPersona);
        $reglas2 = array('num_documentoPersona' => 'required');
        
        $input3  = array('apellidosPersona' => $apellidosPersona);
        $reglas3 = array('apellidosPersona' => 'required');
        
        $input4  = array('nombresPersona' => $nombresPersona);
        $reglas4 = array('nombresPersona' => 'required');
        
        $input5  = array('emailPersona' => $emailPersona);
        $reglas5 = array('emailPersona' => 'required');
        
        $input7  = array('tipo_documentoPersona' => $tipo_documentoPersona);
        $reglas7 = array('tipo_documentoPersona' => 'required');

        $regla02=User::where('name',$name)->where('users.id','<>',$idUsers)->where('borrado','0')->count();
        $regla03=User::where('email',$emailPersona)->where('users.id','<>',$idUsers)->where('borrado','0')->count();

        $input8  = array('name' => $name);
        $reglas8 = array('name' => 'required');

        $input9  = array('password' => $password);
        $reglas9 = array('password' => 'required');

        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);
        $validator5 = Validator::make($input5, $reglas5);
        $validator7 = Validator::make($input7, $reglas7);
        $validator8 = Validator::make($input8, $reglas8);
        $validator9 = Validator::make($input9, $reglas9);

        if ($validator1->fails())
        {
            $result='0';
            $msj='Debe ingresar el tipo de persona';
            $selector='cbutipoPersonaE';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='Debe ingresar el número de documento de identidad del Cliente';
            $selector='txtnum_documentoPersonaE';
        }
        elseif ($validator3->fails() && $tipoPersona == '1')
        {
            $result='0';
            $msj='Debe de ingresar los apellidos del Cliente';
            $selector='txtapellidosPersonaE';
        }
        elseif ($validator4->fails() && $tipoPersona == '1')
        {
            $result='0';
            $msj='Debe de ingresar los nombres del Cliente';
            $selector='txtnombresPersonaE';
        }
        elseif ($validator4->fails() && $tipoPersona == '2')
        {
            $result='0';
            $msj='Debe de ingresar la Razón Social del Cliente';
            $selector='txtnombresPersonaE';
        }
        elseif ($validator7->fails())
        {
            $result='0';
            $msj='Debe de seleccionar el tipo de documento del cliente';
            $selector='cbutipo_documentoPersonaE';
        }
        elseif($regla02>0){
            $result='0';
            $msj='Ya se encuentra registrado un Usuario con el Username ingresado';
            $selector='txtnameE';
        }
        elseif($regla03>0){
            $result='0';
            $msj='Ya se encuentra registrado un email con el Username ingresado';
            $selector='txtemailE';
        }
        elseif ($validator8->fails()) {
            $result='0';
            $msj='Ingrese el Username del Usuario';
            $selector='txtnameE';
        }
        elseif ($validator9->fails() && intval($modifpassword)==1) {
            $result='0';
            $msj='Ingrese el Password del usuario';
            $selector='txtpasswordE';
        }
        else{

            if(intval($persona_id)!=0)
            {
                $editPersona =Persona::find($persona_id);

                if($editPersona->tipo_documento != $tipo_documentoPersona ||
                    $editPersona->num_documento != $num_documentoPersona ||
                    $editPersona->tipo != $tipoPersona
                ){
                    $newPersona = new Persona();
                    $newPersona->tipo=$tipoPersona;
                    $newPersona->tipo_documento=$tipo_documentoPersona;
                    $newPersona->num_documento=$num_documentoPersona;
                    $newPersona->apellidos=$apellidosPersona;
                    $newPersona->nombres=$nombresPersona;
                    $newPersona->telefono=$telefonoPersona;
                    $newPersona->direccion=$direccionPersona;
                    $newPersona->email=$emailPersona;
                    $newPersona->activo='1';
                    $newPersona->borrado='0';

                    $newPersona->save();

                    $persona_id=$newPersona->id;
                }
                else{
                    $editPersona->tipo=$tipoPersona;
                    $editPersona->tipo_documento=$tipo_documentoPersona;
                    $editPersona->num_documento=$num_documentoPersona;
                    $editPersona->apellidos=$apellidosPersona;
                    $editPersona->nombres=$nombresPersona;
                    $editPersona->telefono=$telefonoPersona;
                    $editPersona->direccion=$direccionPersona;
                    $editPersona->email=$emailPersona;
    
                    $editPersona->save();
                } 
            }
            else{
                $newPersona = new Persona();
                $newPersona->tipo=$tipoPersona;
                $newPersona->tipo_documento=$tipo_documentoPersona;
                $newPersona->num_documento=$num_documentoPersona;
                $newPersona->apellidos=$apellidosPersona;
                $newPersona->nombres=$nombresPersona;
                $newPersona->telefono=$telefonoPersona;
                $newPersona->direccion=$direccionPersona;
                $newPersona->email=$emailPersona;
                $newPersona->activo='1';
                $newPersona->borrado='0';

                $newPersona->save();

                $persona_id=$newPersona->id;
            }

            if($idUsers !='0'){

                if(intval($modifpassword)==1){
                    $newUser = User::find($idUsers);
                    $newUser->name=$name;
                    $newUser->email=$emailPersona;
                    $newUser->persona_id=$persona_id;
                    $newUser->tipo_user_id= '5';
                    $newUser->activo=$activo;
                    $newUser->password=bcrypt($password);
    
                    $newUser->save();
    
                }
                else{
                    $newUser = User::find($idUsers);
                    $newUser->name=$name;
                    $newUser->email=$emailPersona;
                    $newUser->persona_id=$persona_id;
                    $newUser->tipo_user_id= '5';
                    $newUser->activo=$activo;
    
                    $newUser->save();    
                }

            }else{
                $newUser = new User();
                $newUser->name=$name;
                $newUser->email=$emailPersona;
                $newUser->password=bcrypt($password);
                $newUser->persona_id=$persona_id;
                $newUser->tipo_user_id= '5';
                $newUser->activo=$activo;
                $newUser->borrado='0'; 

                $newUser->save();

                $idUsers = $newUser->id;
            }

            $registro = PuestoLocalPersona::find($id);

            $registro->vinculo=$vinculo;
            $registro->persona_id=$persona_id;
            $registro->tipo=$tipoPersona;
            $registro->activo=$activo;
            $registro->user_id=$idUsers;

            $registro->save();

            $msj='Cliente Modificado con Éxito';
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function altabaja(Request $request)
    {
        $id = $request->id;
        $idUsers = $request->idUsers;
        $activo = $request->activo;

        $result='1';
        $msj='';
        $selector='';

        if($idUsers != '0'){
            $updateUsuario = User::findOrFail($idUsers);
            $updateUsuario->activo=$activo;
            $updateUsuario->save();
        }

        $registro = PuestoLocalPersona::findOrFail($id);
        $registro->activo = $activo;

        $registro->save();

        if(strval($activo)=="0"){
            $msj='El Cliente fue dado de Baja exitosamente';
        }elseif(strval($activo)=="1"){
            $msj='El Cliente fue dado de Alta exitosamente';
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }


    public function destroy($id)
    {
        $result='1';
        $msj='1';

        $registro = PuestoLocalPersona::findOrFail($id);
        
        $registro->borrado='1';
        $registro->save();

        $msj='Cliente eliminado exitosamente';

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}

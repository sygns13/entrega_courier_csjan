<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;

use App\Oficina;
use App\Trabajador;
use App\Persona;
use App\Tipouser;
use App\User;
use App\Cargo;
use App\Permiso;
use App\UserPermiso;

use App\Exports\Reporte1Export;
use Maatwebsite\Excel\Facades\Excel;


use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator as LaravelValidator;

use stdClass;


class UserController extends Controller     
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


            $modulo="usuario";
            //$tipo_users=Tipouser::orderBy('id')->where('borrado','0')->get();
            $oficinas=Oficina::orderBy('id')->where('borrado','0')->get();

            $tipo_users=Tipouser::orderBy('id')->where('borrado','0')->get();

            $permisos = Permiso::orderBy('id')->get();


            return view('usuario.index',compact('tipouser','modulo','tipo_users','oficinas','permisos'));
        }
        else
        {
            return redirect('home');    
        }
    }

    public function index2()
    {
        if(accesoUser([1,2,3,4,5])){


            $idtipouser=Auth::user()->tipo_user_id;
            $tipouser=Tipouser::find($idtipouser);
            $permisos = Permiso::orderBy('id')->get();


            $modulo="miperfil";
            return view('miperfil.index',compact('tipouser','modulo','permisos'));
        }
        else
        {
            return redirect('home');           
        }
    }

    public function index3()
    {
        if(accesoUser([1,2,3])){

            $idtipouser=Auth::user()->tipo_user_id;
            $tipouser=Tipouser::find($idtipouser);
            $tipo_users=Tipouser::orderBy('id')->where('borrado','0')->where('id','>','1')->where('id','<','5')->get();
            $permisos = Permiso::orderBy('id')->get();

            $modulo="reporte1";
            return view('reporte1.index',compact('tipouser','modulo','tipo_users','permisos'));
        }
        else
        {
            return redirect('home');           
        }
    }

    public function index(Request $request)
    {
        $buscar=$request->busca;

        $usuarios = DB::table('users')
        ->join('tipo_users', 'tipo_users.id', '=', 'users.tipo_user_id')
        ->join('personas', 'personas.id', '=', 'users.persona_id')
        ->join('trabajadors', 'users.id', '=', 'trabajadors.user_id')
        ->join('oficinas', 'oficinas.id', '=', 'trabajadors.oficina_id')

        ->where('users.borrado','0')
        ->where(function($query) use ($buscar){
            $query->Where('users.name','like','%'.$buscar.'%');
            $query->orWhere('users.email','like','%'.$buscar.'%');
            $query->orWhere('personas.num_documento','like','%'.$buscar.'%');
            $query->orWhere('personas.apellidos','like','%'.$buscar.'%');
            $query->orWhere('personas.nombres','like','%'.$buscar.'%');
            $query->orWhere('tipo_users.nombre','like','%'.$buscar.'%');
            $query->orWhere('trabajadors.cargo','like','%'.$buscar.'%');
            $query->orWhere('oficinas.nombre','like','%'.$buscar.'%');
            }) 
         ->orderBy('tipo_users.id')
        ->orderBy('users.name')
        ->orderBy('personas.nombres')
        ->orderBy('personas.apellidos')
        ->select('users.id as id','users.name','users.email','users.activo','users.borrado','users.persona_id','users.tipo_user_id',
        
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

        'tipo_users.nombre as tipouser',

        'trabajadors.id as idTrabajador',
        'trabajadors.cargo as cargoTrabajador',
        'trabajadors.oficina_id as oficina_idTrabajador',
        'oficinas.nombre as nombreOficina'
         )
        ->paginate(30);

        foreach ($usuarios as $key => $value) {
            $permisosUsuario =  DB::table('permisos')
            ->join('user_permisos', 'permisos.id', '=', 'user_permisos.permiso_id')
            ->where('user_permisos.user_id',$value->id)
            ->orderBy('permisos.id')
            ->select('permisos.id as id','permisos.codigo_form','permisos.descripcion',
        
            'user_permisos.permiso_id as permiso_id',
            'user_permisos.id as idUserPermiso',
            'user_permisos.user_id as user_id'
             )
            ->get();

            $value->permisosUsuario = $permisosUsuario;
        }

          return [
            'pagination'=>[
                'total'=> $usuarios->total(),
                'current_page'=> $usuarios->currentPage(),
                'per_page'=> $usuarios->perPage(),
                'last_page'=> $usuarios->lastPage(),
                'from'=> $usuarios->firstItem(),
                'to'=> $usuarios->lastItem(),
            ],
            'usuarios'=>$usuarios
        ];
    }

    public function buscarDatos(Request $request)
    {
        $fechaRegistro=$request->fechaRegistro;
        $nombres=$request->nombres;
        $apellidos=$request->apellidos;
        $tipo_user_id=$request->tipo_user_id;
        $tipoUsuario=$request->tipoUsuario;

        $buscar="";

        $query = DB::table('users')
        ->join('tipo_users', 'tipo_users.id', '=', 'users.tipo_user_id')
        ->join('personas', 'personas.id', '=', 'users.persona_id')
        ->join('trabajadors', 'users.id', '=', 'trabajadors.user_id')
        ->join('oficinas', 'oficinas.id', '=', 'trabajadors.oficina_id')

        ->where('users.borrado','0')
        /* ->where(function($query) use ($buscar){
            $query->Where('users.name','like','%'.$buscar.'%');
            $query->orWhere('users.email','like','%'.$buscar.'%');
            $query->orWhere('personas.num_documento','like','%'.$buscar.'%');
            $query->orWhere('personas.apellidos','like','%'.$buscar.'%');
            $query->orWhere('personas.nombres','like','%'.$buscar.'%');
            $query->orWhere('tipo_users.nombre','like','%'.$buscar.'%');
            $query->orWhere('trabajadors.cargo','like','%'.$buscar.'%');
            $query->orWhere('oficinas.nombre','like','%'.$buscar.'%');
            })  */
         ->orderBy('tipo_users.id')
        ->orderBy('users.name')
        ->orderBy('personas.nombres')
        ->orderBy('personas.apellidos')
        ->select('users.id as id','users.name','users.email','users.activo','users.borrado','users.persona_id','users.tipo_user_id', 'users.created_at',
        
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

        'tipo_users.nombre as tipouser',

        'trabajadors.id as idTrabajador',
        'trabajadors.cargo as cargoTrabajador',
        'trabajadors.oficina_id as oficina_idTrabajador',
        'oficinas.nombre as nombreOficina'
        );

        if($fechaRegistro != null && $fechaRegistro != ""){
            $query->whereRaw('date(users.created_at) = ?', [$fechaRegistro]);
        }
        if($nombres != null && trim($nombres, " ") != ""){
            $query->where('personas.nombres','like','%'.$nombres.'%');
        }
        if($apellidos != null && trim($apellidos, " ") != ""){
            $query->where('personas.apellidos','like','%'.$apellidos.'%');
        }
        if($tipo_user_id != null && $tipo_user_id != "0"){
            $query->where('tipo_users.id','=',$tipo_user_id);
        }

        $registros=$query->paginate(50);


        foreach ($registros as $key => $value) {
            $permisosUsuario =  DB::table('permisos')
            ->join('user_permisos', 'permisos.id', '=', 'user_permisos.permiso_id')
            ->where('user_permisos.user_id',$value->id)
            ->orderBy('permisos.id')
            ->select('permisos.id as id','permisos.codigo_form','permisos.descripcion',
        
            'user_permisos.permiso_id as permiso_id',
            'user_permisos.id as idUserPermiso',
            'user_permisos.user_id as user_id'
             )
            ->get();

            $value->permisosUsuario = $permisosUsuario;
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
            'registros'=>$registros,
        ];
    }


    public function buscarDatosImp(Request $request)
    {
        $fechaRegistro=$request->fechaRegistro;
        $nombres=$request->nombres;
        $apellidos=$request->apellidos;
        $tipo_user_id=$request->tipo_user_id;
        $tipoUsuario=$request->tipoUsuario;

        $buscar="";

        $query = DB::table('users')
        ->join('tipo_users', 'tipo_users.id', '=', 'users.tipo_user_id')
        ->join('personas', 'personas.id', '=', 'users.persona_id')
        ->join('trabajadors', 'users.id', '=', 'trabajadors.user_id')
        ->join('oficinas', 'oficinas.id', '=', 'trabajadors.oficina_id')

        ->where('tipo_users.id','>','1')
        ->where('tipo_users.id','<','5')
        ->where('users.borrado','0')
        /* ->where(function($query) use ($buscar){
            $query->Where('users.name','like','%'.$buscar.'%');
            $query->orWhere('users.email','like','%'.$buscar.'%');
            $query->orWhere('personas.num_documento','like','%'.$buscar.'%');
            $query->orWhere('personas.apellidos','like','%'.$buscar.'%');
            $query->orWhere('personas.nombres','like','%'.$buscar.'%');
            $query->orWhere('tipo_users.nombre','like','%'.$buscar.'%');
            $query->orWhere('trabajadors.cargo','like','%'.$buscar.'%');
            $query->orWhere('oficinas.nombre','like','%'.$buscar.'%');
            })  */
         ->orderBy('tipo_users.id')
        ->orderBy('users.name')
        ->orderBy('personas.nombres')
        ->orderBy('personas.apellidos')
        ->select('users.id as id','users.name','users.email','users.activo','users.borrado','users.persona_id','users.tipo_user_id', 'users.created_at',
        
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

        'tipo_users.nombre as tipouser',

        'trabajadors.id as idTrabajador',
        'trabajadors.cargo as cargoTrabajador',
        'trabajadors.oficina_id as oficina_idTrabajador',
        'oficinas.nombre as nombreOficina'
        );

        if($fechaRegistro != null && $fechaRegistro != ""){
            $query->whereRaw('date(users.created_at) = ?', [$fechaRegistro]);
        }
        if($nombres != null && trim($nombres, " ") != ""){
            $query->where('personas.nombres','like','%'.$nombres.'%');
        }
        if($apellidos != null && trim($apellidos, " ") != ""){
            $query->where('personas.apellidos','like','%'.$apellidos.'%');
        }
        if($tipo_user_id != null && $tipo_user_id != "0"){
            $query->where('tipo_users.id','=',$tipo_user_id);
        }

        $registrosimp=$query->get();

        foreach ($registrosimp as $key => $value) {
            $permisosUsuario =  DB::table('permisos')
            ->join('user_permisos', 'permisos.id', '=', 'user_permisos.permiso_id')
            ->where('user_permisos.user_id',$value->id)
            ->orderBy('permisos.id')
            ->select('permisos.id as id','permisos.codigo_form','permisos.descripcion',
        
            'user_permisos.permiso_id as permiso_id',
            'user_permisos.id as idUserPermiso',
            'user_permisos.user_id as user_id'
             )
            ->get();

            $value->permisosUsuario = $permisosUsuario;
        }

        return [
            'registrosimp'=>$registrosimp,
        ];


    }



    public function miperfil(Request $request)
    {

        $idtipouser=Auth::user()->tipo_user_id;

         $usuario = DB::table('users')
        ->join('tipo_users', 'tipo_users.id', '=', 'users.tipo_user_id')
        ->join('personas', 'personas.id', '=', 'users.persona_id')
        ->join('trabajadors', 'users.id', '=', 'trabajadors.user_id')
        ->join('oficinas', 'oficinas.id', '=', 'trabajadors.oficina_id')

        ->where('users.id',Auth::user()->id)
        ->select('users.id as id','users.name','users.email','users.activo','users.borrado','users.persona_id','users.tipo_user_id',
        
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

        'tipo_users.nombre as tipouser',

        'trabajadors.id as idTrabajador',
        'trabajadors.cargo as cargoTrabajador',
        'trabajadors.oficina_id as oficina_idTrabajador',
        'oficinas.nombre as nombreOficina',

        DB::Raw("'0' as idPuesto_locals"),
        DB::Raw("'' as nombrePuesto_locals"),
        DB::Raw("'' as numeroPuesto_locals"),
        
         )
         ->first();

         if($usuario){
            $permisosUsuario =  DB::table('permisos')
            ->join('user_permisos', 'permisos.id', '=', 'user_permisos.permiso_id')
            ->where('user_permisos.user_id',$usuario->id)
            ->orderBy('permisos.id')
            ->select('permisos.id as id','permisos.codigo_form','permisos.descripcion',
        
            'user_permisos.permiso_id as permiso_id',
            'user_permisos.id as idUserPermiso',
            'user_permisos.user_id as user_id'
                )
            ->get();

            $usuario->permisosUsuario = $permisosUsuario;
         }
        

        


        return [
            'usuario'=>$usuario
        ];
    }

    public function modificarclave(Request $request)
    {
        $result='1';
        $msj='';
        $selector='';

        $pswa=$request->pswa;
        $pswn1=$request->pswn1;
        $pswn2=$request->pswn2;

        $iduser=Auth::user()->id;
     

        $input1  = array('clave' => $pswa);
        $reglas1 = array('clave' => 'required');

        $input2  = array('ncalve1' => $pswn1);
        $reglas2 = array('ncalve1' => 'required');

        $input3  = array('ncalve2' => $pswn2);
        $reglas3 = array('ncalve2' => 'required');



        //$input6  = array('carrera' => $newCarrerasunasam);
       // $reglas6 = array('carrera' => 'required');

        // Segunda Carrera OP chekiar $newcarrera_id2

         $validator1 = Validator::make($input1, $reglas1);
         $validator2 = Validator::make($input2, $reglas2);
         $validator3 = Validator::make($input3, $reglas3);


          if ($validator1->fails())
        {
            $result='0';
            $msj='Ingrese la Contraseña Actual de la Cuenta';
            $selector='txtdato2';
        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Ingrese la Nueva Contraseña de la Cuenta';
            $selector='txtdato3';
        }elseif ($validator3->fails()) {
            $result='0';
            $msj='Ingrese nuevamente la Nueva Contraseña de la Cuenta';
            $selector='txtdato4';
        }elseif (!Hash::check($pswa, Auth::user()->password)) {
            $result='0';
            $msj='La Contraseña Actual Ingresada No es Correcta, Ingrése una Contraseña Correcta';
            $selector='txtdato2';
        }elseif (strval($pswn1)!=strval($pswn2)) {
            $result='0';
            $msj='Las Nuevas Contraseñas Indicadas son Diferentes, Por favor Ingrese Correctamente las Contraseñas';
            $selector='txtdato3';
        }elseif (Hash::check($pswn1, Auth::user()->password)) {
            $result='0';
            $msj='La Contraseña Actual y La Nueva Contraseña Son Iguales, Debe Ingresar una Nueva Contraseña Diferente';
            $selector='txtdato3';
        }
        else{

            $editUser = User::findOrFail($iduser);
            $editUser->password=bcrypt($pswn1);          
            $editUser->save();


            $msj='Contraseña de Usuario modificado con éxito';
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
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
        $result='1';
        $msj='';
        $selector='';

        $name=$request->name;
        $email=$request->email;
        $activo=$request->activo;
        $persona_id=$request->persona_id;
        $tipo_user_id=$request->tipo_user_id;
        $password=$request->password;

        $cargoTrabajador=$request->cargoTrabajador;
        $oficina_idTrabajador=$request->oficina_idTrabajador;

        $tipoPersona = $request->tipoPersona;
        $tipo_documentoPersona = $request->tipo_documentoPersona;
        $num_documentoPersona = $request->num_documentoPersona;
        $apellidosPersona = $request->apellidosPersona;
        $nombresPersona = $request->nombresPersona;
        $telefonoPersona = $request->telefonoPersona;
        $direccionPersona = $request->direccionPersona;

        $permiso_form1 = $request->permiso_form1;
        $permiso_form2 = $request->permiso_form2;

        if($telefonoPersona == null){
            $telefonoPersona = '';
        }

        if($direccionPersona == null){
            $direccionPersona = '';
        }
        


        
        $regla0=DB::table('users')
        ->join('personas', 'personas.id', '=', 'users.persona_id')
        ->where('users.borrado','0')
        ->where('users.tipo_user_id',$tipo_user_id)
        ->where('personas.id',$persona_id)->count();

        $regla02=User::where('name',$name)->where('borrado','0')->count();
        $regla03=User::where('email',$email)->where('borrado','0')->count();


        $input5  = array('email' => $email);
        $reglas5 = array('email' => 'required');

        $input6  = array('name' => $name);
        $reglas6 = array('name' => 'required');

        $input7  = array('password' => $password);
        $reglas7 = array('password' => 'required');

        $input8  = array('cargoTrabajador' => $cargoTrabajador);
        $reglas8 = array('cargoTrabajador' => 'required');


        $validator5 = Validator::make($input5, $reglas5);
        $validator6 = Validator::make($input6, $reglas6);
        $validator7 = Validator::make($input7, $reglas7);
        $validator8 = Validator::make($input8, $reglas8);


        if($regla0>0){
            $result='0';
            $msj='Ya se encuentra registrado un Usuario con ese tipo de Usuario y con el DNI ingresado';
            $selector='txtdni';
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
       
        elseif ($validator5->fails()) {
            $result='0';
            $msj='Ingrese el email del usuario';
            $selector='txtemail';
        }
        elseif ($validator6->fails()) {
            $result='0';
            $msj='Ingrese el Username del Usuario';
            $selector='txtname';
        }
        elseif ($validator7->fails()) {
            $result='0';
            $msj='Ingrese el Password del usuario';
            $selector='txtpassword';
        }
        elseif (intval($tipo_user_id)==0) {
            $result='0';
            $msj='Seleccione el Tipo de Usuario';
            $selector='cbutipo_user_id';
        }
        elseif ($validator8->fails()) {
            $result='0';
            $msj='Debe de ingresar el Cargo del Usuario';
            $selector='txtcargoTrabajador';
        }
        elseif (intval($oficina_idTrabajador)==0) {
            $result='0';
            $msj='Seleccione la Oficina del Usuario';
            $selector='cbuoficina_idTrabajador';
        }
        else{

            $input1  = array('tipoPersona' => $tipoPersona);
            $reglas1 = array('tipoPersona' => 'required');
            
            $input2  = array('num_documentoPersona' => $num_documentoPersona);
            $reglas2 = array('num_documentoPersona' => 'required');
            
            $input3  = array('apellidosPersona' => $apellidosPersona);
            $reglas3 = array('apellidosPersona' => 'required');
            
            $input4  = array('nombresPersona' => $nombresPersona);
            $reglas4 = array('nombresPersona' => 'required');
            
            $input7  = array('tipo_documentoPersona' => $tipo_documentoPersona);
            $reglas7 = array('tipo_documentoPersona' => 'required');

            $validator1 = Validator::make($input1, $reglas1);
            $validator2 = Validator::make($input2, $reglas2);
            $validator3 = Validator::make($input3, $reglas3);
            $validator4 = Validator::make($input4, $reglas4);
            $validator7 = Validator::make($input7, $reglas7);

            if ($validator1->fails())
            {
                $result='0';
                $msj='Debe ingresar el tipo de persona';
                $selector='cbutipoPersona';
            }
            elseif ($validator2->fails())
            {
                $result='0';
                $msj='Debe ingresar el número de documento de identidad del Usuario';
                $selector='txtnum_documentoPersona';
            }
            elseif ($validator3->fails() && $tipoPersona == '1')
            {
                $result='0';
                $msj='Debe de ingresar los apellidos del Usuario';
                $selector='txtapellidosPersona';
            }
            elseif ($validator4->fails() && $tipoPersona == '1')
            {
                $result='0';
                $msj='Debe de ingresar los nombres del Usuario';
                $selector='txtnombresPersona';
            }
            elseif ($validator7->fails())
            {
                $result='0';
                $msj='Debe de seleccionar el tipo de documento del Usuario';
                $selector='cbutipo_documentoPersona';
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
                        $newPersona->email=$email;
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
                        $editPersona->email=$email;
        
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
                    $newPersona->email=$email;
                    $newPersona->activo='1';
                    $newPersona->borrado='0';

                    $newPersona->save();

                    $persona_id=$newPersona->id;
                }

                $newUser = new User();
                $newUser->name=$name;
                $newUser->email=$email;
                $newUser->password=bcrypt($password);
                $newUser->persona_id=$persona_id;
                $newUser->tipo_user_id=$tipo_user_id;
                $newUser->activo=$activo;
                $newUser->borrado='0';                   

                $newUser->save();

                $newTrabajador = new Trabajador();
                $newTrabajador->cargo=$cargoTrabajador;
                $newTrabajador->oficina_id=$oficina_idTrabajador;
                $newTrabajador->user_id=$newUser->id;
                $newTrabajador->activo=$activo;
                $newTrabajador->borrado='0';                   

                $newTrabajador->save();

                if($permiso_form1 && intval($tipo_user_id) > 1){
                    $permiso = Permiso::where('codigo_form', 'form1')->first();
                    $newPermiso = new UserPermiso();
                    $newPermiso->permiso_id= $permiso->id;
                    $newPermiso->user_id= $newUser->id;

                    $newPermiso->save();
                }

                if($permiso_form2 && intval($tipo_user_id) > 1){
                    $permiso = Permiso::where('codigo_form', 'form2')->first();
                    $newPermiso = new UserPermiso();
                    $newPermiso->permiso_id= $permiso->id;
                    $newPermiso->user_id= $newUser->id;

                    $newPermiso->save();
                }

                $msj='Nuevo Usuario del Sistema registrado con éxito';

            }
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
        
        $result='1';
        $msj='';
        $selector='';

        $name=$request->name;
        $email=$request->email;
        $activo=$request->activo;
        $persona_id=$request->persona_id;
        $tipo_user_id=$request->tipo_user_id;
       
        $password=$request->password;

        $modifpassword=$request->modifpassword;


        $idTrabajador=$request->idTrabajador;
        $cargoTrabajador=$request->cargoTrabajador;
        $oficina_idTrabajador=$request->oficina_idTrabajador;

        $tipoPersona = $request->tipoPersona;
        $tipo_documentoPersona = $request->tipo_documentoPersona;
        $num_documentoPersona = $request->num_documentoPersona;
        $apellidosPersona = $request->apellidosPersona;
        $nombresPersona = $request->nombresPersona;
        $telefonoPersona = $request->telefonoPersona;
        $direccionPersona = $request->direccionPersona;

        $permiso_form1 = $request->permiso_form1;
        $permiso_form2 = $request->permiso_form2;

        if($telefonoPersona == null){
            $telefonoPersona = '';
        }

        if($direccionPersona == null){
            $direccionPersona = '';
        }


        $regla0=DB::table('users')
        ->join('personas', 'personas.id', '=', 'users.persona_id')
        ->where('users.tipo_user_id',$tipo_user_id)
        ->where('users.borrado','0')
        ->where('users.id','<>',$id)
        ->where('personas.id',$persona_id)->count();

        $regla02=User::where('name',$name)->where('users.id','<>',$id)->where('borrado','0')->count();
        $regla03=User::where('email',$email)->where('users.id','<>',$id)->where('borrado','0')->count();



        $input5  = array('email' => $email);
        $reglas5 = array('email' => 'required');

        $input6  = array('name' => $name);
        $reglas6 = array('name' => 'required');

        $input7  = array('password' => $password);
        $reglas7 = array('password' => 'required');

        $input8  = array('cargoTrabajador' => $cargoTrabajador);
        $reglas8 = array('cargoTrabajador' => 'required');

    
        $validator5 = Validator::make($input5, $reglas5);
        $validator6 = Validator::make($input6, $reglas6);
        $validator7 = Validator::make($input7, $reglas7);
        $validator8 = Validator::make($input8, $reglas8);


        if($regla0>0){
            $result='0';
            $msj='Ya se encuentra registrado un Usuario con ese tipo de Usuario y con el DNI ingresado';
            $selector='txtdniE';
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

        elseif ($validator5->fails()) {
            $result='0';
            $msj='Ingrese el email del usuario';
            $selector='txtemailE';
        }
        elseif ($validator6->fails()) {
            $result='0';
            $msj='Ingrese el Username del Usuario';
            $selector='txtnameE';
        }
        elseif (intval($tipo_user_id)==0) {
            $result='0';
            $msj='Seleccione el Tipo de Usuario';
            $selector='cbutipo_user_idE';
        }

 
        elseif ($validator7->fails() && intval($modifpassword)==1) {
            $result='0';
            $msj='Ingrese el Password del usuario';
            $selector='txtpasswordE';
        }

        elseif ($validator8->fails()) {
            $result='0';
            $msj='Debe de ingresar el Cargo del Usuario';
            $selector='txtcargoTrabajadorE';
        }
        elseif (intval($oficina_idTrabajador)==0) {
            $result='0';
            $msj='Seleccione la Oficina del Usuario';
            $selector='cbuoficina_idTrabajadorE';
        }

        else{

            $input1  = array('tipoPersona' => $tipoPersona);
            $reglas1 = array('tipoPersona' => 'required');
            
            $input2  = array('num_documentoPersona' => $num_documentoPersona);
            $reglas2 = array('num_documentoPersona' => 'required');
            
            $input3  = array('apellidosPersona' => $apellidosPersona);
            $reglas3 = array('apellidosPersona' => 'required');
            
            $input4  = array('nombresPersona' => $nombresPersona);
            $reglas4 = array('nombresPersona' => 'required');
            
            $input7  = array('tipo_documentoPersona' => $tipo_documentoPersona);
            $reglas7 = array('tipo_documentoPersona' => 'required');

            $validator1 = Validator::make($input1, $reglas1);
            $validator2 = Validator::make($input2, $reglas2);
            $validator3 = Validator::make($input3, $reglas3);
            $validator4 = Validator::make($input4, $reglas4);
            $validator7 = Validator::make($input7, $reglas7);

            if ($validator1->fails())
            {
                $result='0';
                $msj='Debe ingresar el tipo de persona';
                $selector='cbutipoPersonaE';
            }
            elseif ($validator2->fails())
            {
                $result='0';
                $msj='Debe ingresar el número de documento de identidad del Usuario';
                $selector='txtnum_documentoPersonaE';
            }
            elseif ($validator3->fails() && $tipoPersona == '1')
            {
                $result='0';
                $msj='Debe de ingresar los apellidos del Usuario';
                $selector='txtapellidosPersonaE';
            }
            elseif ($validator4->fails() && $tipoPersona == '1')
            {
                $result='0';
                $msj='Debe de ingresar los nombres del Usuario';
                $selector='txtnombresPersonaE';
            }
            elseif ($validator7->fails())
            {
                $result='0';
                $msj='Debe de seleccionar el tipo de documento del Usuario';
                $selector='cbutipo_documentoPersonaE';
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
                        $newPersona->email=$email;
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
                        $editPersona->email=$email;
        
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
                    $newPersona->email=$email;
                    $newPersona->activo='1';
                    $newPersona->borrado='0';

                    $newPersona->save();

                    $persona_id=$newPersona->id;
                }

                if(intval($modifpassword)==1){
                    $newUser = User::find($id);
                    $newUser->name=$name;
                    $newUser->email=$email;
                    $newUser->persona_id=$persona_id;
                    $newUser->tipo_user_id=$tipo_user_id;
                    $newUser->activo=$activo;
                    $newUser->password=bcrypt($password);
    
                    $newUser->save();
    
                }
                else{
                    $newUser = User::find($id);
                    $newUser->name=$name;
                    $newUser->email=$email;
                    $newUser->persona_id=$persona_id;
                    $newUser->tipo_user_id=$tipo_user_id;
                    $newUser->activo=$activo;
    
                    $newUser->save();    
                }

                $editTrabajador = Trabajador::find($idTrabajador);
                $editTrabajador->cargo=$cargoTrabajador;
                $editTrabajador->oficina_id=$oficina_idTrabajador;
                $editTrabajador->activo=$activo;           

                $editTrabajador->save();

                $oldPermisos = UserPermiso::where('user_id', $newUser->id);
                $oldPermisos->delete();

                if($permiso_form1 && intval($tipo_user_id) > 1){
                    $permiso = Permiso::where('codigo_form', 'form1')->first();
                    $newPermiso = new UserPermiso();
                    $newPermiso->permiso_id= $permiso->id;
                    $newPermiso->user_id= $newUser->id;

                    $newPermiso->save();
                }

                if($permiso_form2 && intval($tipo_user_id) > 1){
                    $permiso = Permiso::where('codigo_form', 'form2')->first();
                    $newPermiso = new UserPermiso();
                    $newPermiso->permiso_id= $permiso->id;
                    $newPermiso->user_id= $newUser->id;

                    $newPermiso->save();
                }
    
                $msj='Usuario modificado con éxito';

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

        $borrarUsuario = User::findOrFail($id);
        //$task->delete();
        $borrarUsuario->borrado='1';
        $borrarUsuario->save();

        $trabajador = Trabajador::where('user_id',$id)->first();
        $trabajador->borrado='1';
        $trabajador->save();

        $msj='Usuario seleccionado eliminado exitosamente';


        return response()->json(["result"=>$result,'msj'=>$msj]);
    }

    public function altabaja($id,$estado)
    {
        $result='1';
        $msj='';
        $selector='';

        $updateUsuario = User::findOrFail($id);
        $updateUsuario->activo=$estado;
        $updateUsuario->save();

        $trabajador = Trabajador::where('user_id',$id)->first();
        $trabajador->activo=$estado;
        $trabajador->save();

        if(strval($estado)=="0"){
            $msj='El Usuario fue Desactivado exitosamente';
        }elseif(strval($estado)=="1"){
            $msj='El Usuario fue Activado exitosamente';
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);

    }


    public function verpersona($dni)
    {
       $persona=Persona::where('dni_ruc',$dni)->get();

       $id="0";
       $idUser="0";

        foreach ($persona as $key => $dato) {
          $id=$dato->id;
        }

        $user=User::where('persona_id',$id)->where('borrado','0')->get();

        foreach ($user as $key => $dato) {
            $idUser=$dato->id;
        }


      return response()->json(["persona"=>$persona, "id"=>$id, "user"=>$user , "idUser"=>$idUser]);

    }


    
    public function export(Request $request) 
    {
        $fechaRegistro=$request->fechaRegistro;
        $nombres=$request->nombres;
        $apellidos=$request->apellidos;
        $tipo_user_id=$request->tipo_user_id;

        $data=[];

        $titulo='REPORTE DE USUARIOS';

        array_push($data, array($titulo));
        array_push($data, array(''));

        $cont = 1;

        $query = DB::table('users')
        ->join('tipo_users', 'tipo_users.id', '=', 'users.tipo_user_id')
        ->join('personas', 'personas.id', '=', 'users.persona_id')
        ->join('trabajadors', 'users.id', '=', 'trabajadors.user_id')
        ->join('oficinas', 'oficinas.id', '=', 'trabajadors.oficina_id')

        ->where('users.borrado','0')
         ->orderBy('tipo_users.id')
        ->orderBy('users.name')
        ->orderBy('personas.nombres')
        ->orderBy('personas.apellidos')
        ->select('users.id as id','users.name','users.email','users.activo','users.borrado','users.persona_id','users.tipo_user_id', 'users.created_at',
        
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

        'tipo_users.nombre as tipouser',

        'trabajadors.id as idTrabajador',
        'trabajadors.cargo as cargoTrabajador',
        'trabajadors.oficina_id as oficina_idTrabajador',
        'oficinas.nombre as nombreOficina'
        );

        $usaFiltro = false;

        if($fechaRegistro != null && $fechaRegistro != ""){
            $query->whereRaw('date(users.created_at) = ?', [$fechaRegistro]);
            $usaFiltro = true;
        }
        if($nombres != null && trim($nombres, " ") != ""){
            $query->where('personas.nombres','like','%'.$nombres.'%');
            $usaFiltro = true;
        }
        if($apellidos != null && trim($apellidos, " ") != ""){
            $query->where('personas.apellidos','like','%'.$apellidos.'%');
            $usaFiltro = true;
        }
        if($tipo_user_id != null && $tipo_user_id != "0"){
            $query->where('tipo_users.id','=',$tipo_user_id);
            $usaFiltro = true;
        }

        $registrosimp=$query->get();

        if($usaFiltro){
            array_push($data, array('Filtros de Búsqueda:'));

            if($fechaRegistro != null && $fechaRegistro != ""){
                array_push($data, array('','Fecha de Registro: ', pasFechaVista(substr($fechaRegistro, 0, 10))));
                $cont++;
            }
            if($nombres != null && trim($nombres, " ") != ""){
                array_push($data, array('','Nombres: ', $nombres));
                $cont++;
            }
            if($apellidos != null && trim($apellidos, " ") != ""){
                array_push($data, array('','Apellidos: ', $apellidos));
                $cont++;
            }
            if($tipo_user_id != null && $tipo_user_id != "0"){
                $tipoUser = Tipouser::find($tipo_user_id);
                array_push($data, array('','Tipo de Usuario: ', $tipoUser->nombre));
                $cont++;
            }

            /* if($cont < 5){
                for ($i=$cont; $i <5; $i++) { 
                    array_push($data, array(''));
                }
            } */
        }
        else{
            array_push($data, array(''));
        }

        $cont = $cont + 3;



        array_push($data, array('N°','FECHA DE REGISTRO', 'NIVEL DE USUARIO', 'NOMBRES', 'APELLIDOS','DNI','CELULAR','CORREO ELECTRONICO','CARGO','OFICINA'));

        foreach ($registrosimp as $key => $dato) {

            $permisos = "";
            if($dato->tipo_user_id == '1'){
                $permisos = "Todos";
            }
            else{
                $permisosUsuario =  DB::table('permisos')
                    ->join('user_permisos', 'permisos.id', '=', 'user_permisos.permiso_id')
                    ->where('user_permisos.user_id',$dato->id)
                    ->orderBy('permisos.id')
                    ->select('permisos.id as id','permisos.codigo_form','permisos.descripcion',
                
                    'user_permisos.permiso_id as permiso_id',
                    'user_permisos.id as idUserPermiso',
                    'user_permisos.user_id as user_id'
                    )
                    ->get();

                    foreach ($permisosUsuario as $key => $value) {
                        $permisos = $value->descripcion.' - ';
                    }
                    
            }

            $created = $dato->created_at != null ? pasFechaVista(substr($dato->created_at, 0, 10)).' '.substr($dato->created_at, 11) : "";
            array_push($data, array($key+1,
                $created,
                $dato->tipouser,
                $dato->nombresPersona,
                $dato->apellidosPersona,
                $dato->num_documentoPersona,
                $dato->telefonoPersona,
                $dato->email,
                $dato->cargoTrabajador,
                $dato->nombreOficina,
                $permisos                  
            ));
        }

        $export = new Reporte1Export($data, $cont);

        return Excel::download($export, 'reporte_usuarios.xlsx');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;

use App\Tipouser;
use App\User;

use App\ProcesoLectura;
use App\LecturaMedidor;
use App\Zona;
use App\PuestoLocal;
use App\Medidor;
use App\PuestoLocalPersona;
use App\Persona;
use App\Config;

use App\Exports\Reporte4Export;
use App\Exports\Reporte5Export;
use App\Exports\Reporte6Export;
use Maatwebsite\Excel\Facades\Excel;

use stdClass;
use DB;
use Storage;
set_time_limit(600);

class ProcesoLecturaController extends Controller
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
            $procesoLectura=ProcesoLectura::where('estado', '>=' ,'1')
                            ->where('estado', '<' ,'3')
                            ->first();

            $contProcesoLectura=ProcesoLectura::where('estado', '>=' ,'1')
                            ->where('estado', '<' ,'3')
                            ->count();

            if($contProcesoLectura > 0){
                $procesoLectura->mesNombre = nombremes($procesoLectura->mes);
            }

            $yearActual = date('Y');
            $mesActual = date('m');

            $modulo="procesolectura";

            return view('procesolectura.index',compact('tipouser','modulo', 'contProcesoLectura', 'yearActual', 'mesActual', 'procesoLectura'));
        }
        else
        {
            return redirect('home');    
        }
    }

    public function index2()
    {
        if(accesoUser([1,2,3])){


            $idtipouser=Auth::user()->tipo_user_id;
            $tipouser=Tipouser::find($idtipouser);
            $procesoLectura=ProcesoLectura::where('estado', '>=' ,'1')
                            ->where('estado', '<' ,'3')
                            ->first();

            $contProcesoLectura=ProcesoLectura::where('estado', '>=' ,'1')
                            ->where('estado', '<' ,'3')
                            ->count();

            if($contProcesoLectura > 0){
                $procesoLectura->mesNombre = nombremes($procesoLectura->mes);
            }

            $operadores = DB::table('users')
            ->join('tipo_users', 'tipo_users.id', '=', 'users.tipo_user_id')
            ->join('personas', 'personas.id', '=', 'users.persona_id')
            ->join('trabajadors', 'trabajadors.user_id', '=', 'users.id')
            ->where('users.borrado', '0')
            ->where('tipo_users.id', '4')
            ->orderBy('users.id')
            ->select(
            DB::Raw("IFNULL( `users`.`id` , '0' ) as idUsers"),
            DB::Raw("IFNULL( `users`.`name` , '' ) as nameUsers"),
            DB::Raw("IFNULL( `users`.`email` , '' ) as emailUsers"),

            DB::Raw("IFNULL( `tipo_users`.`id` , '0' ) as idTipo_users"),
            DB::Raw("IFNULL( `tipo_users`.`nombre` , '' ) as nombreTipo_users"),
            DB::Raw("IFNULL( `tipo_users`.`descripcion` , '' ) as descripcionTipo_users"),

            DB::Raw("IFNULL( `personas`.`id` , '0' ) as idPersonas"),
            DB::Raw("IFNULL( `personas`.`tipo` , '' ) as tipoPersonas"),
            DB::Raw("IFNULL( `personas`.`tipo_documento` , '' ) as tipo_documentoPersonas"),
            DB::Raw("IFNULL( `personas`.`num_documento` , '' ) as num_documentoPersonas"),
            DB::Raw("IFNULL( `personas`.`apellidos` , '' ) as apellidosPersonas"),
            DB::Raw("IFNULL( `personas`.`nombres` , '' ) as nombresPersonas"),
            DB::Raw("IFNULL( `personas`.`telefono` , '' ) as telefonoPersonas"),
            DB::Raw("IFNULL( `personas`.`direccion` , '' ) as direccionPersonas"),
            DB::Raw("IFNULL( `personas`.`email` , '' ) as emailPersonas"),

            DB::Raw("IFNULL( `trabajadors`.`id` , '0' ) as idTrabajadors"),
            DB::Raw("IFNULL( `trabajadors`.`cargo` , '' ) as cargoTrabajadors"),
            DB::Raw("IFNULL( `trabajadors`.`oficina_id` , '0' ) as oficina_idTrabajadors"),
            )
            ->get();



            $yearActual = date('Y');
            $mesActual = date('m');

            $modulo="programaruta";

            return view('programaruta.index',compact('tipouser','modulo', 'contProcesoLectura', 'yearActual', 'mesActual', 'procesoLectura','operadores'));
        }
        else
        {
            return redirect('home');    
        }
    }

    public function index3()
    {
        if(accesoUser([1,2,3,4])){


            $idtipouser=Auth::user()->tipo_user_id;
            $tipouser=Tipouser::find($idtipouser);
            $procesoLectura=ProcesoLectura::where('estado','2')
                            ->first();

            $contProcesoLectura=ProcesoLectura::where('estado','2')
                            ->count();

            $costoUnitarioKw = Config::where('name', 'costoUnitarioKwToSoles')->first();

            if($contProcesoLectura > 0){
                $procesoLectura->mesNombre = nombremes($procesoLectura->mes);
            }

            $yearActual = date('Y');
            $mesActual = date('m');

            $modulo="lecturadatos";

            return view('lecturadatos.index',compact('tipouser','modulo', 'contProcesoLectura', 'yearActual', 'mesActual', 'procesoLectura', 'costoUnitarioKw'));
        }
        else
        {
            return redirect('home');    
        }
    }

    public function index4()
    {
        if(accesoUser([1,2,3,4])){

            $idtipouser=Auth::user()->tipo_user_id;
            $tipouser=Tipouser::find($idtipouser);

            $operadores = DB::table('users')
            ->join('tipo_users', 'tipo_users.id', '=', 'users.tipo_user_id')
            ->join('personas', 'personas.id', '=', 'users.persona_id')
            ->join('trabajadors', 'trabajadors.user_id', '=', 'users.id')
            ->where('users.borrado', '0')
            ->where('tipo_users.id', '4')
            ->orderBy('users.id')
            ->select(
            DB::Raw("IFNULL( `users`.`id` , '0' ) as idUsers"),
            DB::Raw("IFNULL( `users`.`name` , '' ) as nameUsers"),
            DB::Raw("IFNULL( `users`.`email` , '' ) as emailUsers"),

            DB::Raw("IFNULL( `tipo_users`.`id` , '0' ) as idTipo_users"),
            DB::Raw("IFNULL( `tipo_users`.`nombre` , '' ) as nombreTipo_users"),
            DB::Raw("IFNULL( `tipo_users`.`descripcion` , '' ) as descripcionTipo_users"),

            DB::Raw("IFNULL( `personas`.`id` , '0' ) as idPersonas"),
            DB::Raw("IFNULL( `personas`.`tipo` , '' ) as tipoPersonas"),
            DB::Raw("IFNULL( `personas`.`tipo_documento` , '' ) as tipo_documentoPersonas"),
            DB::Raw("IFNULL( `personas`.`num_documento` , '' ) as num_documentoPersonas"),
            DB::Raw("IFNULL( `personas`.`apellidos` , '' ) as apellidosPersonas"),
            DB::Raw("IFNULL( `personas`.`nombres` , '' ) as nombresPersonas"),
            DB::Raw("IFNULL( `personas`.`telefono` , '' ) as telefonoPersonas"),
            DB::Raw("IFNULL( `personas`.`direccion` , '' ) as direccionPersonas"),
            DB::Raw("IFNULL( `personas`.`email` , '' ) as emailPersonas"),

            DB::Raw("IFNULL( `trabajadors`.`id` , '0' ) as idTrabajadors"),
            DB::Raw("IFNULL( `trabajadors`.`cargo` , '' ) as cargoTrabajadors"),
            DB::Raw("IFNULL( `trabajadors`.`oficina_id` , '0' ) as oficina_idTrabajadors"),
            )
            ->get();

            $procesosLecturas=ProcesoLectura::where('estado', '>=' ,'1')
                            ->orderBy('anio', 'desc')
                            ->orderBy('mes', 'desc')
                            ->get();

            $idProcesoLecturaFirst = 0;
            $existProceso = 0;
            foreach ($procesosLecturas as $key => $dato) {
                if($key == 0){
                    $idProcesoLecturaFirst = $dato->id;
                    $existProceso = 1;
                }
                $dato->mesNombre = strtoupper(nombremes($dato->mes));
                $dato->mes = str_pad($dato->mes, 2, "0", STR_PAD_LEFT);
            }

            $modulo="reporte4";
            return view('reporte4.index',compact('tipouser','modulo', 'operadores','procesosLecturas','idProcesoLecturaFirst','existProceso'));
        }
        else
        {
            return redirect('home');           
        }
    }

    public function index5()
    {
        if(accesoUser([1,2,3,4,5])){

            $idtipouser=Auth::user()->tipo_user_id;
            $tipouser=Tipouser::find($idtipouser);

            $procesosLecturas=ProcesoLectura::where('estado', '>=' ,'1')
                            ->orderBy('anio', 'desc')
                            ->orderBy('mes', 'desc')
                            ->get();

            $idProcesoLecturaFirst = 0;
            $existProceso = 0;
            foreach ($procesosLecturas as $key => $dato) {
                if($key == 0){
                    $idProcesoLecturaFirst = $dato->id;
                    $existProceso = 1;
                }
                $dato->mesNombre = strtoupper(nombremes($dato->mes));
                $dato->mes = str_pad($dato->mes, 2, "0", STR_PAD_LEFT);
            }

            $modulo="reporte5";
            return view('reporte5.index',compact('tipouser','modulo','procesosLecturas','idProcesoLecturaFirst','existProceso'));
        }
        else
        {
            return redirect('home');           
        }
    }

    public function index6()
    {
        if(accesoUser([1,2,3,4,5])){

            $idtipouser=Auth::user()->tipo_user_id;
            $tipouser=Tipouser::find($idtipouser);

            $procesosLecturas=ProcesoLectura::where('estado', '>=' ,'1')
                            ->orderBy('anio', 'desc')
                            ->orderBy('mes', 'desc')
                            ->get();

            $idProcesoLecturaFirst = 0;
            $existProceso = 0;
            foreach ($procesosLecturas as $key => $dato) {
                if($key == 0){
                    $idProcesoLecturaFirst = $dato->id;
                    $existProceso = 1;
                }
                $dato->mesNombre = strtoupper(nombremes($dato->mes));
                $dato->mes = str_pad($dato->mes, 2, "0", STR_PAD_LEFT);
            }

            $modulo="reporte6";
            return view('reporte6.index',compact('tipouser','modulo','procesosLecturas','idProcesoLecturaFirst','existProceso'));
        }
        else
        {
            return redirect('home');           
        }
    }


    public function index(Request $request)
    {
        $procesoLectura=ProcesoLectura::where('estado', '>=' ,'1')
                            ->where('estado', '<' ,'3')
                            ->first();

        $contProcesoLectura=ProcesoLectura::where('estado', '>=' ,'1')
                            ->where('estado', '<' ,'3')
                            ->count();

        
        $result = 0;
        
        if($contProcesoLectura > 0){
            $procesoLectura->mesNombre = strtoupper(nombremes($procesoLectura->mes));
            $procesoLectura->mes = str_pad($procesoLectura->mes, 2, "0", STR_PAD_LEFT);
            $result = 1;
        }

        return [
            'procesoLectura'=> $procesoLectura,
            'contProcesoLectura'=> $contProcesoLectura,
            'result'=> $result,
        ] ;

    }

    public function buscarDatos(Request $request)
    {
        $fechaRegistro=$request->fechaRegistro;
        $idProcesoLectura=$request->idProcesoLectura;
        $serie=$request->serie;
        $idOperador=$request->idOperador;

        $buscar="";

        $query = DB::table('proceso_lecturas')
        ->join('lectura_medidors', 'proceso_lecturas.id', '=', 'lectura_medidors.proceso_lectura_id')
        ->join('users', 'users.id', '=', 'lectura_medidors.user_programado_id')
        ->join('personas', 'personas.id', '=', 'users.persona_id')
        ->join('medidors', 'medidors.id', '=', 'lectura_medidors.medidors_id')
        ->join('puesto_locals', 'puesto_locals.id', '=', 'medidors.puesto_local_id')
        ->join('zonas', 'zonas.id', '=', 'puesto_locals.zona_id')

        ->where('proceso_lecturas.id', $idProcesoLectura)
        ->where('lectura_medidors.borrado', '0')
        ->where('lectura_medidors.borrado', '0')

        ->orderBy('zonas.nombre')
        ->orderBy('puesto_locals.numero')
        ->orderBy('puesto_locals.nombre')

        ->select(
            'lectura_medidors.fecha_programacion',

            'zonas.nombre as nombreZona',
            'puesto_locals.direccion as direccionPuestoLocal',

            'puesto_locals.nombre as nombrePuestoLocal',
            'puesto_locals.numero as numeroPuestoLocal',

            'medidors.serie as serieMedidor',

            'personas.nombres as nombresPersona',
            'personas.apellidos as apellidosPersona',

            'proceso_lecturas.orden_trabajo'
        );

        if($fechaRegistro != null && $fechaRegistro != ""){
            $query->whereRaw('date(lectura_medidors.fecha_programacion) = ?', [$fechaRegistro]);
        }
        if($serie != null && trim($serie, " ") != ""){
            $query->where('medidors.serie','like','%'.$serie.'%');
        }
        if($idOperador != null && $idOperador != "0"){
            $query->where('users.id',$idOperador);
        }

        $registros=$query->paginate(50);

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
        $idProcesoLectura=$request->idProcesoLectura;
        $serie=$request->serie;
        $idOperador=$request->idOperador;

        $buscar="";

        $query = DB::table('proceso_lecturas')
        ->join('lectura_medidors', 'proceso_lecturas.id', '=', 'lectura_medidors.proceso_lectura_id')
        ->join('users', 'users.id', '=', 'lectura_medidors.user_programado_id')
        ->join('personas', 'personas.id', '=', 'users.persona_id')
        ->join('medidors', 'medidors.id', '=', 'lectura_medidors.medidors_id')
        ->join('puesto_locals', 'puesto_locals.id', '=', 'medidors.puesto_local_id')
        ->join('zonas', 'zonas.id', '=', 'puesto_locals.zona_id')

        ->where('proceso_lecturas.id', $idProcesoLectura)
        ->where('lectura_medidors.borrado', '0')
        ->where('lectura_medidors.borrado', '0')

        ->orderBy('zonas.nombre')
        ->orderBy('puesto_locals.numero')
        ->orderBy('puesto_locals.nombre')

        ->select(
            'lectura_medidors.fecha_programacion',

            'zonas.nombre as nombreZona',
            'puesto_locals.direccion as direccionPuestoLocal',

            'puesto_locals.nombre as nombrePuestoLocal',
            'puesto_locals.numero as numeroPuestoLocal',

            'medidors.serie as serieMedidor',

            'personas.nombres as nombresPersona',
            'personas.apellidos as apellidosPersona',

            'proceso_lecturas.orden_trabajo'
        );

        if($fechaRegistro != null && $fechaRegistro != ""){
            $query->whereRaw('date(lectura_medidors.fecha_programacion) = ?', [$fechaRegistro]);
        }
        if($serie != null && trim($serie, " ") != ""){
            $query->where('medidors.serie','like','%'.$serie.'%');
        }
        if($idOperador != null && $idOperador != "0"){
            $query->where('users.id',$idOperador);
        }

        $registrosimp=$query->get();

        return [
            'registrosimp'=>$registrosimp,
        ];

    }

    public function buscarDatos2(Request $request)
    {
        $ubicacion=$request->ubicacion;
        $idProcesoLectura=$request->idProcesoLectura;
        $serie=$request->serie;
        $nombre=$request->nombre;

        $idtipouser=Auth::user()->tipo_user_id;

        $buscar="";

        $query = DB::table('proceso_lecturas')
        ->join('lectura_medidors', 'proceso_lecturas.id', '=', 'lectura_medidors.proceso_lectura_id')
        ->join('users', 'users.id', '=', 'lectura_medidors.user_programado_id')
        ->join('personas', 'personas.id', '=', 'users.persona_id')
        ->join('medidors', 'medidors.id', '=', 'lectura_medidors.medidors_id')
        ->join('puesto_locals', 'puesto_locals.id', '=', 'medidors.puesto_local_id')
        ->join('zonas', 'zonas.id', '=', 'puesto_locals.zona_id')

        ->leftjoin('imagens',  function($join) {
            $join->on('imagens.lectura_medidor_id', '=', 'lectura_medidors.id');
            $join->on('imagens.activo', '=', DB::raw('1'));
            $join->on('imagens.borrado', '=', DB::raw('0'));
        })

        ->where('proceso_lecturas.id', $idProcesoLectura)
        ->where('lectura_medidors.borrado', '0')
        ->where('lectura_medidors.borrado', '0')

        ->orderBy('zonas.nombre')
        ->orderBy('puesto_locals.numero')
        ->orderBy('puesto_locals.nombre')

        ->select(
            'lectura_medidors.fecha_lectura',
            'lectura_medidors.estado',
            'lectura_medidors.lectura',

            'zonas.nombre as nombreZona',
            'puesto_locals.direccion as direccionPuestoLocal',

            'puesto_locals.nombre as nombrePuestoLocal',
            'puesto_locals.numero as numeroPuestoLocal',

            'medidors.serie as serieMedidor',

            'personas.nombres as nombresPersona',
            'personas.apellidos as apellidosPersona',

            'proceso_lecturas.orden_trabajo',

            DB::Raw("IFNULL( `imagens`.`id` , '0' ) as idImagens"),
            DB::Raw("IFNULL( `imagens`.`ruta_img` , '' ) as ruta_imgImagens"),
        );

        if($ubicacion != null && $ubicacion != ""){
            $query->whereRaw('(zonas.nombre = ? OR puesto_locals.direccion = ?)', [$ubicacion, $ubicacion]);
        }
        if($serie != null && trim($serie, " ") != ""){
            $query->where('medidors.serie','like','%'.$serie.'%');
        }
        if($nombre != null && trim($nombre, " ") != ""){
            $query->whereRaw('(puesto_locals.nombre like ? OR puesto_locals.numero like ? )', ['%'.$nombre.'%', '%'.$nombre.'%']);
        }

        if($idtipouser == "5"){
            $puestoLocalPersona = PuestoLocalPersona::where('user_id', Auth::user()->id)->first();
            if($puestoLocalPersona != null){
                $query->where('puesto_locals.id', $puestoLocalPersona->puesto_local_id);
            }
        }


        $registros=$query->paginate(50);

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

    public function buscarDatosImp2(Request $request)
    {
        $ubicacion=$request->ubicacion;
        $idProcesoLectura=$request->idProcesoLectura;
        $serie=$request->serie;
        $nombre=$request->nombre;

        $buscar="";

        $idtipouser=Auth::user()->tipo_user_id;

        $query = DB::table('proceso_lecturas')
        ->join('lectura_medidors', 'proceso_lecturas.id', '=', 'lectura_medidors.proceso_lectura_id')
        ->join('users', 'users.id', '=', 'lectura_medidors.user_programado_id')
        ->join('personas', 'personas.id', '=', 'users.persona_id')
        ->join('medidors', 'medidors.id', '=', 'lectura_medidors.medidors_id')
        ->join('puesto_locals', 'puesto_locals.id', '=', 'medidors.puesto_local_id')
        ->join('zonas', 'zonas.id', '=', 'puesto_locals.zona_id')

        ->leftjoin('imagens',  function($join) {
            $join->on('imagens.lectura_medidor_id', '=', 'lectura_medidors.id');
            $join->on('imagens.activo', '=', DB::raw('1'));
            $join->on('imagens.borrado', '=', DB::raw('0'));
        })

        ->where('proceso_lecturas.id', $idProcesoLectura)
        ->where('lectura_medidors.borrado', '0')
        ->where('lectura_medidors.borrado', '0')

        ->orderBy('zonas.nombre')
        ->orderBy('puesto_locals.numero')
        ->orderBy('puesto_locals.nombre')

        ->select(
            'lectura_medidors.fecha_lectura',
            'lectura_medidors.estado',
            'lectura_medidors.lectura',

            'zonas.nombre as nombreZona',
            'puesto_locals.direccion as direccionPuestoLocal',

            'puesto_locals.nombre as nombrePuestoLocal',
            'puesto_locals.numero as numeroPuestoLocal',

            'medidors.serie as serieMedidor',

            'personas.nombres as nombresPersona',
            'personas.apellidos as apellidosPersona',

            'proceso_lecturas.orden_trabajo',

            DB::Raw("IFNULL( `imagens`.`id` , '0' ) as idImagens"),
            DB::Raw("IFNULL( `imagens`.`ruta_img` , '' ) as ruta_imgImagens"),
        );

        if($ubicacion != null && $ubicacion != ""){
            $query->whereRaw('(zonas.nombre = ? OR puesto_locals.direccion = ?)', [$ubicacion, $ubicacion]);
        }
        if($serie != null && trim($serie, " ") != ""){
            $query->where('medidors.serie','like','%'.$serie.'%');
        }
        if($nombre != null && trim($nombre, " ") != ""){
            $query->whereRaw('(puesto_locals.nombre like ? OR puesto_locals.numero like ? )', ['%'.$nombre.'%', '%'.$nombre.'%']);
        }
        if($idtipouser == "5"){
            $puestoLocalPersona = PuestoLocalPersona::where('user_id', Auth::user()->id)->first();
            if($puestoLocalPersona != null){
                $query->where('puesto_locals.id', $puestoLocalPersona->puesto_local_id);
            }
        }

        $registrosimp=$query->get();

        return [
            'registrosimp'=>$registrosimp,
        ];

    }

    public function buscarDatos3(Request $request)
    {
        $fechaRegistro=$request->fechaRegistro;
        $ubicacion=$request->ubicacion;
        $idProcesoLectura=$request->idProcesoLectura;
        $serie=$request->serie;
        $nombre=$request->nombre;

        $buscar="";

        $idtipouser=Auth::user()->tipo_user_id;

        $query = DB::table('proceso_lecturas')
        ->join('lectura_medidors', 'proceso_lecturas.id', '=', 'lectura_medidors.proceso_lectura_id')
        ->join('users', 'users.id', '=', 'lectura_medidors.user_programado_id')
        ->join('personas', 'personas.id', '=', 'users.persona_id')
        ->join('medidors', 'medidors.id', '=', 'lectura_medidors.medidors_id')
        ->join('puesto_locals', 'puesto_locals.id', '=', 'medidors.puesto_local_id')
        ->join('zonas', 'zonas.id', '=', 'puesto_locals.zona_id')

        ->where('proceso_lecturas.id', $idProcesoLectura)
        ->where('lectura_medidors.borrado', '0')
        ->where('lectura_medidors.borrado', '0')

        ->orderBy('zonas.nombre')
        ->orderBy('puesto_locals.numero')
        ->orderBy('puesto_locals.nombre')

        ->select(
            'lectura_medidors.fecha_lectura',
            'lectura_medidors.estado',
            'lectura_medidors.lectura',
            'lectura_medidors.lectura_ultima',
            'lectura_medidors.consumo_kw',
            'lectura_medidors.lectura_consistente',
            'lectura_medidors.consumo_soles',

            'zonas.nombre as nombreZona',
            'puesto_locals.direccion as direccionPuestoLocal',

            'puesto_locals.nombre as nombrePuestoLocal',
            'puesto_locals.numero as numeroPuestoLocal',

            'medidors.serie as serieMedidor',

            'personas.nombres as nombresPersona',
            'personas.apellidos as apellidosPersona',

            'proceso_lecturas.orden_trabajo'
        );

        if($fechaRegistro != null && $fechaRegistro != ""){
            $query->whereRaw('date(lectura_medidors.fecha_lectura) = ?', [$fechaRegistro]);
        }
        if($ubicacion != null && $ubicacion != ""){
            $query->whereRaw('(zonas.nombre = ? OR puesto_locals.direccion = ?)', [$ubicacion, $ubicacion]);
        }
        if($serie != null && trim($serie, " ") != ""){
            $query->where('medidors.serie','like','%'.$serie.'%');
        }
        if($nombre != null && trim($nombre, " ") != ""){
            $query->whereRaw('(puesto_locals.nombre like ? OR puesto_locals.numero like ? )', ['%'.$nombre.'%', '%'.$nombre.'%']);
        }
        if($idtipouser == "5"){
            $puestoLocalPersona = PuestoLocalPersona::where('user_id', Auth::user()->id)->first();
            if($puestoLocalPersona != null){
                $query->where('puesto_locals.id', $puestoLocalPersona->puesto_local_id);
            }
        }


        $registros=$query->paginate(50);

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

    public function buscarDatosImp3(Request $request)
    {
        $fechaRegistro=$request->fechaRegistro;
        $ubicacion=$request->ubicacion;
        $idProcesoLectura=$request->idProcesoLectura;
        $serie=$request->serie;
        $nombre=$request->nombre;

        $buscar="";

        $idtipouser=Auth::user()->tipo_user_id;

        $query = DB::table('proceso_lecturas')
        ->join('lectura_medidors', 'proceso_lecturas.id', '=', 'lectura_medidors.proceso_lectura_id')
        ->join('users', 'users.id', '=', 'lectura_medidors.user_programado_id')
        ->join('personas', 'personas.id', '=', 'users.persona_id')
        ->join('medidors', 'medidors.id', '=', 'lectura_medidors.medidors_id')
        ->join('puesto_locals', 'puesto_locals.id', '=', 'medidors.puesto_local_id')
        ->join('zonas', 'zonas.id', '=', 'puesto_locals.zona_id')

        ->where('proceso_lecturas.id', $idProcesoLectura)
        ->where('lectura_medidors.borrado', '0')
        ->where('lectura_medidors.borrado', '0')

        ->orderBy('zonas.nombre')
        ->orderBy('puesto_locals.numero')
        ->orderBy('puesto_locals.nombre')

        ->select(
            'lectura_medidors.fecha_lectura',
            'lectura_medidors.estado',
            'lectura_medidors.lectura',
            'lectura_medidors.lectura_ultima',
            'lectura_medidors.consumo_kw',
            'lectura_medidors.lectura_consistente',
            'lectura_medidors.consumo_soles',

            'zonas.nombre as nombreZona',
            'puesto_locals.direccion as direccionPuestoLocal',

            'puesto_locals.nombre as nombrePuestoLocal',
            'puesto_locals.numero as numeroPuestoLocal',

            'medidors.serie as serieMedidor',

            'personas.nombres as nombresPersona',
            'personas.apellidos as apellidosPersona',

            'proceso_lecturas.orden_trabajo'
        );

        if($fechaRegistro != null && $fechaRegistro != ""){
            $query->whereRaw('date(lectura_medidors.fecha_lectura) = ?', [$fechaRegistro]);
        }
        if($ubicacion != null && $ubicacion != ""){
            $query->whereRaw('(zonas.nombre = ? OR puesto_locals.direccion = ?)', [$ubicacion, $ubicacion]);
        }
        if($serie != null && trim($serie, " ") != ""){
            $query->where('medidors.serie','like','%'.$serie.'%');
        }
        if($nombre != null && trim($nombre, " ") != ""){
            $query->whereRaw('(puesto_locals.nombre like ? OR puesto_locals.numero like ? )', ['%'.$nombre.'%', '%'.$nombre.'%']);
        }
        if($idtipouser == "5"){
            $puestoLocalPersona = PuestoLocalPersona::where('user_id', Auth::user()->id)->first();
            if($puestoLocalPersona != null){
                $query->where('puesto_locals.id', $puestoLocalPersona->puesto_local_id);
            }
        }


        $registrosimp=$query->get();

        return [
            'registrosimp'=>$registrosimp,
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

        $estado = '1';
        $anio = $request->anio;
        $mes = $request->mes;
        $fecha_generado = date('Y-m-d H:i:s');
        $user_genera_id = Auth::user()->id;
        $orden_trabajo = $request->orden_trabajo;
        $observaciones_generacion = $request->observaciones_generacion;

        $result='1';
        $msj='';
        $selector='';

        $contProcesoLectura0=ProcesoLectura::where('estado', '>=' ,'1')
                            ->where('estado', '<' ,'3')
                            ->count();

        $contProcesoLectura1=ProcesoLectura::where('estado', '>=' ,'1')
                            ->where('anio', $anio)
                            ->where('mes', $mes)
                            ->count();

        if ($contProcesoLectura0 > 0)
        {
            $result='0';
            $msj='Actualmente se encuentra un proceso de lectura en curso.';
            $selector='cbuanio';
        }
        elseif ($contProcesoLectura1 > 0)
        {
            $result='0';
            $msj='Ya se encuentra registrado un proceso de lectura para el año y mes seleccionado.';
            $selector='cbuanio';
        }
        else{

            $procesoLecturaLast = ProcesoLectura::where('estado','3')
                            ->orderBy('updated_at', 'desc')
                            ->take(1)
                            ->get();


            $registro = new ProcesoLectura;

            $registro->estado=$estado;
            $registro->anio=$anio;
            $registro->mes=$mes;
            $registro->fecha_generado=$fecha_generado;
            $registro->user_genera_id=$user_genera_id;
            $registro->observaciones_generacion=$observaciones_generacion;
            $registro->orden_trabajo=$orden_trabajo;

            $registro->save();

            $msj='Nuevo Proceso de Lectura Inicializado con Éxito';


            foreach ($procesoLecturaLast as $key => $dato) {
                
                $lecturasLast = LecturaMedidor::where('proceso_lectura_id', $dato->id)
                                ->where('estado', '>=' ,'1')
                                ->where('borrado', '0')
                                ->get();

                foreach ($lecturasLast as $key2 => $lectura) {

                    $registro2 = new LecturaMedidor;
                    $registro2->proceso_lectura_id=$registro->id;
                    $registro2->medidors_id=$lectura->medidors_id;
                    $registro2->estado=$estado;
                    $registro2->medidors_id=$lectura->medidors_id;
                    $registro2->borrado='0';
                    $registro2->user_programado_id=$lectura->user_programado_id;
                    $registro2->fecha_programacion=$fecha_generado;

                    $registro2->save();

                }
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
        ini_set('memory_limit','256M');
        ini_set('upload_max_filesize','20M');

        $estado = '1';
        $anio = $request->anio;
        $mes = $request->mes;
        $fecha_generado = date('Y-m-d H:i:s');
        $user_genera_id = Auth::user()->id;
        $orden_trabajo = $request->orden_trabajo;
        $observaciones_generacion = $request->observaciones_generacion;

        $result='1';
        $msj='';
        $selector='';

        $contProcesoLectura0=ProcesoLectura::where('estado', '>=' ,'1')
                            ->where('estado', '<' ,'3')
                            ->where('id', '!=' ,$id)
                            ->count();

        $contProcesoLectura1=ProcesoLectura::where('estado', '>=' ,'1')
                            ->where('anio', $anio)
                            ->where('mes', $mes)
                            ->where('id', '!=' ,$id)
                            ->count();

        if ($contProcesoLectura0 > 0)
        {
            $result='0';
            $msj='Actualmente se encuentra un proceso de lectura en curso.';
            $selector='cbuanioE';
        }
        elseif ($contProcesoLectura1 > 0)
        {
            $result='0';
            $msj='Ya se encuentra registrado un proceso de lectura para el año y mes seleccionado.';
            $selector='cbuanioE';
        }
        else{


            $registro = ProcesoLectura::findOrFail($id);

            
            $registro->anio=$anio;
            $registro->mes=$mes;
            $registro->user_genera_id=$user_genera_id;
            $registro->observaciones_generacion=$observaciones_generacion;
            $registro->orden_trabajo=$orden_trabajo;

            $registro->save();

            $msj='Proceso de Lectura Actualizado con Éxito';

        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    public function altabaja(Request $request)
    {
        $id = $request->id;
        $estadoProceso = $request->estadoProceso;
        $observacion = $request->observacion;
        $fecha = date('Y-m-d H:i:s');
        $user = Auth::user()->id;

        $result='1';
        $msj='';
        $selector='';

        $registro = ProcesoLectura::findOrFail($id);
        $registro->estado = $estadoProceso;

        if($estadoProceso == '0'){
            $registro->fecha_anulado = $fecha;
            $registro->user_anula_id = $user;
            $registro->observaciones_anulacion = $observacion;
        }
        elseif($estadoProceso == '1'){
            $registro->fecha_generado = $fecha;
            $registro->user_genera_id = $user;
            $registro->observaciones_generacion = $observacion;
        }
        elseif($estadoProceso == '2'){
            $registro->fecha_aprobado = $fecha;
            $registro->user_aprueba = $user;
            $registro->observaciones_aprobacion = $observacion;
        }
        elseif($estadoProceso == '3'){
            $registro->fecha_finalizado = $fecha;
            $registro->user_finaliza = $user;
            $registro->observaciones_finalizacion = $observacion;
        }


        $registro->save();

        if(strval($estadoProceso)=="0"){
            $msj='El Proceso de Lectura fue Anulado exitosamente';
        }elseif(strval($estadoProceso)=="1"){
            $msj='El Proceso de Lectura fue Generado exitosamente';
        }elseif(strval($estadoProceso)=="2"){
            $msj='El Proceso de Lectura fue Aprobado exitosamente';
        }elseif(strval($estadoProceso)=="3"){
            $msj='El Proceso de Lectura fue Finalizado exitosamente';
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
        //
    }

    public function export(Request $request) 
    {
        $fechaRegistro=$request->fechaRegistro;
        $idProcesoLectura=$request->idProcesoLectura;
        $serie=$request->serie;
        $idOperador=$request->idOperador;

        $procesoLectura=ProcesoLectura::find($idProcesoLectura);
        $procesoLectura->mesNombre = nombremes($procesoLectura->mes);

        $data=[];

        $titulo='REPORTE DE RUTAS';

        array_push($data, array($titulo));
        array_push($data, array(''));

        $cont = 1;

        $query = DB::table('proceso_lecturas')
        ->join('lectura_medidors', 'proceso_lecturas.id', '=', 'lectura_medidors.proceso_lectura_id')
        ->join('users', 'users.id', '=', 'lectura_medidors.user_programado_id')
        ->join('personas', 'personas.id', '=', 'users.persona_id')
        ->join('medidors', 'medidors.id', '=', 'lectura_medidors.medidors_id')
        ->join('puesto_locals', 'puesto_locals.id', '=', 'medidors.puesto_local_id')
        ->join('zonas', 'zonas.id', '=', 'puesto_locals.zona_id')

        ->where('proceso_lecturas.id', $idProcesoLectura)
        ->where('lectura_medidors.borrado', '0')
        ->where('lectura_medidors.borrado', '0')

        ->orderBy('zonas.nombre')
        ->orderBy('puesto_locals.numero')
        ->orderBy('puesto_locals.nombre')

        ->select(
            'lectura_medidors.fecha_programacion',

            'zonas.nombre as nombreZona',
            'puesto_locals.direccion as direccionPuestoLocal',

            'puesto_locals.nombre as nombrePuestoLocal',
            'puesto_locals.numero as numeroPuestoLocal',

            'medidors.serie as serieMedidor',

            'personas.nombres as nombresPersona',
            'personas.apellidos as apellidosPersona',

            'proceso_lecturas.orden_trabajo'
        );

        $usaFiltro = true;

        if($fechaRegistro != null && $fechaRegistro != ""){
            $query->whereRaw('date(lectura_medidors.fecha_programacion) = ?', [$fechaRegistro]);
            
        }
        if($serie != null && trim($serie, " ") != ""){
            $query->where('medidors.serie','like','%'.$serie.'%');
            
        }
        if($idOperador != null && $idOperador != "0"){
            $query->where('users.id',$idOperador);
        }

        $registrosimp=$query->get();

        if($usaFiltro){
            array_push($data, array('Filtros de Búsqueda:'));

                array_push($data, array('','Periodo de Lectura: ', $procesoLectura->mesNombre.', '.$procesoLectura->anio));
                $cont++;

            if($fechaRegistro != null && $fechaRegistro != ""){
                array_push($data, array('','Fecha de Asignación: ', pasFechaVista(substr($fechaRegistro, 0, 10))));
                $cont++;
            }
            if($serie != null && trim($serie, " ") != ""){
                array_push($data, array('','Serie de Medidor: ', $serie));
                $cont++;
            }
            if($idOperador != null && $idOperador != "0"){

                $operador = DB::table('users')
                    ->join('tipo_users', 'tipo_users.id', '=', 'users.tipo_user_id')
                    ->join('personas', 'personas.id', '=', 'users.persona_id')
                    ->join('trabajadors', 'trabajadors.user_id', '=', 'users.id')
                    ->where('users.id', $idOperador)
                    ->select(
                    DB::Raw("IFNULL( `users`.`id` , '0' ) as idUsers"),
                    DB::Raw("IFNULL( `users`.`name` , '' ) as nameUsers"),
                    DB::Raw("IFNULL( `users`.`email` , '' ) as emailUsers"),

                    DB::Raw("IFNULL( `tipo_users`.`id` , '0' ) as idTipo_users"),
                    DB::Raw("IFNULL( `tipo_users`.`nombre` , '' ) as nombreTipo_users"),
                    DB::Raw("IFNULL( `tipo_users`.`descripcion` , '' ) as descripcionTipo_users"),

                    DB::Raw("IFNULL( `personas`.`id` , '0' ) as idPersonas"),
                    DB::Raw("IFNULL( `personas`.`tipo` , '' ) as tipoPersonas"),
                    DB::Raw("IFNULL( `personas`.`tipo_documento` , '' ) as tipo_documentoPersonas"),
                    DB::Raw("IFNULL( `personas`.`num_documento` , '' ) as num_documentoPersonas"),
                    DB::Raw("IFNULL( `personas`.`apellidos` , '' ) as apellidosPersonas"),
                    DB::Raw("IFNULL( `personas`.`nombres` , '' ) as nombresPersonas"),
                    DB::Raw("IFNULL( `personas`.`telefono` , '' ) as telefonoPersonas"),
                    DB::Raw("IFNULL( `personas`.`direccion` , '' ) as direccionPersonas"),
                    DB::Raw("IFNULL( `personas`.`email` , '' ) as emailPersonas"),

                    DB::Raw("IFNULL( `trabajadors`.`id` , '0' ) as idTrabajadors"),
                    DB::Raw("IFNULL( `trabajadors`.`cargo` , '' ) as cargoTrabajadors"),
                    DB::Raw("IFNULL( `trabajadors`.`oficina_id` , '0' ) as oficina_idTrabajadors"),
                    )
                    ->first();
                array_push($data, array('','Lecturista Asignado: ', $operador->nombresPersonas.' '.$operador->apellidosPersonas));
                $cont++;
            }
            
        }
        else{
            array_push($data, array(''));
        }

        $cont = $cont + 3;



        array_push($data, array('N°','FECHA DE ASIGNACION', 'UBICACION PUESTO', 'NOMBRE PUESTO', 'SERIE MEDIDOR','RESPONSABLE DE TOMA DE LECTURA','ORDEN DE TRABAJO'));

        foreach ($registrosimp as $key => $dato) {
            array_push($data, array($key+1,
            pasFechaVista(substr($dato->fecha_programacion, 0, 10)).' '.substr($dato->fecha_programacion, 11),
                $dato->nombreZona.' '.$dato->direccionPuestoLocal,
                $dato->nombrePuestoLocal.' '.$dato->numeroPuestoLocal,
                $dato->serieMedidor,
                $dato->nombresPersona.' '.$dato->apellidosPersona,
                $dato->orden_trabajo,                       
            ));
        }

        $export = new Reporte4Export($data, $cont);

        return Excel::download($export, 'reporte_rutas.xlsx');
    }

    public function export2(Request $request) 
    {
        $ubicacion=$request->ubicacion;
        $idProcesoLectura=$request->idProcesoLectura;
        $serie=$request->serie;
        $nombre=$request->nombre;

        $procesoLectura=ProcesoLectura::find($idProcesoLectura);
        $procesoLectura->mesNombre = nombremes($procesoLectura->mes);

        $data=[];

        $titulo='REPORTE DE LIBRO DE LECTURAS';

        array_push($data, array($titulo));
        array_push($data, array(''));

        $cont = 1;

        $idtipouser=Auth::user()->tipo_user_id;

        $query = DB::table('proceso_lecturas')
        ->join('lectura_medidors', 'proceso_lecturas.id', '=', 'lectura_medidors.proceso_lectura_id')
        ->join('users', 'users.id', '=', 'lectura_medidors.user_programado_id')
        ->join('personas', 'personas.id', '=', 'users.persona_id')
        ->join('medidors', 'medidors.id', '=', 'lectura_medidors.medidors_id')
        ->join('puesto_locals', 'puesto_locals.id', '=', 'medidors.puesto_local_id')
        ->join('zonas', 'zonas.id', '=', 'puesto_locals.zona_id')

        ->leftjoin('imagens',  function($join) {
            $join->on('imagens.lectura_medidor_id', '=', 'lectura_medidors.id');
            $join->on('imagens.activo', '=', DB::raw('1'));
            $join->on('imagens.borrado', '=', DB::raw('0'));
        })

        ->where('proceso_lecturas.id', $idProcesoLectura)
        ->where('lectura_medidors.borrado', '0')
        ->where('lectura_medidors.borrado', '0')

        ->orderBy('zonas.nombre')
        ->orderBy('puesto_locals.numero')
        ->orderBy('puesto_locals.nombre')

        ->select(
            'lectura_medidors.fecha_lectura',
            'lectura_medidors.estado',
            'lectura_medidors.lectura',

            'zonas.nombre as nombreZona',
            'puesto_locals.direccion as direccionPuestoLocal',

            'puesto_locals.nombre as nombrePuestoLocal',
            'puesto_locals.numero as numeroPuestoLocal',

            'medidors.serie as serieMedidor',

            'personas.nombres as nombresPersona',
            'personas.apellidos as apellidosPersona',

            'proceso_lecturas.orden_trabajo',

            DB::Raw("IFNULL( `imagens`.`id` , '0' ) as idImagens"),
            DB::Raw("IFNULL( `imagens`.`ruta_img` , '' ) as ruta_imgImagens"),
        );

        $usaFiltro = true;

        if($ubicacion != null && $ubicacion != ""){
            $query->whereRaw('(zonas.nombre = ? OR puesto_locals.direccion = ?)', [$ubicacion, $ubicacion]);
        }
        if($serie != null && trim($serie, " ") != ""){
            $query->where('medidors.serie','like','%'.$serie.'%');
        }
        if($nombre != null && trim($nombre, " ") != ""){
            $query->whereRaw('(puesto_locals.nombre like ? OR puesto_locals.numero like ? )', ['%'.$nombre.'%', '%'.$nombre.'%']);
        }
        if($idtipouser == "5"){
            $puestoLocalPersona = PuestoLocalPersona::where('user_id', Auth::user()->id)->first();
            if($puestoLocalPersona != null){
                $query->where('puesto_locals.id', $puestoLocalPersona->puesto_local_id);
            }
        }

        $registrosimp=$query->get();

        if($usaFiltro){
            array_push($data, array('Filtros de Búsqueda:'));

                array_push($data, array('','Periodo de Lectura: ', $procesoLectura->mesNombre.', '.$procesoLectura->anio));
                $cont++;

            if($ubicacion != null && $ubicacion != ""){
                array_push($data, array('','Ubicación del Puesto: ', $ubicacion));
                $cont++;
            }
            if($nombre != null && $nombre != ""){
                array_push($data, array('','Nombre del Puesto: ', $nombre));
                $cont++;
            }
            if($serie != null && trim($serie, " ") != ""){
                array_push($data, array('','Serie de Medidor: ', $serie));
                $cont++;
            }            
        }
        else{
            array_push($data, array(''));
        }

        $cont = $cont + 3;



        array_push($data, array('N°','FECHA DE LECTURA', 'UBICACION PUESTO', 'NOMBRE PUESTO', 'SERIE MEDIDOR','ULTIMA LECTURA KW','FOTOGRAFIA'));

        foreach ($registrosimp as $key => $dato) {
            array_push($data, array($key+1,
            pasFechaVista(substr($dato->fecha_lectura, 0, 10)).' '.substr($dato->fecha_lectura, 11),
                $dato->nombreZona.' '.$dato->direccionPuestoLocal,
                $dato->nombrePuestoLocal.' '.$dato->numeroPuestoLocal,
                $dato->serieMedidor,
                $dato->estado != '1' ? number_format(floatval($dato->lectura), 2, '.', '') : '',                    
            ));
        }

        $export = new Reporte5Export($data, $cont, $registrosimp);

        return Excel::download($export, 'reporte_libro_lecturas.xlsx');
    }

    public function export3(Request $request) 
    {
        $fechaRegistro=$request->fechaRegistro;
        $ubicacion=$request->ubicacion;
        $idProcesoLectura=$request->idProcesoLectura;
        $serie=$request->serie;
        $nombre=$request->nombre;

        $procesoLectura=ProcesoLectura::find($idProcesoLectura);
        $procesoLectura->mesNombre = nombremes($procesoLectura->mes);

        $data=[];

        $titulo='REPORTE DE CÁLCULO DE CONSUMOS';

        array_push($data, array($titulo));
        array_push($data, array(''));

        $cont = 1;

        $idtipouser=Auth::user()->tipo_user_id;

        $query = DB::table('proceso_lecturas')
        ->join('lectura_medidors', 'proceso_lecturas.id', '=', 'lectura_medidors.proceso_lectura_id')
        ->join('users', 'users.id', '=', 'lectura_medidors.user_programado_id')
        ->join('personas', 'personas.id', '=', 'users.persona_id')
        ->join('medidors', 'medidors.id', '=', 'lectura_medidors.medidors_id')
        ->join('puesto_locals', 'puesto_locals.id', '=', 'medidors.puesto_local_id')
        ->join('zonas', 'zonas.id', '=', 'puesto_locals.zona_id')

        ->where('proceso_lecturas.id', $idProcesoLectura)
        ->where('lectura_medidors.borrado', '0')
        ->where('lectura_medidors.borrado', '0')

        ->orderBy('zonas.nombre')
        ->orderBy('puesto_locals.numero')
        ->orderBy('puesto_locals.nombre')

        ->select(
            'lectura_medidors.fecha_lectura',
            'lectura_medidors.estado',
            'lectura_medidors.lectura',
            'lectura_medidors.lectura_ultima',
            'lectura_medidors.consumo_kw',
            'lectura_medidors.lectura_consistente',
            'lectura_medidors.consumo_soles',

            'zonas.nombre as nombreZona',
            'puesto_locals.direccion as direccionPuestoLocal',

            'puesto_locals.nombre as nombrePuestoLocal',
            'puesto_locals.numero as numeroPuestoLocal',

            'medidors.serie as serieMedidor',

            'personas.nombres as nombresPersona',
            'personas.apellidos as apellidosPersona',

            'proceso_lecturas.orden_trabajo'
        );

        $usaFiltro = true;

        if($fechaRegistro != null && $fechaRegistro != ""){
            $query->whereRaw('date(lectura_medidors.fecha_lectura) = ?', [$fechaRegistro]);
        }
        if($ubicacion != null && $ubicacion != ""){
            $query->whereRaw('(zonas.nombre = ? OR puesto_locals.direccion = ?)', [$ubicacion, $ubicacion]);
        }
        if($serie != null && trim($serie, " ") != ""){
            $query->where('medidors.serie','like','%'.$serie.'%');
        }
        if($nombre != null && trim($nombre, " ") != ""){
            $query->whereRaw('(puesto_locals.nombre like ? OR puesto_locals.numero like ? )', ['%'.$nombre.'%', '%'.$nombre.'%']);
        }
        if($idtipouser == "5"){
            $puestoLocalPersona = PuestoLocalPersona::where('user_id', Auth::user()->id)->first();
            if($puestoLocalPersona != null){
                $query->where('puesto_locals.id', $puestoLocalPersona->puesto_local_id);
            }
        }

        $registrosimp=$query->get();

        if($usaFiltro){
            array_push($data, array('Filtros de Búsqueda:'));

            array_push($data, array('','Periodo de Lectura: ', $procesoLectura->mesNombre.', '.$procesoLectura->anio));
            $cont++;

            if($fechaRegistro != null && $fechaRegistro != ""){
                array_push($data, array('','Fecha de Registro: ', pasFechaVista(substr($fechaRegistro, 0, 10))));
                $cont++;
            }

            if($ubicacion != null && $ubicacion != ""){
                array_push($data, array('','Ubicación del Puesto: ', $ubicacion));
                $cont++;
            }
            if($nombre != null && $nombre != ""){
                array_push($data, array('','Nombre del Puesto: ', $nombre));
                $cont++;
            }
            if($serie != null && trim($serie, " ") != ""){
                array_push($data, array('','Serie de Medidor: ', $serie));
                $cont++;
            }            
        }
        else{
            array_push($data, array(''));
        }

        $cont = $cont + 3;



        array_push($data, array('N°', 'UBICACION PUESTO', 'NOMBRE PUESTO', 'SERIE MEDIDOR','LECTURA ANTERIOR', 'LECTURA ACTUAL', 'CONSUMO KW', 'RESULTADO', 'CONSUMO S/', 'FECHA DE REGISTRO'));

        foreach ($registrosimp as $key => $dato) {
            array_push($data, array($key+1,
                $dato->nombreZona.' '.$dato->direccionPuestoLocal,
                $dato->nombrePuestoLocal.' '.$dato->numeroPuestoLocal,
                $dato->serieMedidor,
                $dato->estado != '1' ? number_format(floatval($dato->lectura_ultima), 2, '.', '') : '',                    
                $dato->estado != '1' ? number_format(floatval($dato->lectura), 2, '.', '') : '',                    
                $dato->estado != '1' ? number_format(floatval($dato->consumo_kw), 2, '.', '') : '',                    
                (($dato->estado != '1' && $dato->lectura_consistente == '0' ? 'INCONSISTENTE' : $dato->estado != '1' && $dato->lectura_consistente == '1') ? 'CONSISTENTE' : $dato->estado != '1' && $dato->lectura_consistente == '2') ? 'VALIDAR' : '',                    
                $dato->estado != '1' ? number_format(floatval($dato->consumo_soles), 2, '.', '') : '',                    
                $dato->estado != '1' ? pasFechaVista(substr($dato->fecha_lectura, 0, 10)).' '.substr($dato->fecha_lectura, 11) : 'LECTURA AUN NO TOMADA',                    
            ));
        }

        $export = new Reporte6Export($data, $cont);

        return Excel::download($export, 'reporte_calculo_consumos.xlsx');
    }
}

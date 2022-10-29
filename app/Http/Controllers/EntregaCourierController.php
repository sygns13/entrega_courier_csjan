<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;

use App\Tipouser;
use App\User;

use App\EntregaCourier;
use App\UserPermiso;
use App\Dependencia;

use App\Exports\Reporte2Export;
use Maatwebsite\Excel\Facades\Excel;

use stdClass;
use DB;
use Storage;
set_time_limit(600);

class EntregaCourierController extends Controller
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
            $dependencias=Dependencia::where('activo','1')->where('borrado','0')->orderBy('meta')->orderBy('nombre')->orderBy('id')->get();
            $permiso1 = UserPermiso::where('user_id', Auth::user()->id)->where('permiso_id', '1')->first();
            $permiso2 = UserPermiso::where('user_id', Auth::user()->id)->where('permiso_id', '2')->first();

            $modulo="formulario1";

            return view('formulario1.index',compact('tipouser','modulo', 'permiso1', 'permiso2', 'dependencias'));
        }
        else
        {
            return redirect('home');    
        }
    }

    public function index2()
    {
        if(accesoUser([1,2])){


            $idtipouser=Auth::user()->tipo_user_id;
            $tipouser=Tipouser::find($idtipouser);
            $dependencias=Dependencia::where('activo','1')->where('borrado','0')->orderBy('meta')->orderBy('nombre')->orderBy('id')->get();
            $permiso1 = UserPermiso::where('user_id', Auth::user()->id)->where('permiso_id', '1')->first();
            $permiso2 = UserPermiso::where('user_id', Auth::user()->id)->where('permiso_id', '2')->first();

            $modulo="formulario2";

            return view('formulario2.index',compact('tipouser','modulo', 'permiso1', 'permiso2', 'dependencias'));
        }
        else
        {
            return redirect('home');    
        }
    }

    public function index3()
    {
        if(accesoUser([1,2])){


            $idtipouser=Auth::user()->tipo_user_id;
            $tipouser=Tipouser::find($idtipouser);
            $dependencias=Dependencia::where('activo','1')->where('borrado','0')->orderBy('meta')->orderBy('nombre')->orderBy('id')->get();
            $permiso1 = UserPermiso::where('user_id', Auth::user()->id)->where('permiso_id', '1')->first();
            $permiso2 = UserPermiso::where('user_id', Auth::user()->id)->where('permiso_id', '2')->first();

            $modulo="reporte2";

            return view('reporte2.index',compact('tipouser','modulo', 'permiso1', 'permiso2', 'dependencias'));
        }
        else
        {
            return redirect('home');    
        }
    }

    public function index(Request $request)
    {
        $buscar=$request->busca;

        $queryZero=DB::table('entrega_curriers')
        ->join('dependencias', 'dependencias.id', '=', 'entrega_curriers.dependencia_id')
        ->where('entrega_curriers.borrado','0')
        ->where(function($query) use ($buscar){
            $query->where('entrega_curriers.codigo_registro','like','%'.$buscar.'%');
            $query->orWhere('entrega_curriers.origen_sobre','like','%'.$buscar.'%');
            $query->orWhere('entrega_curriers.numero_documento','like','%'.$buscar.'%');
            $query->orWhere('entrega_curriers.expediente','like','%'.$buscar.'%');
            $query->orWhere('entrega_curriers.fecha_ingreso','like','%'.$buscar.'%');
            $query->orWhere('entrega_curriers.provincia','like','%'.$buscar.'%');
            $query->orWhere('entrega_curriers.dependencia','like','%'.$buscar.'%');
            $query->orWhere('entrega_curriers.direccion','like','%'.$buscar.'%');
            $query->orWhere('entrega_curriers.tipo_envio','like','%'.$buscar.'%');
            $query->orWhere('entrega_curriers.detalle_envio','like','%'.$buscar.'%');
            $query->orWhere('entrega_curriers.orden_servicio','like','%'.$buscar.'%');
            $query->orWhere('dependencias.nombre','like','%'.$buscar.'%');
            $query->orWhere('dependencias.meta','like','%'.$buscar.'%');
            });

        if(Auth::user()->tipo_user_id == '2'){
            $queryZero->where('entrega_curriers.user_id_registro1', Auth::user()->id)->orWhere('entrega_curriers.user_id_registro2', Auth::user()->id);
        }


        $registros = $queryZero
        ->orderBy('entrega_curriers.codigo_registro')
        ->orderBy('entrega_curriers.id')
        ->select(
            'entrega_curriers.id',
            'entrega_curriers.codigo_registro',
            'entrega_curriers.cantidad_sobres',
            'entrega_curriers.origen_sobre',
            'entrega_curriers.numero_documento',
            'entrega_curriers.expediente',
            'entrega_curriers.telefono_origen',
            'entrega_curriers.fecha_ingreso',
            'entrega_curriers.provincia',
            'entrega_curriers.dependencia',
            'entrega_curriers.direccion',
            'entrega_curriers.tipo_envio',
            'entrega_curriers.detalle_envio',
            'entrega_curriers.fecha_entrega',
            'entrega_curriers.orden_servicio',
            'entrega_curriers.observacion',
            'entrega_curriers.user_id_registro1',
            'entrega_curriers.ip_registro1',
            'entrega_curriers.fecha_registro1',
            'entrega_curriers.hora_registro1',
            'entrega_curriers.user_id_registro2',
            'entrega_curriers.ip_registro2',
            'entrega_curriers.fecha_registro2',
            'entrega_curriers.hora_registro2',
            'entrega_curriers.borrado',
            'entrega_curriers.created_at',
            'entrega_curriers.updated_at',
            'entrega_curriers.dependencia_id',

            'dependencias.id as idDependencia',
            'dependencias.nombre as nombreDependencia',
            'dependencias.meta as metaDependencia',
            'dependencias.telefono as telefonoDependencia',
            'dependencias.activo as activoDependencia',
        )
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

    public function buscarDatos(Request $request)
    {
        $fecha_ingresoIni=$request->fecha_ingresoIni;
        $fecha_ingresoFin=$request->fecha_ingresoFin;
        $codigo_registro=$request->codigo_registro;
        $origen_sobre=$request->origen_sobre;
        $expediente=$request->expediente;
        $telefono_origen=$request->telefono_origen;
        $tipo_envio=$request->tipo_envio;
        $detalle_envio=$request->detalle_envio;
        $orden_servicio=$request->orden_servicio;
        $fecha_entregaIni=$request->fecha_entregaIni;
        $fecha_entregaFin=$request->fecha_entregaFin;
        $username1=$request->username1;
        $username2=$request->username2;
        $dependencia_id=$request->dependencia_id;


        $buscar="";

        $query = DB::table('entrega_curriers')
        ->join('users as user1', 'user1.id', '=', 'entrega_curriers.user_id_registro1')
        ->join('dependencias', 'dependencias.id', '=', 'entrega_curriers.dependencia_id')
        ->leftjoin('users as user2',  function($join) {
            $join->on('user2.id', '=', 'entrega_curriers.user_id_registro2');
            //$join->on('imagens.activo', '=', DB::raw('1'));
            //$join->on('imagens.borrado', '=', DB::raw('0'));
        })

        ->where('entrega_curriers.borrado', '0')
        ->orderBy('entrega_curriers.codigo_registro')
        ->orderBy('entrega_curriers.id')

        ->select(
                'entrega_curriers.id',
                'entrega_curriers.codigo_registro',
                'entrega_curriers.cantidad_sobres',
                'entrega_curriers.origen_sobre',
                'entrega_curriers.numero_documento',
                'entrega_curriers.expediente',
                'entrega_curriers.telefono_origen',
                'entrega_curriers.fecha_ingreso',
                'entrega_curriers.provincia',
                'entrega_curriers.dependencia',
                'entrega_curriers.direccion',
                'entrega_curriers.tipo_envio',
                'entrega_curriers.detalle_envio',
                'entrega_curriers.fecha_entrega',
                'entrega_curriers.orden_servicio',
                'entrega_curriers.observacion',
                'entrega_curriers.user_id_registro1',
                'entrega_curriers.ip_registro1',
                'entrega_curriers.fecha_registro1',
                'entrega_curriers.hora_registro1',
                'entrega_curriers.user_id_registro2',
                'entrega_curriers.ip_registro2',
                'entrega_curriers.fecha_registro2',
                'entrega_curriers.hora_registro2',
                'entrega_curriers.borrado',
                'entrega_curriers.created_at',
                'entrega_curriers.updated_at',
                'entrega_curriers.dependencia_id',

                'user1.id',
                'user1.name as name1',
                'user1.email',
                'user1.tipo_user_id',
                'user1.persona_id',

                'dependencias.id as idDependencia',
                'dependencias.nombre as nombreDependencia',
                'dependencias.meta as metaDependencia',
                'dependencias.telefono as telefonoDependencia',
                'dependencias.activo as activoDependencia',

                DB::Raw("IFNULL( `user2`.`id` , '' ) as id_user2"),
                DB::Raw("IFNULL( `user2`.`name` , '' ) as name2"),
                DB::Raw("IFNULL( `user2`.`email` , '' ) as email_user2"),
                DB::Raw("IFNULL( `user2`.`activo` , '' ) as activo_user2"),
                DB::Raw("IFNULL( `user2`.`tipo_user_id` , '' ) as tipo_user_id_user2"),
                DB::Raw("IFNULL( `user2`.`persona_id` , '' ) as persona_id_user2")
        );

        if($fecha_ingresoIni != null && $fecha_ingresoIni != ""){
            $query->whereRaw('date(entrega_curriers.fecha_ingreso) >= ?', [$fecha_ingresoIni]);
        }
        if($fecha_ingresoFin != null && $fecha_ingresoFin != ""){
            $query->whereRaw('date(entrega_curriers.fecha_ingreso) <= ?', [$fecha_ingresoFin]);
        }
        if($codigo_registro != null && trim($codigo_registro, " ") != ""){
            $query->where('entrega_curriers.codigo_registro','like','%'.$codigo_registro.'%');
        }
        if($origen_sobre != null && trim($origen_sobre, " ") != ""){
            $query->where('entrega_curriers.origen_sobre','like','%'.$origen_sobre.'%');
        }
        if($expediente != null && trim($expediente, " ") != ""){
            $query->where('entrega_curriers.expediente','like','%'.$expediente.'%');
        }
        if($telefono_origen != null && trim($telefono_origen, " ") != ""){
            $query->where('entrega_curriers.telefono_origen','like','%'.$telefono_origen.'%');
        }
        if($tipo_envio != null && trim($tipo_envio, " ") != ""){
            $query->where('entrega_curriers.tipo_envio','like','%'.$tipo_envio.'%');
        }
        if($detalle_envio != null && trim($detalle_envio, " ") != ""){
            $query->where('entrega_curriers.detalle_envio','like','%'.$detalle_envio.'%');
        }
        if($orden_servicio != null && trim($orden_servicio, " ") != ""){
            $query->where('entrega_curriers.orden_servicio','like','%'.$orden_servicio.'%');
        }
        if($fecha_entregaIni != null && $fecha_entregaIni != ""){
            $query->whereRaw('date(entrega_curriers.fecha_entrega) >= ?', [$fecha_entregaIni]);
        }
        if($fecha_entregaFin != null && $fecha_entregaFin != ""){
            $query->whereRaw('date(entrega_curriers.fecha_entrega) <= ?', [$fecha_entregaFin]);
        }
        if($username1 != null && $username1 != ""){
            $query->where('user1.name','like','%'.$username1.'%');
        }
        if($username2 != null && $username2 != ""){
            $query->where('user2.name','like','%'.$username2.'%');
        }

        $dependencia = null;
        if($dependencia_id != null && $dependencia_id != "0"){
            $query->where('entrega_curriers.dependencia_id', $dependencia_id);
            $dependencia = Dependencia::find($dependencia_id);
        }

        if(Auth::user()->tipo_user_id == '2'){
            $query->where('entrega_curriers.user_id_registro1', Auth::user()->id)->orWhere('entrega_curriers.user_id_registro2', Auth::user()->id);
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
            'dependencia'=>$dependencia,
        ];

    }

    public function buscarDatosImp(Request $request)
    {
        $fecha_ingresoIni=$request->fecha_ingresoIni;
        $fecha_ingresoFin=$request->fecha_ingresoFin;
        $codigo_registro=$request->codigo_registro;
        $origen_sobre=$request->origen_sobre;
        $expediente=$request->expediente;
        $telefono_origen=$request->telefono_origen;
        $tipo_envio=$request->tipo_envio;
        $detalle_envio=$request->detalle_envio;
        $orden_servicio=$request->orden_servicio;
        $fecha_entregaIni=$request->fecha_entregaIni;
        $fecha_entregaFin=$request->fecha_entregaFin;
        $username1=$request->username1;
        $username2=$request->username2;
        $dependencia_id=$request->dependencia_id;

        $buscar="";

        $query = DB::table('entrega_curriers')
        ->join('users as user1', 'user1.id', '=', 'entrega_curriers.user_id_registro1')
        ->join('dependencias', 'dependencias.id', '=', 'entrega_curriers.dependencia_id')
        ->leftjoin('users as user2',  function($join) {
            $join->on('user2.id', '=', 'entrega_curriers.user_id_registro2');
            //$join->on('imagens.activo', '=', DB::raw('1'));
            //$join->on('imagens.borrado', '=', DB::raw('0'));
        })

        ->where('entrega_curriers.borrado', '0')
        ->orderBy('entrega_curriers.codigo_registro')
        ->orderBy('entrega_curriers.id')

        ->select(
                'entrega_curriers.id',
                'entrega_curriers.codigo_registro',
                'entrega_curriers.cantidad_sobres',
                'entrega_curriers.origen_sobre',
                'entrega_curriers.numero_documento',
                'entrega_curriers.expediente',
                'entrega_curriers.telefono_origen',
                'entrega_curriers.fecha_ingreso',
                'entrega_curriers.provincia',
                'entrega_curriers.dependencia',
                'entrega_curriers.direccion',
                'entrega_curriers.tipo_envio',
                'entrega_curriers.detalle_envio',
                'entrega_curriers.fecha_entrega',
                'entrega_curriers.orden_servicio',
                'entrega_curriers.observacion',
                'entrega_curriers.user_id_registro1',
                'entrega_curriers.ip_registro1',
                'entrega_curriers.fecha_registro1',
                'entrega_curriers.hora_registro1',
                'entrega_curriers.user_id_registro2',
                'entrega_curriers.ip_registro2',
                'entrega_curriers.fecha_registro2',
                'entrega_curriers.hora_registro2',
                'entrega_curriers.borrado',
                'entrega_curriers.created_at',
                'entrega_curriers.updated_at',
                'entrega_curriers.dependencia_id',

                'user1.id',
                'user1.name as name1',
                'user1.email',
                'user1.tipo_user_id',
                'user1.persona_id',

                'dependencias.id as idDependencia',
                'dependencias.nombre as nombreDependencia',
                'dependencias.meta as metaDependencia',
                'dependencias.telefono as telefonoDependencia',
                'dependencias.activo as activoDependencia',

                DB::Raw("IFNULL( `user2`.`id` , '' ) as id_user2"),
                DB::Raw("IFNULL( `user2`.`name` , '' ) as name2"),
                DB::Raw("IFNULL( `user2`.`email` , '' ) as email_user2"),
                DB::Raw("IFNULL( `user2`.`activo` , '' ) as activo_user2"),
                DB::Raw("IFNULL( `user2`.`tipo_user_id` , '' ) as tipo_user_id_user2"),
                DB::Raw("IFNULL( `user2`.`persona_id` , '' ) as persona_id_user2")
        );

        if($fecha_ingresoIni != null && $fecha_ingresoIni != ""){
            $query->whereRaw('date(entrega_curriers.fecha_ingreso) >= ?', [$fecha_ingresoIni]);
        }
        if($fecha_ingresoFin != null && $fecha_ingresoFin != ""){
            $query->whereRaw('date(entrega_curriers.fecha_ingreso) <= ?', [$fecha_ingresoFin]);
        }
        if($codigo_registro != null && trim($codigo_registro, " ") != ""){
            $query->where('entrega_curriers.codigo_registro','like','%'.$codigo_registro.'%');
        }
        if($origen_sobre != null && trim($origen_sobre, " ") != ""){
            $query->where('entrega_curriers.origen_sobre','like','%'.$origen_sobre.'%');
        }
        if($expediente != null && trim($expediente, " ") != ""){
            $query->where('entrega_curriers.expediente','like','%'.$expediente.'%');
        }
        if($telefono_origen != null && trim($telefono_origen, " ") != ""){
            $query->where('entrega_curriers.telefono_origen','like','%'.$telefono_origen.'%');
        }
        if($tipo_envio != null && trim($tipo_envio, " ") != ""){
            $query->where('entrega_curriers.tipo_envio','like','%'.$tipo_envio.'%');
        }
        if($detalle_envio != null && trim($detalle_envio, " ") != ""){
            $query->where('entrega_curriers.detalle_envio','like','%'.$detalle_envio.'%');
        }
        if($orden_servicio != null && trim($orden_servicio, " ") != ""){
            $query->where('entrega_curriers.orden_servicio','like','%'.$orden_servicio.'%');
        }
        if($fecha_entregaIni != null && $fecha_entregaIni != ""){
            $query->whereRaw('date(entrega_curriers.fecha_entrega) >= ?', [$fecha_entregaIni]);
        }
        if($fecha_entregaFin != null && $fecha_entregaFin != ""){
            $query->whereRaw('date(entrega_curriers.fecha_entrega) <= ?', [$fecha_entregaFin]);
        }
        if($username1 != null && $username1 != ""){
            $query->where('user1.name','like','%'.$username1.'%');
        }
        if($username2 != null && $username2 != ""){
            $query->where('user2.name','like','%'.$username2.'%');
        }

        $dependencia = null;
        if($dependencia_id != null && $dependencia_id != "0"){
            $query->where('entrega_curriers.dependencia_id', $dependencia_id);
            $dependencia = Dependencia::find($dependencia_id);
        }

        if(Auth::user()->tipo_user_id == '2'){
            $query->where('entrega_curriers.user_id_registro1', Auth::user()->id)->orWhere('entrega_curriers.user_id_registro2', Auth::user()->id);
        }

        $registrosimp=$query->get();

        return [
            'registrosimp'=>$registrosimp,
            'dependencia'=>$dependencia,
        ];

    }

    public function export(Request $request) 
    {
        $fecha_ingresoIni=$request->fecha_ingresoIni;
        $fecha_ingresoFin=$request->fecha_ingresoFin;
        $codigo_registro=$request->codigo_registro;
        $origen_sobre=$request->origen_sobre;
        $expediente=$request->expediente;
        $telefono_origen=$request->telefono_origen;
        $tipo_envio=$request->tipo_envio;
        $detalle_envio=$request->detalle_envio;
        $orden_servicio=$request->orden_servicio;
        $fecha_entregaIni=$request->fecha_entregaIni;
        $fecha_entregaFin=$request->fecha_entregaFin;
        $username1=$request->username1;
        $username2=$request->username2;
        $dependencia_id=$request->dependencia_id;

        $data=[];

        $titulo='REPORTE GENERAL DE ENTREGA COURIER';

        array_push($data, array($titulo));
        array_push($data, array(''));

        $cont = 1;

        $query = DB::table('entrega_curriers')
        ->join('users as user1', 'user1.id', '=', 'entrega_curriers.user_id_registro1')
        ->join('dependencias', 'dependencias.id', '=', 'entrega_curriers.dependencia_id')
        ->leftjoin('users as user2',  function($join) {
            $join->on('user2.id', '=', 'entrega_curriers.user_id_registro2');
            //$join->on('imagens.activo', '=', DB::raw('1'));
            //$join->on('imagens.borrado', '=', DB::raw('0'));
        })

        ->where('entrega_curriers.borrado', '0')
        ->orderBy('entrega_curriers.codigo_registro')
        ->orderBy('entrega_curriers.id')

        ->select(
                'entrega_curriers.id',
                'entrega_curriers.codigo_registro',
                'entrega_curriers.cantidad_sobres',
                'entrega_curriers.origen_sobre',
                'entrega_curriers.numero_documento',
                'entrega_curriers.expediente',
                'entrega_curriers.telefono_origen',
                'entrega_curriers.fecha_ingreso',
                'entrega_curriers.provincia',
                'entrega_curriers.dependencia',
                'entrega_curriers.direccion',
                'entrega_curriers.tipo_envio',
                'entrega_curriers.detalle_envio',
                'entrega_curriers.fecha_entrega',
                'entrega_curriers.orden_servicio',
                'entrega_curriers.observacion',
                'entrega_curriers.user_id_registro1',
                'entrega_curriers.ip_registro1',
                'entrega_curriers.fecha_registro1',
                'entrega_curriers.hora_registro1',
                'entrega_curriers.user_id_registro2',
                'entrega_curriers.ip_registro2',
                'entrega_curriers.fecha_registro2',
                'entrega_curriers.hora_registro2',
                'entrega_curriers.borrado',
                'entrega_curriers.created_at',
                'entrega_curriers.updated_at',
                'entrega_curriers.dependencia_id',

                'user1.id',
                'user1.name as name1',
                'user1.email',
                'user1.tipo_user_id',
                'user1.persona_id',

                'dependencias.id as idDependencia',
                'dependencias.nombre as nombreDependencia',
                'dependencias.meta as metaDependencia',
                'dependencias.telefono as telefonoDependencia',
                'dependencias.activo as activoDependencia',

                DB::Raw("IFNULL( `user2`.`id` , '' ) as id_user2"),
                DB::Raw("IFNULL( `user2`.`name` , '' ) as name2"),
                DB::Raw("IFNULL( `user2`.`email` , '' ) as email_user2"),
                DB::Raw("IFNULL( `user2`.`activo` , '' ) as activo_user2"),
                DB::Raw("IFNULL( `user2`.`tipo_user_id` , '' ) as tipo_user_id_user2"),
                DB::Raw("IFNULL( `user2`.`persona_id` , '' ) as persona_id_user2")
        );

        $usaFiltro = false;

        if($fecha_ingresoIni != null && $fecha_ingresoIni != ""){
            $query->whereRaw('date(entrega_curriers.fecha_ingreso) >= ?', [$fecha_ingresoIni]);
            $usaFiltro = true;
        }
        if($fecha_ingresoFin != null && $fecha_ingresoFin != ""){
            $query->whereRaw('date(entrega_curriers.fecha_ingreso) <= ?', [$fecha_ingresoFin]);
            $usaFiltro = true;
        }
        if($codigo_registro != null && trim($codigo_registro, " ") != ""){
            $query->where('entrega_curriers.codigo_registro','like','%'.$codigo_registro.'%');
            $usaFiltro = true;
        }
        if($origen_sobre != null && trim($origen_sobre, " ") != ""){
            $query->where('entrega_curriers.origen_sobre','like','%'.$origen_sobre.'%');
            $usaFiltro = true;
        }
        if($expediente != null && trim($expediente, " ") != ""){
            $query->where('entrega_curriers.expediente','like','%'.$expediente.'%');
            $usaFiltro = true;
        }
        if($telefono_origen != null && trim($telefono_origen, " ") != ""){
            $query->where('entrega_curriers.telefono_origen','like','%'.$telefono_origen.'%');
            $usaFiltro = true;
        }
        if($tipo_envio != null && trim($tipo_envio, " ") != ""){
            $query->where('entrega_curriers.tipo_envio','like','%'.$tipo_envio.'%');
            $usaFiltro = true;
        }
        if($detalle_envio != null && trim($detalle_envio, " ") != ""){
            $query->where('entrega_curriers.detalle_envio','like','%'.$detalle_envio.'%');
            $usaFiltro = true;
        }
        if($orden_servicio != null && trim($orden_servicio, " ") != ""){
            $query->where('entrega_curriers.orden_servicio','like','%'.$orden_servicio.'%');
            $usaFiltro = true;
        }
        if($fecha_entregaIni != null && $fecha_entregaIni != ""){
            $query->whereRaw('date(entrega_curriers.fecha_entrega) >= ?', [$fecha_entregaIni]);
            $usaFiltro = true;
        }
        if($fecha_entregaFin != null && $fecha_entregaFin != ""){
            $query->whereRaw('date(entrega_curriers.fecha_entrega) <= ?', [$fecha_entregaFin]);
            $usaFiltro = true;
        }
        if($username1 != null && $username1 != ""){
            $query->where('user1.name','like','%'.$username1.'%');
            $usaFiltro = true;
        }
        if($username2 != null && $username2 != ""){
            $query->where('user2.name','like','%'.$username2.'%');
            $usaFiltro = true;
        }
        if($dependencia_id != null && $dependencia_id != "0"){
            $query->where('entrega_curriers.dependencia_id', $dependencia_id);
        }

        if(Auth::user()->tipo_user_id == '2'){
            $query->where('entrega_curriers.user_id_registro1', Auth::user()->id)->orWhere('entrega_curriers.user_id_registro2', Auth::user()->id);
        }

        $registrosimp=$query->get();

        if($usaFiltro){
            array_push($data, array('Filtros de Búsqueda:'));

            if($fecha_ingresoIni != null && $fecha_ingresoIni != ""){
                array_push($data, array('','Fecha Inicial de Ingreso: ', pasFechaVista(substr($fecha_ingresoIni, 0, 10))));
                $cont++;
            }
            if($fecha_ingresoFin != null && $fecha_ingresoFin != ""){
                array_push($data, array('','Fecha Final de Ingreso: ', pasFechaVista(substr($fecha_ingresoFin, 0, 10))));
                $cont++;
            }
            if($codigo_registro != null && trim($codigo_registro, " ") != ""){
                array_push($data, array('','Código de Único de Registro: ', $codigo_registro));
                $cont++;
            }            
            if($dependencia_id != null && trim($dependencia_id, " ") != "0"){

                $dependencia = Dependencia::find($dependencia_id);
                array_push($data, array('','Origen del Sobre: ', $dependencia->nombre));
                $cont++;
            }            
            if($expediente != null && trim($expediente, " ") != ""){
                array_push($data, array('','Expediente: ', $expediente));
                $cont++;
            }            
            if($telefono_origen != null && trim($telefono_origen, " ") != ""){
                array_push($data, array('','Teléfono Contacto Origen: ', $telefono_origen));
                $cont++;
            }            
            if($tipo_envio != null && trim($tipo_envio, " ") != ""){
                array_push($data, array('','Tipo de Envío: ', $tipo_envio));
                $cont++;
            }            
            if($detalle_envio != null && trim($detalle_envio, " ") != ""){
                array_push($data, array('','Detalle del Tipo de Envío: ', $detalle_envio));
                $cont++;
            }            
            if($orden_servicio != null && trim($orden_servicio, " ") != ""){
                array_push($data, array('','Orden de Servicio: ', $orden_servicio));
                $cont++;
            }            
            if($fecha_entregaIni != null && $fecha_entregaIni != ""){
                array_push($data, array('','Fecha Inicial de Entrega: ', pasFechaVista(substr($fecha_entregaIni, 0, 10))));
                $cont++;
            }
            if($fecha_entregaFin != null && $fecha_entregaFin != ""){
                array_push($data, array('','Fecha Final de Entrega: ', pasFechaVista(substr($fecha_entregaFin, 0, 10))));
                $cont++;
            }    
            if($username1 != null && trim($username1, " ") != ""){
                array_push($data, array('','Usuario de Registro del Formulario 01: ', $username1));
                $cont++;
            } 
            if($username2 != null && trim($username2, " ") != ""){
                array_push($data, array('','Usuario de Registro del Formulario 02: ', $username2));
                $cont++;
            }       
        }
        else{
            array_push($data, array(''));
        }

        $cont = $cont + 3;



        array_push($data, array('N°','CÓDIGO ÚNICO DE REGISTRO', 'CANTIDAD DE SOBRES', 'ORIGEN DEL SOBRE - DEPENDENCIA', 'META DEPENDENCIA', 'N° DE DOCUMENTO','N° DE EXPEDIENTE','TELÉFONO CONTACTO ORIGEN', 'FECHA INGRESO LOGÍSTICA', 'DESTINO / DIRECCIÓN', 'TIPO DE ENVÍO', 'FECHA DE ENTREGA A DESTINO', 'N° DE ORDEN DE SERVICIO', 'OBSERVACIÓN', 'USUARIO DE REGISTRO DEL FORMULARIO 01', 'USUARIO DE REGISTRO DEL FORMULARIO 02'));

        foreach ($registrosimp as $key => $dato) {
            array_push($data, array($key+1,
                $dato->codigo_registro,
                $dato->cantidad_sobres,
                $dato->nombreDependencia,
                $dato->metaDependencia,
                $dato->numero_documento,
                $dato->expediente,
                $dato->telefono_origen,
                pasFechaVista($dato->fecha_ingreso),
                $dato->dependencia.' / '.$dato->direccion.' / '.$dato->provincia,
                $dato->tipo_envio.' '.$dato->detalle_envio,
                pasFechaVista($dato->fecha_entrega),
                $dato->orden_servicio,
                $dato->observacion,                       
                $dato->name1,                       
                $dato->name2,                       
            ));
        }

        $export = new Reporte2Export($data, $cont);

        return Excel::download($export, 'reporte_entrega_courier.xlsx');
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

        $cantidad_sobres=$request->cantidad_sobres;
        $origen_sobre=$request->origen_sobre;
        $numero_documento=$request->numero_documento;
        $expediente=$request->expediente;
        $telefono_origen=$request->telefono_origen;
        $fecha_ingreso=$request->fecha_ingreso;
        $provincia=$request->provincia;
        $dependencia=$request->dependencia;
        $direccion=$request->direccion;
        $dependencia_id=$request->dependencia_id;
        $ip_registro1=$request->ip();

        $result='1';
        $msj='';
        $selector='';


        $input1  = array('cantidad_sobres' => $cantidad_sobres);
        $reglas1 = array('cantidad_sobres' => 'required');

        $input2  = array('origen_sobre' => $origen_sobre);
        $reglas2 = array('origen_sobre' => 'required');

        $input11  = array('dependencia_id' => $dependencia_id);
        $reglas11 = array('dependencia_id' => 'required');

        $input3  = array('numero_documento' => $numero_documento);
        $reglas3 = array('numero_documento' => 'required');

        $input4  = array('expediente' => $expediente);
        $reglas4 = array('expediente' => 'required');

        $input5  = array('telefono_origen' => $telefono_origen);
        $reglas5 = array('telefono_origen' => 'required');

        $input6  = array('fecha_ingreso' => $fecha_ingreso);
        $reglas6 = array('fecha_ingreso' => 'required');

        $input7  = array('provincia' => $provincia);
        $reglas7 = array('provincia' => 'required');

        $input8  = array('dependencia' => $dependencia);
        $reglas8 = array('dependencia' => 'required');

        $input9  = array('direccion' => $direccion);
        $reglas9 = array('direccion' => 'required');

        $input10  = array('ip_registro1' => $ip_registro1);
        $reglas10 = array('ip_registro1' => 'required');

        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);
        $validator5 = Validator::make($input5, $reglas5);
        $validator6 = Validator::make($input6, $reglas6);
        $validator7 = Validator::make($input7, $reglas7);
        $validator8 = Validator::make($input8, $reglas8);
        $validator9 = Validator::make($input9, $reglas9);
        $validator10 = Validator::make($input10, $reglas10);
        $validator11 = Validator::make($input11, $reglas11);

        if ($validator1->fails())
        {
            /*
            $result='0';
            $msj='Debe ingresar el nombre de la oficina';
            $selector='txtnombre'; 
            */
            $cantidad_sobres = 1;
        }
        if ($validator2->fails())
        {
            $origen_sobre = "";
        }
        if ($validator3->fails())
        {
            $expediente = "";
        }
        if ($validator4->fails())
        {
            $expediente = "";
        }
        if ($validator5->fails())
        {
            $telefono_origen = "";
        }
        if ($validator6->fails())
        {
            $fecha_ingreso = date('Y-m-d');
        }
        if ($validator7->fails())
        {
            $provincia = "";
        }
        if ($validator8->fails())
        {
            $dependencia = "";
        }
        if ($validator9->fails())
        {
            $direccion = "";
        }
        if ($validator10->fails())
        {
            $ip_registro1 = "";
        }
        if ($validator11->fails() || intval($dependencia_id) == 0)
        {
            $result='0';
            $msj='Debe de seleccionar la Dependencia de Origen';
            $selector='cbudependencia_id';

            return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector, 'codigo_registro'=>'0']);
        }

        $tipo_envio = "";
        $detalle_envio = "";
        $fecha_entrega = null;
        $orden_servicio = "";
        $observacion = "";

        $n = EntregaCourier::whereRaw(" year(created_at) = ? ", [date('Y')])->count();
        //var_dump($n);
        $n++;
        $n_format = str_pad(strval($n), 10, "0", STR_PAD_LEFT);
        $codigo_registro = "CUR_".date('Y')."_".$n_format;
        
        $registro = new EntregaCourier;

        $registro->codigo_registro=$codigo_registro;
        $registro->cantidad_sobres=$cantidad_sobres;
        $registro->origen_sobre=$origen_sobre;
        $registro->numero_documento=$numero_documento;
        $registro->expediente=$expediente;
        $registro->telefono_origen=$telefono_origen;
        $registro->fecha_ingreso=$fecha_ingreso;
        $registro->provincia=$provincia;
        $registro->dependencia=$dependencia;
        $registro->direccion=$direccion;
        $registro->tipo_envio=$tipo_envio;
        $registro->detalle_envio=$detalle_envio;
        $registro->fecha_entrega=$fecha_entrega;
        $registro->orden_servicio=$orden_servicio;
        $registro->observacion=$observacion;
        $registro->user_id_registro1=Auth::user()->id;
        $registro->ip_registro1=$ip_registro1;
        $registro->fecha_registro1=date('Y-m-d');
        $registro->hora_registro1=date('H:i:s');
        $registro->borrado='0';
        $registro->dependencia_id=$dependencia_id;

        $registro->save();

        $msj='Nuevo Registro guardado con Éxito, Se generó el Código Único de Registro: '.$registro->codigo_registro;


        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector, 'codigo_registro'=>$registro->codigo_registro]);
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

        $cantidad_sobres=$request->cantidad_sobres;
        $origen_sobre=$request->origen_sobre;
        $numero_documento=$request->numero_documento;
        $expediente=$request->expediente;
        $telefono_origen=$request->telefono_origen;
        $fecha_ingreso=$request->fecha_ingreso;
        $provincia=$request->provincia;
        $dependencia=$request->dependencia;
        $direccion=$request->direccion;
        $ip_registro1=$request->ip();
        $dependencia_id=$request->dependencia_id;

        $tipo_envio = $request->tipo_envio;
        $detalle_envio = $request->detalle_envio;
        $fecha_entrega = $request->fecha_entrega;
        $orden_servicio = $request->orden_servicio;
        $observacion = $request->observacion;
        $ip_registro2=$request->ip();

        $tipoUpdate = $request->tipoUpdate;

        $result='1';
        $msj='';
        $selector='';


        $input1  = array('cantidad_sobres' => $cantidad_sobres);
        $reglas1 = array('cantidad_sobres' => 'required');

        $input2  = array('origen_sobre' => $origen_sobre);
        $reglas2 = array('origen_sobre' => 'required');

        $input3  = array('numero_documento' => $numero_documento);
        $reglas3 = array('numero_documento' => 'required');

        $input4  = array('expediente' => $expediente);
        $reglas4 = array('expediente' => 'required');

        $input5  = array('telefono_origen' => $telefono_origen);
        $reglas5 = array('telefono_origen' => 'required');

        $input6  = array('fecha_ingreso' => $fecha_ingreso);
        $reglas6 = array('fecha_ingreso' => 'required');

        $input7  = array('provincia' => $provincia);
        $reglas7 = array('provincia' => 'required');

        $input8  = array('dependencia' => $dependencia);
        $reglas8 = array('dependencia' => 'required');

        $input9  = array('direccion' => $direccion);
        $reglas9 = array('direccion' => 'required');

        $input10  = array('tipo_envio' => $tipo_envio);
        $reglas10 = array('tipo_envio' => 'required');

        $input11  = array('detalle_envio' => $detalle_envio);
        $reglas11 = array('detalle_envio' => 'required');

        $input12  = array('fecha_entrega' => $fecha_entrega);
        $reglas12 = array('fecha_entrega' => 'required');

        $input13  = array('orden_servicio' => $orden_servicio);
        $reglas13 = array('orden_servicio' => 'required');

        $input14  = array('observacion' => $observacion);
        $reglas14 = array('observacion' => 'required');

        $input15  = array('ip_registro2' => $ip_registro2);
        $reglas15 = array('ip_registro2' => 'required');

        $input16  = array('tipoUpdate' => $tipoUpdate);
        $reglas16 = array('tipoUpdate' => 'required');

        $input17  = array('dependencia_id' => $dependencia_id);
        $reglas17 = array('dependencia_id' => 'required');

        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);
        $validator5 = Validator::make($input5, $reglas5);
        $validator6 = Validator::make($input6, $reglas6);
        $validator7 = Validator::make($input7, $reglas7);
        $validator8 = Validator::make($input8, $reglas8);
        $validator9 = Validator::make($input9, $reglas9);
        $validator10 = Validator::make($input10, $reglas10);
        $validator11 = Validator::make($input11, $reglas11);
        $validator12 = Validator::make($input12, $reglas12);
        $validator13 = Validator::make($input13, $reglas13);
        $validator14 = Validator::make($input14, $reglas14);
        $validator15 = Validator::make($input15, $reglas15);
        $validator16 = Validator::make($input16, $reglas16);
        $validator17 = Validator::make($input17, $reglas17);

        if ($validator1->fails())
        {
            /*
            $result='0';
            $msj='Debe ingresar el nombre de la oficina';
            $selector='txtnombre'; 
            */
            $cantidad_sobres = 0;
        }
        if ($validator2->fails())
        {
            $origen_sobre = "";
        }
        if ($validator3->fails())
        {
            $expediente = "";
        }
        if ($validator4->fails())
        {
            $expediente = "";
        }
        if ($validator5->fails())
        {
            $telefono_origen = "";
        }
        if ($validator6->fails())
        {
            $fecha_ingreso = date('Y-m-d');
        }
        if ($validator7->fails())
        {
            $provincia = "";
        }
        if ($validator8->fails())
        {
            $dependencia = "";
        }
        if ($validator9->fails())
        {
            $direccion = "";
        }
        if ($validator10->fails())
        {
            $tipo_envio = "";
        }
        if ($validator11->fails())
        {
            $detalle_envio = "";
        }
        if ($validator12->fails())
        {
            $fecha_entrega = date('Y-m-d');
        }
        if ($validator13->fails())
        {
            $orden_servicio = "";
        }
        if ($validator14->fails())
        {
            $observacion = "";
        }
        if ($validator15->fails())
        {
            $ip_registro2 = "";
        }
        if ($validator16->fails())
        {
            $tipoUpdate = 0;
        }
        
        if(intval($tipoUpdate) == 1){

            if ($validator17->fails() || intval($dependencia_id) == 0)
            {
                $result='0';
                $msj='Debe de seleccionar la Dependencia de Origen';
                $selector='cbudependencia_id';

                return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
            }

            $registro = EntregaCourier::findOrFail($id);

            $registro->cantidad_sobres=$cantidad_sobres;
            $registro->origen_sobre=$origen_sobre;
            $registro->numero_documento=$numero_documento;
            $registro->expediente=$expediente;
            $registro->telefono_origen=$telefono_origen;
            $registro->fecha_ingreso=$fecha_ingreso;
            $registro->provincia=$provincia;
            $registro->dependencia=$dependencia;
            $registro->direccion=$direccion;
            $registro->tipo_envio=$tipo_envio;
            $registro->dependencia_id=$dependencia_id;

            $registro->save();

            $msj='Registro actualizado con Éxito';
        }
        if(intval($tipoUpdate) == 2){

            $registro = EntregaCourier::findOrFail($id);

            $registro->tipo_envio=$tipo_envio;
            $registro->detalle_envio=$detalle_envio;
            $registro->fecha_entrega=$fecha_entrega;
            $registro->orden_servicio=$orden_servicio;
            $registro->observacion=$observacion;

            $registro->user_id_registro2=Auth::user()->id;
            $registro->ip_registro2=$ip_registro2;
            $registro->fecha_registro2=date('Y-m-d');
            $registro->hora_registro2=date('H:i:s');

            $registro->save();

            $msj='Nuevo Registro guardado con Éxito';
        }

        if(intval($tipoUpdate) == 3){

            $registro = EntregaCourier::findOrFail($id);

            $registro->tipo_envio=$tipo_envio;
            $registro->detalle_envio=$detalle_envio;
            $registro->fecha_entrega=$fecha_entrega;
            $registro->orden_servicio=$orden_servicio;
            $registro->observacion=$observacion;

            $registro->save();

            $msj='Registro actualizado con Éxito';
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

        $registro = EntregaCourier::findOrFail($id);
        
        //$task->delete();
        $registro->borrado='1';
        $registro->save();

        $msj='Registro eliminado exitosamente';


        return response()->json(["result"=>$result,'msj'=>$msj]);
    }

    public function buscarRegistro(Request $request)
    {
       $codigo_registro=$request->codigo_registro;

       $result='0';
       $msj='Complete el Formulario';
       $selector='';
       $registro="";

       $input1  = array('codigo_registro' => $codigo_registro);
       $reglas1 = array('codigo_registro' => 'required');

       $validator1 = Validator::make($input1, $reglas1);

       if ($validator1->fails())
       {
           $result='0';
           $msj='Ingrese el Código Único de Registro';
           $selector='txtcodigo_registro';

       }
       else{

           /* $registro=EntregaCourier::where('codigo_registro',$codigo_registro)
            ->where('borrado','0')->first(); */

            $registro=DB::table('entrega_curriers')
            ->join('dependencias', 'dependencias.id', '=', 'entrega_curriers.dependencia_id')
            ->where('entrega_curriers.borrado','0')
            ->where('entrega_curriers.codigo_registro',$codigo_registro)
            ->orderBy('entrega_curriers.codigo_registro')
            ->orderBy('entrega_curriers.id')
            ->select(
                'entrega_curriers.id',
                'entrega_curriers.codigo_registro',
                'entrega_curriers.cantidad_sobres',
                'entrega_curriers.origen_sobre',
                'entrega_curriers.numero_documento',
                'entrega_curriers.expediente',
                'entrega_curriers.telefono_origen',
                'entrega_curriers.fecha_ingreso',
                'entrega_curriers.provincia',
                'entrega_curriers.dependencia',
                'entrega_curriers.direccion',
                'entrega_curriers.tipo_envio',
                'entrega_curriers.detalle_envio',
                'entrega_curriers.fecha_entrega',
                'entrega_curriers.orden_servicio',
                'entrega_curriers.observacion',
                'entrega_curriers.user_id_registro1',
                'entrega_curriers.ip_registro1',
                'entrega_curriers.fecha_registro1',
                'entrega_curriers.hora_registro1',
                'entrega_curriers.user_id_registro2',
                'entrega_curriers.ip_registro2',
                'entrega_curriers.fecha_registro2',
                'entrega_curriers.hora_registro2',
                'entrega_curriers.borrado',
                'entrega_curriers.created_at',
                'entrega_curriers.updated_at',
                'entrega_curriers.dependencia_id',
    
                'dependencias.id as idDependencia',
                'dependencias.nombre as nombreDependencia',
                'dependencias.meta as metaDependencia',
                'dependencias.telefono as telefonoDependencia',
                'dependencias.activo as activoDependencia',
            )
            ->first();
           
           if($registro){
                $result='1';
           }
       }

       return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector,'registro'=>$registro]);

    }
}

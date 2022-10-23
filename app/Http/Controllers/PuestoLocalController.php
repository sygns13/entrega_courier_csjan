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

use App\Exports\Reporte2Export;
use App\Exports\Reporte3Export;
use Maatwebsite\Excel\Facades\Excel;

use stdClass;
use DB;
use Storage;
set_time_limit(600);

class PuestoLocalController extends Controller
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
            $zonas=Zona::orderBy('id')->where('borrado','0')->get();

            $modulo="puesto";

            return view('puesto.index',compact('tipouser','modulo','zonas'));
        }
        else
        {
            return redirect('home');    
        }
    }

    public function index2()
    {
        if(accesoUser([1,2,3,4])){

            $idtipouser=Auth::user()->tipo_user_id;
            $tipouser=Tipouser::find($idtipouser);

            $modulo="reporte2";
            return view('reporte2.index',compact('tipouser','modulo'));
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

            $modulo="reporte3";
            return view('reporte3.index',compact('tipouser','modulo'));
        }
        else
        {
            return redirect('home');           
        }
    }


    public function index(Request $request)
    {
        $buscar=$request->busca;

        $registros = DB::table('puesto_locals')
     ->join('zonas', 'zonas.id', '=', 'puesto_locals.zona_id')
     /* ->leftjoin('escuelas', 'escuelas.id', '=', 'personals.escuela_id') */
     ->where('puesto_locals.borrado','0')
     ->where(function($query) use ($buscar){
        $query->where('puesto_locals.nombre','like','%'.$buscar.'%');
        $query->orWhere('puesto_locals.numero','like','%'.$buscar.'%');
        $query->orWhere('puesto_locals.tipo','like','%'.$buscar.'%');
        $query->orWhere('zonas.nombre','like','%'.$buscar.'%');
        $query->orWhere('puesto_locals.direccion','like','%'.$buscar.'%');
        $query->orWhere('puesto_locals.referenia','like','%'.$buscar.'%');
        })
     ->orderBy('zonas.nombre')
     ->orderBy('puesto_locals.numero')
     ->orderBy('puesto_locals.nombre')
     ->select('puesto_locals.id',
                'puesto_locals.nombre',
                'puesto_locals.numero',
                'puesto_locals.direccion',
                'puesto_locals.tipo',
                'puesto_locals.referenia',
                'puesto_locals.zona_id',
                'puesto_locals.alta',
                'puesto_locals.baja',
                'puesto_locals.activo',
                'puesto_locals.borrado',
                'puesto_locals.created_at',
                'puesto_locals.updated_at',
                'zonas.nombre as zona')
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

    public function buscarDatos(Request $request)
    {
        $fechaRegistro=$request->fechaRegistro;
        $nombres=$request->nombres;
        $apellidos=$request->apellidos;
        $nombrePuesto=$request->nombrePuesto;
        $numeroPuesto=$request->numeroPuesto;

        $buscar="";

        $query = DB::table('puesto_locals')
     ->join('zonas', 'zonas.id', '=', 'puesto_locals.zona_id')
     ->leftJoin('puesto_local_personas as puestoPerNat',  function($join) {
        $join->on('puestoPerNat.puesto_local_id', '=', 'puesto_locals.id');
        $join->on('puestoPerNat.tipo', '=', DB::raw('1'));
        $join->on('puestoPerNat.borrado', '=', DB::raw('0'));
        $join->on('puestoPerNat.activo', '=', DB::raw('1'));
    })

     ->leftJoin('personas as perNat',  function($join) {
        $join->on('perNat.id', '=', 'puestoPerNat.persona_id');
        $join->on('perNat.tipo', '=', DB::raw('1'));
    })

    ->leftJoin('puesto_local_personas as puestoPerJur',  function($join) {
        $join->on('puestoPerJur.puesto_local_id', '=', 'puesto_locals.id');
        $join->on('puestoPerJur.tipo', '=', DB::raw('2'));
        $join->on('puestoPerJur.borrado', '=', DB::raw('0'));
        $join->on('puestoPerJur.activo', '=', DB::raw('1'));
    })

     ->leftJoin('personas as perJur',  function($join) {
        $join->on('perJur.id', '=', 'puestoPerJur.persona_id');
        $join->on('perJur.tipo', '=', DB::raw('2'));
    })

     ->where('puesto_locals.borrado','0')
     ->orderBy('zonas.nombre')
     ->orderBy('puesto_locals.numero')
     ->orderBy('puesto_locals.nombre')
     ->select('puesto_locals.id',
                'puesto_locals.nombre as nombrePuesto',
                'puesto_locals.numero as numeroPuesto',
                'puesto_locals.direccion',
                'puesto_locals.tipo',
                'puesto_locals.referenia',
                'puesto_locals.zona_id',
                'puesto_locals.alta',
                'puesto_locals.baja',
                'puesto_locals.activo',
                'puesto_locals.borrado',
                'puesto_locals.created_at',
                'puesto_locals.updated_at',
                'zonas.nombre as zona',

                DB::Raw("IFNULL( `perNat`.`id` , '0' ) as idperNat"),
                DB::Raw("IFNULL( `perNat`.`tipo` , '' ) as tipoperNat"),
                DB::Raw("IFNULL( `perNat`.`tipo_documento` , '' ) as tipo_documentoperNat"),
                DB::Raw("IFNULL( `perNat`.`num_documento` , '' ) as num_documentoperNat"),
                DB::Raw("IFNULL( `perNat`.`apellidos` , '' ) as apellidosperNat"),
                DB::Raw("IFNULL( `perNat`.`nombres` , '' ) as nombresperNat"),
                DB::Raw("IFNULL( `perNat`.`telefono` , '' ) as telefonoperNat"),
                DB::Raw("IFNULL( `perNat`.`direccion` , '' ) as direccionperNat"),
                DB::Raw("IFNULL( `perNat`.`email` , '' ) as emailperNat"),

                DB::Raw("IFNULL( `perJur`.`id` , '0' ) as idperJur"),
                DB::Raw("IFNULL( `perJur`.`tipo` , '' ) as tipoperJur"),
                DB::Raw("IFNULL( `perJur`.`tipo_documento` , '' ) as tipo_documentoperJur"),
                DB::Raw("IFNULL( `perJur`.`num_documento` , '' ) as num_documentoperJur"),
                DB::Raw("IFNULL( `perJur`.`apellidos` , '' ) as apellidosperJur"),
                DB::Raw("IFNULL( `perJur`.`nombres` , '' ) as nombresperJur"),
                DB::Raw("IFNULL( `perJur`.`telefono` , '' ) as telefonoperJur"),
                DB::Raw("IFNULL( `perJur`.`direccion` , '' ) as direccionperJur"),
                DB::Raw("IFNULL( `perJur`.`email` , '' ) as emailperJur")
            );

        if($fechaRegistro != null && $fechaRegistro != ""){
            $query->whereRaw('date(puesto_locals.created_at) = ?', [$fechaRegistro]);
        }
        if($nombres != null && trim($nombres, " ") != ""){
            $query->where('perNat.nombres','like','%'.$nombres.'%');
        }
        if($apellidos != null && trim($apellidos, " ") != ""){
            $query->where('perNat.apellidos','like','%'.$apellidos.'%');
        }
        if($nombrePuesto != null && trim($nombrePuesto, " ") != ""){
            $query->where('puesto_locals.nombre','like','%'.$nombrePuesto.'%');
        }
        if($numeroPuesto != null && trim($numeroPuesto, " ") != ""){
            $query->where('puesto_locals.numero','like','%'.$numeroPuesto.'%');
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
        $nombres=$request->nombres;
        $apellidos=$request->apellidos;
        $nombrePuesto=$request->nombrePuesto;
        $numeroPuesto=$request->numeroPuesto;

        $buscar="";

        $query = DB::table('puesto_locals')
     ->join('zonas', 'zonas.id', '=', 'puesto_locals.zona_id')
     ->leftJoin('puesto_local_personas as puestoPerNat',  function($join) {
        $join->on('puestoPerNat.puesto_local_id', '=', 'puesto_locals.id');
        $join->on('puestoPerNat.tipo', '=', DB::raw('1'));
        $join->on('puestoPerNat.borrado', '=', DB::raw('0'));
        $join->on('puestoPerNat.activo', '=', DB::raw('1'));
    })

     ->leftJoin('personas as perNat',  function($join) {
        $join->on('perNat.id', '=', 'puestoPerNat.persona_id');
        $join->on('perNat.tipo', '=', DB::raw('1'));
    })

    ->leftJoin('puesto_local_personas as puestoPerJur',  function($join) {
        $join->on('puestoPerJur.puesto_local_id', '=', 'puesto_locals.id');
        $join->on('puestoPerJur.tipo', '=', DB::raw('2'));
        $join->on('puestoPerJur.borrado', '=', DB::raw('0'));
        $join->on('puestoPerJur.activo', '=', DB::raw('1'));
    })

     ->leftJoin('personas as perJur',  function($join) {
        $join->on('perJur.id', '=', 'puestoPerJur.persona_id');
        $join->on('perJur.tipo', '=', DB::raw('2'));
    })

     ->where('puesto_locals.borrado','0')

     ->orderBy('zonas.nombre')
     ->orderBy('puesto_locals.numero')
     ->orderBy('puesto_locals.nombre')
     ->select('puesto_locals.id',
                'puesto_locals.nombre as nombrePuesto',
                'puesto_locals.numero as numeroPuesto',
                'puesto_locals.direccion',
                'puesto_locals.tipo',
                'puesto_locals.referenia',
                'puesto_locals.zona_id',
                'puesto_locals.alta',
                'puesto_locals.baja',
                'puesto_locals.activo',
                'puesto_locals.borrado',
                'puesto_locals.created_at',
                'puesto_locals.updated_at',
                'zonas.nombre as zona',

                DB::Raw("IFNULL( `perNat`.`id` , '0' ) as idperNat"),
                DB::Raw("IFNULL( `perNat`.`tipo` , '' ) as tipoperNat"),
                DB::Raw("IFNULL( `perNat`.`tipo_documento` , '' ) as tipo_documentoperNat"),
                DB::Raw("IFNULL( `perNat`.`num_documento` , '' ) as num_documentoperNat"),
                DB::Raw("IFNULL( `perNat`.`apellidos` , '' ) as apellidosperNat"),
                DB::Raw("IFNULL( `perNat`.`nombres` , '' ) as nombresperNat"),
                DB::Raw("IFNULL( `perNat`.`telefono` , '' ) as telefonoperNat"),
                DB::Raw("IFNULL( `perNat`.`direccion` , '' ) as direccionperNat"),
                DB::Raw("IFNULL( `perNat`.`email` , '' ) as emailperNat"),

                DB::Raw("IFNULL( `perJur`.`id` , '0' ) as idperJur"),
                DB::Raw("IFNULL( `perJur`.`tipo` , '' ) as tipoperJur"),
                DB::Raw("IFNULL( `perJur`.`tipo_documento` , '' ) as tipo_documentoperJur"),
                DB::Raw("IFNULL( `perJur`.`num_documento` , '' ) as num_documentoperJur"),
                DB::Raw("IFNULL( `perJur`.`apellidos` , '' ) as apellidosperJur"),
                DB::Raw("IFNULL( `perJur`.`nombres` , '' ) as nombresperJur"),
                DB::Raw("IFNULL( `perJur`.`telefono` , '' ) as telefonoperJur"),
                DB::Raw("IFNULL( `perJur`.`direccion` , '' ) as direccionperJur"),
                DB::Raw("IFNULL( `perJur`.`email` , '' ) as emailperJur")
            );

        if($fechaRegistro != null && $fechaRegistro != ""){
            $query->whereRaw('date(puesto_locals.created_at) = ?', [$fechaRegistro]);
        }
        if($nombres != null && trim($nombres, " ") != ""){
            $query->where('perNat.nombres','like','%'.$nombres.'%');
        }
        if($apellidos != null && trim($apellidos, " ") != ""){
            $query->where('perNat.apellidos','like','%'.$apellidos.'%');
        }
        if($nombrePuesto != null && trim($nombrePuesto, " ") != ""){
            $query->where('puesto_locals.nombre','like','%'.$nombrePuesto.'%');
        }
        if($numeroPuesto != null && trim($numeroPuesto, " ") != ""){
            $query->where('puesto_locals.numero','like','%'.$numeroPuesto.'%');
        }


        $registrosimp=$query->get();

        return [
            'registrosimp'=>$registrosimp,
        ];
    }

    public function buscarDatos2(Request $request)
    {
        $fechaRegistro=$request->fechaRegistro;
        $nombres=$request->nombres;
        $apellidos=$request->apellidos;
        $nombrePuesto=$request->nombrePuesto;
        $numeroPuesto=$request->numeroPuesto;
        $razonSocial=$request->razonSocial;

        $buscar="";

        $query = DB::table('puesto_locals')
     ->join('zonas', 'zonas.id', '=', 'puesto_locals.zona_id')
     /* ->join('puesto_local_personas', 'puesto_locals.id', '=', 'puesto_local_personas.puesto_local_id')
     ->leftjoin('personas as perNat', 'personas.id', '=', 'puesto_local_personas.persona_id') */

     ->leftJoin('puesto_local_personas as puestoPerNat',  function($join) {
        $join->on('puestoPerNat.puesto_local_id', '=', 'puesto_locals.id');
        $join->on('puestoPerNat.tipo', '=', DB::raw('1'));
        $join->on('puestoPerNat.borrado', '=', DB::raw('0'));
        $join->on('puestoPerNat.activo', '=', DB::raw('1'));
    })

     ->leftJoin('personas as perNat',  function($join) {
        $join->on('perNat.id', '=', 'puestoPerNat.persona_id');
        $join->on('perNat.tipo', '=', DB::raw('1'));
    })

    ->leftJoin('puesto_local_personas as puestoPerJur',  function($join) {
        $join->on('puestoPerJur.puesto_local_id', '=', 'puesto_locals.id');
        $join->on('puestoPerJur.tipo', '=', DB::raw('2'));
        $join->on('puestoPerJur.borrado', '=', DB::raw('0'));
        $join->on('puestoPerJur.activo', '=', DB::raw('1'));
    })

     ->leftJoin('personas as perJur',  function($join) {
        $join->on('perJur.id', '=', 'puestoPerJur.persona_id');
        $join->on('perJur.tipo', '=', DB::raw('2'));
    })

    ->leftJoin('medidors',  function($join) {
        $join->on('puesto_locals.id', '=', 'medidors.puesto_local_id');
        $join->on('medidors.borrado', '=', DB::raw('0'));
    })

     ->where('puesto_locals.borrado','0')
     ->orderBy('zonas.nombre')
     ->orderBy('puesto_locals.numero')
     ->orderBy('puesto_locals.nombre')
     ->select('puesto_locals.id',
                'puesto_locals.nombre as nombrePuesto',
                'puesto_locals.numero as numeroPuesto',
                'puesto_locals.direccion',
                'puesto_locals.tipo',
                'puesto_locals.referenia',
                'puesto_locals.zona_id',
                'puesto_locals.alta',
                'puesto_locals.baja',
                'puesto_locals.activo',
                'puesto_locals.borrado',
                'puesto_locals.created_at',
                'puesto_locals.updated_at',
                'zonas.nombre as zona',


                DB::Raw("IFNULL( `perNat`.`id` , '0' ) as idperNat"),
                DB::Raw("IFNULL( `perNat`.`tipo` , '' ) as tipoperNat"),
                DB::Raw("IFNULL( `perNat`.`tipo_documento` , '' ) as tipo_documentoperNat"),
                DB::Raw("IFNULL( `perNat`.`num_documento` , '' ) as num_documentoperNat"),
                DB::Raw("IFNULL( `perNat`.`apellidos` , '' ) as apellidosperNat"),
                DB::Raw("IFNULL( `perNat`.`nombres` , '' ) as nombresperNat"),
                DB::Raw("IFNULL( `perNat`.`telefono` , '' ) as telefonoperNat"),
                DB::Raw("IFNULL( `perNat`.`direccion` , '' ) as direccionperNat"),
                DB::Raw("IFNULL( `perNat`.`email` , '' ) as emailperNat"),

                DB::Raw("IFNULL( `perJur`.`id` , '0' ) as idperJur"),
                DB::Raw("IFNULL( `perJur`.`tipo` , '' ) as tipoperJur"),
                DB::Raw("IFNULL( `perJur`.`tipo_documento` , '' ) as tipo_documentoperJur"),
                DB::Raw("IFNULL( `perJur`.`num_documento` , '' ) as num_documentoperJur"),
                DB::Raw("IFNULL( `perJur`.`apellidos` , '' ) as apellidosperJur"),
                DB::Raw("IFNULL( `perJur`.`nombres` , '' ) as nombresperJur"),
                DB::Raw("IFNULL( `perJur`.`telefono` , '' ) as telefonoperJur"),
                DB::Raw("IFNULL( `perJur`.`direccion` , '' ) as direccionperJur"),
                DB::Raw("IFNULL( `perJur`.`email` , '' ) as emailperJur"),

                DB::Raw("IFNULL( `medidors`.`id` , '0' ) as idmedidors"),
                DB::Raw("IFNULL( `medidors`.`activo` , '0' ) as estadoServicio"),


            );

        if($fechaRegistro != null && $fechaRegistro != ""){
            $query->whereRaw('puesto_locals.alta = ?', [$fechaRegistro]);
        }
        if($nombres != null && trim($nombres, " ") != ""){
            $query->where('perNat.nombres','like','%'.$nombres.'%');
        }
        if($apellidos != null && trim($apellidos, " ") != ""){
            $query->where('perNat.apellidos','like','%'.$apellidos.'%');
        }
        if($nombrePuesto != null && trim($nombrePuesto, " ") != ""){
            $query->where('puesto_locals.nombre','like','%'.$nombrePuesto.'%');
        }
        if($numeroPuesto != null && trim($numeroPuesto, " ") != ""){
            $query->where('puesto_locals.numero','like','%'.$numeroPuesto.'%');
        }
        if($razonSocial != null && trim($razonSocial, " ") != ""){
            $query->where('perJur.nombres','like','%'.$numeroPuesto.'%');
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
        $fechaRegistro=$request->fechaRegistro;
        $nombres=$request->nombres;
        $apellidos=$request->apellidos;
        $nombrePuesto=$request->nombrePuesto;
        $numeroPuesto=$request->numeroPuesto;
        $razonSocial=$request->razonSocial;

        $buscar="";

        $query = DB::table('puesto_locals')
     ->join('zonas', 'zonas.id', '=', 'puesto_locals.zona_id')
     /* ->join('puesto_local_personas', 'puesto_locals.id', '=', 'puesto_local_personas.puesto_local_id')
     ->leftjoin('personas as perNat', 'personas.id', '=', 'puesto_local_personas.persona_id') */

     ->leftJoin('puesto_local_personas as puestoPerNat',  function($join) {
        $join->on('puestoPerNat.puesto_local_id', '=', 'puesto_locals.id');
        $join->on('puestoPerNat.tipo', '=', DB::raw('1'));
        $join->on('puestoPerNat.borrado', '=', DB::raw('0'));
        $join->on('puestoPerNat.activo', '=', DB::raw('1'));
    })

     ->leftJoin('personas as perNat',  function($join) {
        $join->on('perNat.id', '=', 'puestoPerNat.persona_id');
        $join->on('perNat.tipo', '=', DB::raw('1'));
    })

    ->leftJoin('puesto_local_personas as puestoPerJur',  function($join) {
        $join->on('puestoPerJur.puesto_local_id', '=', 'puesto_locals.id');
        $join->on('puestoPerJur.tipo', '=', DB::raw('2'));
        $join->on('puestoPerJur.borrado', '=', DB::raw('0'));
        $join->on('puestoPerJur.activo', '=', DB::raw('1'));
    })

     ->leftJoin('personas as perJur',  function($join) {
        $join->on('perJur.id', '=', 'puestoPerJur.persona_id');
        $join->on('perJur.tipo', '=', DB::raw('2'));
    })

    ->leftJoin('medidors',  function($join) {
        $join->on('puesto_locals.id', '=', 'medidors.puesto_local_id');
        $join->on('medidors.borrado', '=', DB::raw('0'));
    })

     ->where('puesto_locals.borrado','0')
     ->orderBy('zonas.nombre')
     ->orderBy('puesto_locals.numero')
     ->orderBy('puesto_locals.nombre')
     ->select('puesto_locals.id',
                'puesto_locals.nombre as nombrePuesto',
                'puesto_locals.numero as numeroPuesto',
                'puesto_locals.direccion',
                'puesto_locals.tipo',
                'puesto_locals.referenia',
                'puesto_locals.zona_id',
                'puesto_locals.alta',
                'puesto_locals.baja',
                'puesto_locals.activo',
                'puesto_locals.borrado',
                'puesto_locals.created_at',
                'puesto_locals.updated_at',
                'zonas.nombre as zona',


                DB::Raw("IFNULL( `perNat`.`id` , '0' ) as idperNat"),
                DB::Raw("IFNULL( `perNat`.`tipo` , '' ) as tipoperNat"),
                DB::Raw("IFNULL( `perNat`.`tipo_documento` , '' ) as tipo_documentoperNat"),
                DB::Raw("IFNULL( `perNat`.`num_documento` , '' ) as num_documentoperNat"),
                DB::Raw("IFNULL( `perNat`.`apellidos` , '' ) as apellidosperNat"),
                DB::Raw("IFNULL( `perNat`.`nombres` , '' ) as nombresperNat"),
                DB::Raw("IFNULL( `perNat`.`telefono` , '' ) as telefonoperNat"),
                DB::Raw("IFNULL( `perNat`.`direccion` , '' ) as direccionperNat"),
                DB::Raw("IFNULL( `perNat`.`email` , '' ) as emailperNat"),

                DB::Raw("IFNULL( `perJur`.`id` , '0' ) as idperJur"),
                DB::Raw("IFNULL( `perJur`.`tipo` , '' ) as tipoperJur"),
                DB::Raw("IFNULL( `perJur`.`tipo_documento` , '' ) as tipo_documentoperJur"),
                DB::Raw("IFNULL( `perJur`.`num_documento` , '' ) as num_documentoperJur"),
                DB::Raw("IFNULL( `perJur`.`apellidos` , '' ) as apellidosperJur"),
                DB::Raw("IFNULL( `perJur`.`nombres` , '' ) as nombresperJur"),
                DB::Raw("IFNULL( `perJur`.`telefono` , '' ) as telefonoperJur"),
                DB::Raw("IFNULL( `perJur`.`direccion` , '' ) as direccionperJur"),
                DB::Raw("IFNULL( `perJur`.`email` , '' ) as emailperJur"),

                DB::Raw("IFNULL( `medidors`.`id` , '0' ) as idmedidors"),
                DB::Raw("IFNULL( `medidors`.`activo` , '0' ) as estadoServicio"),


            );

        if($fechaRegistro != null && $fechaRegistro != ""){
            $query->where('puesto_locals.alta', $fechaRegistro);
        }
        if($nombres != null && trim($nombres, " ") != ""){
            $query->where('perNat.nombres','like','%'.$nombres.'%');
        }
        if($apellidos != null && trim($apellidos, " ") != ""){
            $query->where('perNat.apellidos','like','%'.$apellidos.'%');
        }
        if($nombrePuesto != null && trim($nombrePuesto, " ") != ""){
            $query->where('puesto_locals.nombre','like','%'.$nombrePuesto.'%');
        }
        if($numeroPuesto != null && trim($numeroPuesto, " ") != ""){
            $query->where('puesto_locals.numero','like','%'.$numeroPuesto.'%');
        }
        if($razonSocial != null && trim($razonSocial, " ") != ""){
            $query->where('perJur.nombres','like','%'.$numeroPuesto.'%');
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

        $zona_id = $request->zona_id;
        $nombre = $request->nombre;
        $numero = $request->numero;
        $direccion = $request->direccion;
        $tipo = $request->tipo;
        $referenia = $request->referenia;
        $alta = $request->alta;

        if($direccion == null){
            $direccion = '';
        }

        if($referenia == null){
            $referenia = '';
        }

        $result = '1';
        $msj = '';
        $selector = '';

        $input1  = array('zona_id' => $zona_id);
        $reglas1 = array('zona_id' => 'required');

        $input2  = array('nombre' => $nombre);
        $reglas2 = array('nombre' => 'required');

        $input3  = array('numero' => $numero);
        $reglas3 = array('numero' => 'required');

        $input4  = array('numero' => $numero);
        $reglas4 = array('numero' => 'unique:puesto_locals,numero'.',1,borrado');

        $input5  = array('tipo' => $tipo);
        $reglas5 = array('tipo' => 'required');

        $input6  = array('alta' => $alta);
        $reglas6 = array('alta' => 'required');

        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);
        $validator5 = Validator::make($input5, $reglas5);
        $validator6 = Validator::make($input6, $reglas6);

        if ($validator1->fails() || intval($zona_id) == 0)
        {
            $result='0';
            $msj='Debe ingresar la Zona de ubicación del puesto';
            $selector='cbuzonas';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='Debe de ingresar el nombre del puesto';
            $selector='txtnombre';
        }
        elseif ($validator3->fails())
        {
            $result='0';
            $msj='Debe de ingresar el número del puesto';
            $selector='txtnumero';
        }
        elseif ($validator4->fails())
        {
            $result='0';
            $msj='El número del puesto ingresado ya se encuentra registrado';
            $selector='txtnumero';
        }
        elseif ($validator5->fails() || strval($tipo) == '0')
        {
            $result='0';
            $msj='Debe de seleccionar el tipo de puesto';
            $selector='cbutipo';
        }
        elseif ($validator6->fails())
        {
            $result='0';
            $msj='Debe de ingresar la fecha de alta del puesto';
            $selector='txtalta';
        }
        else{
            $registro = new PuestoLocal;

            $registro->nombre=$nombre;
            $registro->numero=$numero;
            $registro->direccion=$direccion;
            $registro->tipo=$tipo;
            $registro->referenia=$referenia;
            $registro->zona_id=$zona_id;
            $registro->alta=$alta;
            $registro->activo='1';
            $registro->borrado='0';

            $registro->save();

            $msj='Nuevo Puesto Registrado con Éxito';
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

        $zona_id = $request->zona_id;
        $nombre = $request->nombre;
        $numero = $request->numero;
        $direccion = $request->direccion;
        $tipo = $request->tipo;
        $referenia = $request->referenia;
        $alta = $request->alta;

        if($direccion == null){
            $direccion = '';
        }

        if($referenia == null){
            $referenia = '';
        }

        $result = '1';
        $msj = '';
        $selector = '';

        $input1  = array('zona_id' => $zona_id);
        $reglas1 = array('zona_id' => 'required');

        $input2  = array('nombre' => $nombre);
        $reglas2 = array('nombre' => 'required');

        $input3  = array('numero' => $numero);
        $reglas3 = array('numero' => 'required');

        $input4  = array('numero' => $numero);
        $reglas4 = array('numero' => 'unique:puesto_locals,numero,'.$id.',id,borrado,0');

        $input5  = array('tipo' => $tipo);
        $reglas5 = array('tipo' => 'required');

        $input6  = array('alta' => $alta);
        $reglas6 = array('alta' => 'required');

        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);
        $validator5 = Validator::make($input5, $reglas5);
        $validator6 = Validator::make($input6, $reglas6);

        if ($validator1->fails() || intval($zona_id) == 0)
        {
            $result='0';
            $msj='Debe ingresar la Zona de ubicación del puesto';
            $selector='cbuzonasE';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='Debe de ingresar el nombre del puesto';
            $selector='txtnombreE';
        }
        elseif ($validator3->fails())
        {
            $result='0';
            $msj='Debe de ingresar el número del puesto';
            $selector='txtnumeroE';
        }
        elseif ($validator4->fails())
        {
            $result='0';
            $msj='El número del puesto ingresado ya se encuentra registrado';
            $selector='txtnumeroE';
        }
        elseif ($validator5->fails() || strval($tipo) == '0')
        {
            $result='0';
            $msj='Debe de seleccionar el tipo de puesto';
            $selector='cbutipoE';
        }
        elseif ($validator6->fails())
        {
            $result='0';
            $msj='Debe de ingresar la fecha de alta del puesto';
            $selector='txtaltaE';
        }
        else{
            $registro = PuestoLocal::findOrFail($id);

            $registro->nombre=$nombre;
            $registro->numero=$numero;
            $registro->direccion=$direccion;
            $registro->tipo=$tipo;
            $registro->referenia=$referenia;
            $registro->zona_id=$zona_id;
            $registro->alta=$alta;

            $registro->save();

            $msj='Puesto Actualizado con Éxito';
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
            $msj='Debe ingresar la Fecha de Baja del Puesto/Local';
            $selector='txtbajafn';
        }
        else{
            $registro = PuestoLocal::findOrFail($id);
            $registro->activo = $activo;
    
            if($activo == '0'){
                $registro->baja = $fecha_baja;
            }
            else{
                $registro->baja = null;
            }
    
            $registro->save();
    
            if(strval($activo)=="0"){
                $msj='El Puesto/Local fue dado de Baja exitosamente';
            }elseif(strval($activo)=="1"){
                $msj='El Puesto/Local fue dado de Alta exitosamente';
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

        $consulta1=DB::table('medidors')
                    ->join('puesto_locals', 'medidors.puesto_local_id', '=', 'puesto_locals.id')
                    ->where('medidors.borrado','0')
                    ->where('puesto_locals.id',$id)->count();

        $consulta2=DB::table('puesto_local_personas')
                    ->join('puesto_locals', 'puesto_local_personas.puesto_local_id', '=', 'puesto_locals.id')
                    ->where('puesto_local_personas.borrado','0')
                    ->where('puesto_locals.id',$id)->count();

        if($consulta1>0) {
            $result='0';
            $msj='El Puesto/Local Seleccionado no se puede eliminar debido a que cuenta con registros de Medidores Activos asociados';
        }
        else{
            $registro = PuestoLocal::findOrFail($id);
        
            $registro->borrado='1';
            $registro->save();
    
            $msj='Puesto eliminado exitosamente';
        }

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }

    public function export(Request $request) 
    {
        $fechaRegistro=$request->fechaRegistro;
        $nombres=$request->nombres;
        $apellidos=$request->apellidos;
        $nombrePuesto=$request->nombrePuesto;
        $numeroPuesto=$request->numeroPuesto;

        $data=[];

        $titulo='REPORTE DE CLIENTES';

        array_push($data, array($titulo));
        array_push($data, array(''));

        $cont = 1;

        $query = DB::table('puesto_locals')
        ->join('zonas', 'zonas.id', '=', 'puesto_locals.zona_id')
        ->leftJoin('puesto_local_personas as puestoPerNat',  function($join) {
           $join->on('puestoPerNat.puesto_local_id', '=', 'puesto_locals.id');
           $join->on('puestoPerNat.tipo', '=', DB::raw('1'));
           $join->on('puestoPerNat.borrado', '=', DB::raw('0'));
           $join->on('puestoPerNat.activo', '=', DB::raw('1'));
       })
   
        ->leftJoin('personas as perNat',  function($join) {
           $join->on('perNat.id', '=', 'puestoPerNat.persona_id');
           $join->on('perNat.tipo', '=', DB::raw('1'));
       })
   
       ->leftJoin('puesto_local_personas as puestoPerJur',  function($join) {
           $join->on('puestoPerJur.puesto_local_id', '=', 'puesto_locals.id');
           $join->on('puestoPerJur.tipo', '=', DB::raw('2'));
           $join->on('puestoPerJur.borrado', '=', DB::raw('0'));
           $join->on('puestoPerJur.activo', '=', DB::raw('1'));
       })
   
        ->leftJoin('personas as perJur',  function($join) {
           $join->on('perJur.id', '=', 'puestoPerJur.persona_id');
           $join->on('perJur.tipo', '=', DB::raw('2'));
       })
   
        ->where('puesto_locals.borrado','0')
   
        ->orderBy('zonas.nombre')
        ->orderBy('puesto_locals.numero')
        ->orderBy('puesto_locals.nombre')
        ->select('puesto_locals.id',
                   'puesto_locals.nombre as nombrePuesto',
                   'puesto_locals.numero as numeroPuesto',
                   'puesto_locals.direccion',
                   'puesto_locals.tipo',
                   'puesto_locals.referenia',
                   'puesto_locals.zona_id',
                   'puesto_locals.alta',
                   'puesto_locals.baja',
                   'puesto_locals.activo',
                   'puesto_locals.borrado',
                   'puesto_locals.created_at',
                   'puesto_locals.updated_at',
                   'zonas.nombre as zona',
   
                   DB::Raw("IFNULL( `perNat`.`id` , '0' ) as idperNat"),
                   DB::Raw("IFNULL( `perNat`.`tipo` , '' ) as tipoperNat"),
                   DB::Raw("IFNULL( `perNat`.`tipo_documento` , '' ) as tipo_documentoperNat"),
                   DB::Raw("IFNULL( `perNat`.`num_documento` , '' ) as num_documentoperNat"),
                   DB::Raw("IFNULL( `perNat`.`apellidos` , '' ) as apellidosperNat"),
                   DB::Raw("IFNULL( `perNat`.`nombres` , '' ) as nombresperNat"),
                   DB::Raw("IFNULL( `perNat`.`telefono` , '' ) as telefonoperNat"),
                   DB::Raw("IFNULL( `perNat`.`direccion` , '' ) as direccionperNat"),
                   DB::Raw("IFNULL( `perNat`.`email` , '' ) as emailperNat"),
   
                   DB::Raw("IFNULL( `perJur`.`id` , '0' ) as idperJur"),
                   DB::Raw("IFNULL( `perJur`.`tipo` , '' ) as tipoperJur"),
                   DB::Raw("IFNULL( `perJur`.`tipo_documento` , '' ) as tipo_documentoperJur"),
                   DB::Raw("IFNULL( `perJur`.`num_documento` , '' ) as num_documentoperJur"),
                   DB::Raw("IFNULL( `perJur`.`apellidos` , '' ) as apellidosperJur"),
                   DB::Raw("IFNULL( `perJur`.`nombres` , '' ) as nombresperJur"),
                   DB::Raw("IFNULL( `perJur`.`telefono` , '' ) as telefonoperJur"),
                   DB::Raw("IFNULL( `perJur`.`direccion` , '' ) as direccionperJur"),
                   DB::Raw("IFNULL( `perJur`.`email` , '' ) as emailperJur")
        );

        $usaFiltro = false;
   
        if($fechaRegistro != null && $fechaRegistro != ""){
            $query->whereRaw('date(puesto_locals.created_at) = ?', [$fechaRegistro]);
            $usaFiltro = true;
        }
        if($nombres != null && trim($nombres, " ") != ""){
            $query->where('perNat.nombres','like','%'.$nombres.'%');
            $usaFiltro = true;
        }
        if($apellidos != null && trim($apellidos, " ") != ""){
            $query->where('perNat.apellidos','like','%'.$apellidos.'%');
            $usaFiltro = true;
        }
        if($nombrePuesto != null && trim($nombrePuesto, " ") != ""){
            $query->where('puesto_locals.nombre','like','%'.$nombrePuesto.'%');
            $usaFiltro = true;
        }
        if($numeroPuesto != null && trim($numeroPuesto, " ") != ""){
            $query->where('puesto_locals.numero','like','%'.$numeroPuesto.'%');
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
                array_push($data, array('','Nombres del Cliente: ', $nombres));
                $cont++;
            }
            if($apellidos != null && trim($apellidos, " ") != ""){
                array_push($data, array('','Apellidos del Cliente: ', $apellidos));
                $cont++;
            }
            if($nombrePuesto != null && trim($nombrePuesto, " ") != ""){
                array_push($data, array('','Nombre del Puesto: ', $nombrePuesto));
                $cont++;
            }
            if($numeroPuesto != null && trim($numeroPuesto, " ") != ""){
                array_push($data, array('','Número del Puesto: ', $numeroPuesto));
                $cont++;
            }
        }
        else{
            array_push($data, array(''));
        }

        $cont = $cont + 3;



        array_push($data, array('N°','FECHA DE REGISTRO', 'NOMBRES CLIENTE', 'APELLIDOS CLIENTE', 'DNI','CELULAR','CORREO ELECTRONICO','NOMBRE DE PUESTO','NUMERO DE PUESTO','RUC','RAZON SOCIAL'));

        foreach ($registrosimp as $key => $dato) {
            array_push($data, array($key+1,
                pasFechaVista(substr($dato->created_at, 0, 10)).' '.substr($dato->created_at, 11),
                $dato->nombresperNat,
                $dato->apellidosperNat,
                $dato->num_documentoperNat,
                $dato->telefonoperNat,
                $dato->emailperNat,
                $dato->nombrePuesto,
                $dato->numeroPuesto,                        
                $dato->num_documentoperJur,                        
                $dato->nombresperJur,                        
            ));
        }

        $export = new Reporte2Export($data, $cont);

        return Excel::download($export, 'reporte_clientes.xlsx');
    }

    public function export2(Request $request) 
    {
        $fechaRegistro=$request->fechaRegistro;
        $nombres=$request->nombres;
        $apellidos=$request->apellidos;
        $nombrePuesto=$request->nombrePuesto;
        $numeroPuesto=$request->numeroPuesto;
        $razonSocial=$request->razonSocial;

        $data=[];

        $titulo='REPORTE DE PUESTOS DE NEGOCIO';

        array_push($data, array($titulo));
        array_push($data, array(''));

        $cont = 1;

        $query = DB::table('puesto_locals')
     ->join('zonas', 'zonas.id', '=', 'puesto_locals.zona_id')
     /* ->join('puesto_local_personas', 'puesto_locals.id', '=', 'puesto_local_personas.puesto_local_id')
     ->leftjoin('personas as perNat', 'personas.id', '=', 'puesto_local_personas.persona_id') */

     ->leftJoin('puesto_local_personas as puestoPerNat',  function($join) {
        $join->on('puestoPerNat.puesto_local_id', '=', 'puesto_locals.id');
        $join->on('puestoPerNat.tipo', '=', DB::raw('1'));
        $join->on('puestoPerNat.borrado', '=', DB::raw('0'));
        $join->on('puestoPerNat.activo', '=', DB::raw('1'));
    })

     ->leftJoin('personas as perNat',  function($join) {
        $join->on('perNat.id', '=', 'puestoPerNat.persona_id');
        $join->on('perNat.tipo', '=', DB::raw('1'));
    })

    ->leftJoin('puesto_local_personas as puestoPerJur',  function($join) {
        $join->on('puestoPerJur.puesto_local_id', '=', 'puesto_locals.id');
        $join->on('puestoPerJur.tipo', '=', DB::raw('2'));
        $join->on('puestoPerJur.borrado', '=', DB::raw('0'));
        $join->on('puestoPerJur.activo', '=', DB::raw('1'));
    })

     ->leftJoin('personas as perJur',  function($join) {
        $join->on('perJur.id', '=', 'puestoPerJur.persona_id');
        $join->on('perJur.tipo', '=', DB::raw('2'));
    })

    ->leftJoin('medidors',  function($join) {
        $join->on('puesto_locals.id', '=', 'medidors.puesto_local_id');
        $join->on('medidors.borrado', '=', DB::raw('0'));
    })

     ->where('puesto_locals.borrado','0')
     ->orderBy('zonas.nombre')
     ->orderBy('puesto_locals.numero')
     ->orderBy('puesto_locals.nombre')
     ->select('puesto_locals.id',
                'puesto_locals.nombre as nombrePuesto',
                'puesto_locals.numero as numeroPuesto',
                'puesto_locals.direccion',
                'puesto_locals.tipo',
                'puesto_locals.referenia',
                'puesto_locals.zona_id',
                'puesto_locals.alta',
                'puesto_locals.baja',
                'puesto_locals.activo',
                'puesto_locals.borrado',
                'puesto_locals.created_at',
                'puesto_locals.updated_at',
                'zonas.nombre as zona',


                DB::Raw("IFNULL( `perNat`.`id` , '0' ) as idperNat"),
                DB::Raw("IFNULL( `perNat`.`tipo` , '' ) as tipoperNat"),
                DB::Raw("IFNULL( `perNat`.`tipo_documento` , '' ) as tipo_documentoperNat"),
                DB::Raw("IFNULL( `perNat`.`num_documento` , '' ) as num_documentoperNat"),
                DB::Raw("IFNULL( `perNat`.`apellidos` , '' ) as apellidosperNat"),
                DB::Raw("IFNULL( `perNat`.`nombres` , '' ) as nombresperNat"),
                DB::Raw("IFNULL( `perNat`.`telefono` , '' ) as telefonoperNat"),
                DB::Raw("IFNULL( `perNat`.`direccion` , '' ) as direccionperNat"),
                DB::Raw("IFNULL( `perNat`.`email` , '' ) as emailperNat"),

                DB::Raw("IFNULL( `perJur`.`id` , '0' ) as idperJur"),
                DB::Raw("IFNULL( `perJur`.`tipo` , '' ) as tipoperJur"),
                DB::Raw("IFNULL( `perJur`.`tipo_documento` , '' ) as tipo_documentoperJur"),
                DB::Raw("IFNULL( `perJur`.`num_documento` , '' ) as num_documentoperJur"),
                DB::Raw("IFNULL( `perJur`.`apellidos` , '' ) as apellidosperJur"),
                DB::Raw("IFNULL( `perJur`.`nombres` , '' ) as nombresperJur"),
                DB::Raw("IFNULL( `perJur`.`telefono` , '' ) as telefonoperJur"),
                DB::Raw("IFNULL( `perJur`.`direccion` , '' ) as direccionperJur"),
                DB::Raw("IFNULL( `perJur`.`email` , '' ) as emailperJur"),

                DB::Raw("IFNULL( `medidors`.`id` , '0' ) as idmedidors"),
                DB::Raw("IFNULL( `medidors`.`activo` , '0' ) as estadoServicio"),


            );

        $usaFiltro = false;

        if($fechaRegistro != null && $fechaRegistro != ""){
            $query->where('puesto_locals.alta', $fechaRegistro);
            $usaFiltro = true;
        }
        if($nombres != null && trim($nombres, " ") != ""){
            $query->where('perNat.nombres','like','%'.$nombres.'%');
            $usaFiltro = true;
        }
        if($apellidos != null && trim($apellidos, " ") != ""){
            $query->where('perNat.apellidos','like','%'.$apellidos.'%');
            $usaFiltro = true;
        }
        if($nombrePuesto != null && trim($nombrePuesto, " ") != ""){
            $query->where('puesto_locals.nombre','like','%'.$nombrePuesto.'%');
            $usaFiltro = true;
        }
        if($numeroPuesto != null && trim($numeroPuesto, " ") != ""){
            $query->where('puesto_locals.numero','like','%'.$numeroPuesto.'%');
            $usaFiltro = true;
        }
        if($razonSocial != null && trim($razonSocial, " ") != ""){
            $query->where('perJur.nombres','like','%'.$numeroPuesto.'%');
            $usaFiltro = true;
        }
        
        $registrosimp=$query->get();

        if($usaFiltro){
            array_push($data, array('Filtros de Búsqueda:'));

            if($fechaRegistro != null && $fechaRegistro != ""){
                array_push($data, array('','Fecha de Inicio de Actividades: ', pasFechaVista(substr($fechaRegistro, 0, 10))));
                $cont++;
            }
            if($nombrePuesto != null && trim($nombrePuesto, " ") != ""){
                array_push($data, array('','Nombre del Puesto: ', $nombrePuesto));
                $cont++;
            }
            if($numeroPuesto != null && trim($numeroPuesto, " ") != ""){
                array_push($data, array('','Número del Puesto: ', $numeroPuesto));
                $cont++;
            }
            if($razonSocial != null && trim($razonSocial, " ") != ""){
                array_push($data, array('','Razón Social: ', $razonSocial));
                $cont++;
            }
            if($nombres != null && trim($nombres, " ") != ""){
                array_push($data, array('','Nombres del Cliente: ', $nombres));
                $cont++;
            }
            if($apellidos != null && trim($apellidos, " ") != ""){
                array_push($data, array('','Apellidos del Cliente: ', $apellidos));
                $cont++;
            }
            
        }
        else{
            array_push($data, array(''));
        }

        $cont = $cont + 3;



        array_push($data, array('N°','FECHA DE INICIO DE ACTIVIDADES', 'UBICACION PUESTO', 'NOMBRE PUESTO', 'RESPONSABLE PUESTO','RAZON SOCIAL','TIPO DE PUESTO','ESTADO DE PUESTO','ESTADO DE SERVICIO'));

        foreach ($registrosimp as $key => $dato) {
            array_push($data, array($key+1,
                pasFechaVista($dato->alta),
                $dato->zona.' '.$dato->direccion,
                $dato->nombrePuesto.' '.$dato->numeroPuesto,
                $dato->nombresperNat.' '.$dato->apellidosperNat,
                $dato->nombresperJur,
                $dato->tipo,
                activoInactivo($dato->activo),
                estadoServicio($dato->estadoServicio),                        
            ));
        }

        $export = new Reporte3Export($data, $cont);

        return Excel::download($export, 'reporte_puestos_negocio.xlsx');
    }
}

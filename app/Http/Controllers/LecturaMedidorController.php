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

use stdClass;
use DB;
use Storage;
set_time_limit(600);

class LecturaMedidorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $buscar=$request->busca;

        $registros = DB::table('medidors')
     ->join('puesto_locals', 'puesto_locals.id', '=', 'medidors.puesto_local_id')
     ->join('zonas', 'zonas.id', '=', 'puesto_locals.zona_id')
     ->join('proceso_lecturas',  function($join){
            $join->on('proceso_lecturas.estado', '>=', DB::raw('1'));
            $join->on('proceso_lecturas.estado', '<', DB::raw('3'));
        })

     ->leftJoin('lectura_medidors',  function($join) {
            $join->on('lectura_medidors.proceso_lectura_id', '=', 'proceso_lecturas.id');
            $join->on('lectura_medidors.medidors_id', '=', 'medidors.id');
            $join->on('lectura_medidors.borrado', '=', DB::raw('0'));
        })

     ->leftJoin('users',  function($join) {
            $join->on('lectura_medidors.user_programado_id', '=', 'users.id');
        })

    ->leftJoin('tipo_users',  function($join) {
            $join->on('users.tipo_user_id', '=', 'tipo_users.id');
        })

    ->leftJoin('personas',  function($join) {
            $join->on('users.persona_id', '=', 'personas.id');
        })

    ->leftJoin('trabajadors',  function($join) {
            $join->on('trabajadors.user_id', '=', 'users.id');
        })

     ->where('puesto_locals.borrado', '0')
     ->where('puesto_locals.activo', '1')
     ->where('medidors.borrado', '0')
     ->where('medidors.activo', '1')
     ->where(function($query) use ($buscar){
        $query->where('medidors.serie','like','%'.$buscar.'%');
        $query->orWhere('medidors.descripcion','like','%'.$buscar.'%');
        })
     ->orderBy('puesto_locals.zona_id')
     ->orderBy('puesto_locals.numero')
     ->orderBy('medidors.alta')
     ->select('medidors.id',
                'medidors.serie',
                'medidors.descripcion',
                'medidors.alta',
                'medidors.baja',
                'medidors.activo',
                'medidors.borrado',
                'medidors.created_at',
                'medidors.updated_at',
                'medidors.puesto_local_id',

                'puesto_locals.nombre as puesto',
                'puesto_locals.numero as numeroPuesto',
                'puesto_locals.direccion as dirPuesto',
                'puesto_locals.tipo as tipoPuesto',
                'puesto_locals.referenia as referenciaPuesto',
                'puesto_locals.zona_id',
                'puesto_locals.alta as altaPuesto',

                'zonas.nombre as nombreZona',
                'zonas.descripcion as descripcionZona',

                DB::Raw("IFNULL( `proceso_lecturas`.`id` , '0' ) as idProceso_lecturas"),

                DB::Raw("IFNULL( `lectura_medidors`.`id` , '0' ) as idLectura_medidors"),
                DB::Raw("IFNULL( `lectura_medidors`.`proceso_lectura_id` , '0' ) as proceso_lectura_idLectura_medidors"),
                DB::Raw("IFNULL( `lectura_medidors`.`medidors_id` , '0' ) as medidors_idLectura_medidors"),
                DB::Raw("IFNULL( `lectura_medidors`.`estado` , '0' ) as estadoLectura_medidors"),
                DB::Raw("IFNULL( `lectura_medidors`.`lectura_consistente` , '' ) as lectura_consistenteLectura_medidors"),
                DB::Raw("IFNULL( `lectura_medidors`.`lectura` , '' ) as lecturaLectura_medidors"),
                DB::Raw("IFNULL( `lectura_medidors`.`consumo_kw` , '' ) as consumo_kwLectura_medidors"),
                DB::Raw("IFNULL( `lectura_medidors`.`consumo_soles` , '' ) as consumo_solesLectura_medidors"),
                DB::Raw("IFNULL( `lectura_medidors`.`observaciones` , '' ) as observacionesLectura_medidors"),
                DB::Raw("IFNULL( `lectura_medidors`.`fecha_programacion` , '' ) as fecha_programacionLectura_medidors"),
                DB::Raw("IFNULL( `lectura_medidors`.`fecha_lectura` , '' ) as fecha_lecturaLectura_medidors"),


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

    public function altabaja(Request $request)
    {
        $id = $request->id;
        $serie = $request->serie;
        $descripcion = $request->descripcion;
        $alta = $request->alta;
        $baja = $request->baja;
        $activo = $request->activo;
        $borrado = $request->borrado;
        $created_at = $request->created_at;
        $updated_at = $request->updated_at;
        $puesto_local_id = $request->puesto_local_id;
        $puesto = $request->puesto;
        $numeroPuesto = $request->numeroPuesto;
        $dirPuesto = $request->dirPuesto;
        $tipoPuesto = $request->tipoPuesto;
        $referenciaPuesto = $request->referenciaPuesto;
        $zona_id = $request->zona_id;
        $altaPuesto = $request->altaPuesto;
        $nombreZona = $request->nombreZona;
        $descripcionZona = $request->descripcionZona;
        $idProceso_lecturas = $request->idProceso_lecturas;
        $idLectura_medidors = $request->idLectura_medidors;
        $proceso_lectura_idLectura_medidors = $request->proceso_lectura_idLectura_medidors;
        $medidors_idLectura_medidors = $request->medidors_idLectura_medidors;
        $estadoLectura_medidors = $request->estadoLectura_medidors;
        $lectura_consistenteLectura_medidors = $request->lectura_consistenteLectura_medidors;
        $lecturaLectura_medidors = $request->lecturaLectura_medidors;
        $consumo_kwLectura_medidors = $request->consumo_kwLectura_medidors;
        $consumo_solesLectura_medidors = $request->consumo_solesLectura_medidors;
        $observacionesLectura_medidors = $request->observacionesLectura_medidors;
        $fecha_programacionLectura_medidors = $request->fecha_programacionLectura_medidors;
        $idUsers = $request->idUsers;
        $nameUsers = $request->nameUsers;
        $emailUsers = $request->emailUsers;
        $idTipo_users = $request->idTipo_users;
        $nombreTipo_users = $request->nombreTipo_users;
        $descripcionTipo_users = $request->descripcionTipo_users;
        $idPersonas = $request->idPersonas;
        $tipoPersonas = $request->tipoPersonas;
        $tipo_documentoPersonas = $request->tipo_documentoPersonas;
        $num_documentoPersonas = $request->num_documentoPersonas;
        $apellidosPersonas = $request->apellidosPersonas;
        $nombresPersonas = $request->nombresPersonas;
        $telefonoPersonas = $request->telefonoPersonas;
        $direccionPersonas = $request->direccionPersonas;
        $emailPersonas = $request->emailPersonas;
        $idTrabajadors = $request->idTrabajadors;
        $cargoTrabajadors = $request->cargoTrabajadors;
        $oficina_idTrabajadors = $request->oficina_idTrabajadors;

        $fecha = date('Y-m-d H:i:s');
        $user = Auth::user()->id;

        $result='1';
        $msj='';
        $selector='';

        //$registro = ProcesoLectura::findOrFail($idProceso_lecturas);

        if($idUsers == null || $idUsers == '0' || $idUsers == ''){
            $result='0';
            $msj='Debe seleccionar un Operador válido';
            $selector='cbuidUser';

            return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
        }

        if($idLectura_medidors == null || $idLectura_medidors == '' || $idLectura_medidors == '0'){

            $registro = new LecturaMedidor;

            $registro->proceso_lectura_id=$idProceso_lecturas;
            $registro->medidors_id=$id;
            $registro->estado='1';
            $registro->borrado='0';
            $registro->user_programado_id=$idUsers;
            $registro->fecha_programacion=$fecha;

            $registro->save();

            $msj='Programación Registrada con Éxito';
        }
        else{
            $registro = LecturaMedidor::findOrFail($idLectura_medidors);

            $registro->user_programado_id=$idUsers;
            $registro->fecha_programacion=$fecha;

            $registro->save();

            $msj='Programación Modificada con Éxito';
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
        //
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
        $result='1';
        $msj='1';

        $registro = LecturaMedidor::findOrFail($id);
        $registro->delete();

        $msj='Programación eliminada exitosamente';


        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}

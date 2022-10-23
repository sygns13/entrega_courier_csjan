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
use App\Imagen;

use stdClass;
use DB;
use Storage;
set_time_limit(600);

class LecturaController extends Controller
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
            $join->on('proceso_lecturas.estado', '=', DB::raw('2'));
        })

     ->join('lectura_medidors',  function($join) {
            $join->on('lectura_medidors.proceso_lectura_id', '=', 'proceso_lecturas.id');
            $join->on('lectura_medidors.medidors_id', '=', 'medidors.id');
            $join->on('lectura_medidors.borrado', '=', DB::raw('0'));
        })

     ->join('users',  function($join) {
            $join->on('lectura_medidors.user_programado_id', '=', 'users.id');
            if(Auth::user()->tipo_user_id == 4){
                $join->on('users.id', '=', DB::raw(Auth::user()->id));
            }
        })

    ->join('tipo_users',  function($join) {
            $join->on('users.tipo_user_id', '=', 'tipo_users.id');
        })

    ->join('personas',  function($join) {
            $join->on('users.persona_id', '=', 'personas.id');
        })

    ->join('trabajadors',  function($join) {
            $join->on('trabajadors.user_id', '=', 'users.id');
        })

    ->leftjoin('imagens',  function($join) {
            $join->on('imagens.lectura_medidor_id', '=', 'lectura_medidors.id');
            $join->on('imagens.activo', '=', DB::raw('1'));
            $join->on('imagens.borrado', '=', DB::raw('0'));
        })

    ->leftjoin('imagens as imagensMed',  function($join) {
            $join->on('imagensMed.lectura_medidor_id', '=', 'lectura_medidors.id');
            $join->on('imagensMed.activo', '=', DB::raw('2'));
            $join->on('imagensMed.borrado', '=', DB::raw('0'));
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
                'medidors.lectura_ultima',
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
                DB::Raw("IFNULL( `lectura_medidors`.`lectura_ultima` , '' ) as lectura_ultimaLectura_medidors"),
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
                
                DB::Raw("IFNULL( `imagens`.`id` , '0' ) as idImagens"),
                DB::Raw("IFNULL( `imagens`.`ruta_img` , '' ) as ruta_imgImagens"),

                DB::Raw("IFNULL( `imagensMed`.`id` , '0' ) as idImagensMed"),
                DB::Raw("IFNULL( `imagensMed`.`ruta_img` , '' ) as ruta_imgImagensMed"),
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
        ini_set('upload_max_filesize','40M');

        $id = $request->id; // id medidor
        $idLectura_medidors = $request->idLectura_medidors;
        $lecturaLectura_medidors = $request->lecturaLectura_medidors;
        $observacionesLectura_medidors = $request->observacionesLectura_medidors;
        $tipoImage = $request->tipoImage;
        $tipoImageMed = $request->tipoImageMed;

        $imagen="";
        $img=$request->imagen;
        $segureImg=0;

        $imagenMed="";
        $imgMed=$request->imagenMed;
        $segureImgMed=0;

        if($observacionesLectura_medidors == null){
            $observacionesLectura_medidors = '';
        }
        
        $fecha = date('Y-m-d H:i:s');
        $user = Auth::user()->id;

        if(intval($tipoImage) == 1){
            if ($request->hasFile('imagen')) { 

                $aux='imagen-'.date('d-m-Y').'-'.date('H-i-s');
                $input  = array('imagen' => $img) ;
                $reglas = array('imagen' => 'required||mimes:png,jpg,jpeg,gif,jpe,PNG,JPG,JPEG,GIF,JPE');
                $validator = Validator::make($input, $reglas);

                $input2  = array('imagen' => $img) ;
                $reglas2 = array('imagen' => 'required|file:1,409600');
                $validatorF = Validator::make($input2, $reglas2);

                if ($validator->fails())
                {

                $segureImg=1;
                $msj="El archivo ingresado como imagen de display no es una imagen válida, ingrese otro archivo o limpie el formulario ";
                $result='0';
                $selector='archivo';
                }
                elseif($validatorF->fails())
                {

                $segureImg=1;
                $msj="El archivo ingresado como imagen de display tiene un tamaño no válido superior a los 40MB, ingrese otro archivo o limpie el formulario";
                $result='0';
                $selector='archivo';
                }

                else
                {
                    //$nombre=$img->getClientOriginalName();
                    $extension=$img->getClientOriginalExtension();
                    $nuevoNombre=$aux.".".$extension;

                    /* $imgR = Image::make($img);
                    $imgR->resize(1500, 500, function ($constraint) {
                        $constraint->aspectRatio();
                    })->stream(); */

                    $subir=false;
                    $subir=Storage::disk('imagen')->put($nuevoNombre, \File::get($img));

                    if($subir){
                        $imagen=$nuevoNombre;

                    }
                    else{
                        $msj="Error al subir la imagen de display, intentelo nuevamente luego";
                        $segureImg=1;
                        $result='0';
                        $selector='archivo';
                    }
                }
            }
            else{
                $msj="Debe de adjuntar una imagen de display válida, ingrese un archivo";
                $segureImg=1;
                $result='0';
                $selector='archivo';

                Storage::disk('imagen')->delete($imagen);
                return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
            }

        }
        else{
            if($img != null && strlen($img) > 0 && $img != "null"){
                $img = base64_decode(preg_replace('/^[^,]*,/', '', $img));

                //$nombre=$img->getClientOriginalName();
                $aux='imagen-'.date('d-m-Y').'-'.date('H-i-s');
                $extension="png";
                $nuevoNombre=$aux.".".$extension;

                $subir=false;
                $subir=Storage::disk('imagen')->put($nuevoNombre, $img);

                if($subir){
                    $imagen=$nuevoNombre;

                }
                else{
                    $msj="Error al subir la imagen de display, intentelo nuevamente luego";
                    $segureImg=1;
                    $result='0';
                    $selector='archivo';
                }

            }else{
                $msj="Debe de adjuntar una imagen de display válida, Tome bien la Fotografia";
                $segureImg=1;
                $result='0';
                $selector='archivo';

                Storage::disk('imagen')->delete($imagen);
                return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
            }
        }



        if(intval($tipoImageMed) == 1){
            if ($request->hasFile('imagenMed')) { 

                $aux='imagen-'.date('d-m-Y').'-'.date('H-i-s');
                $input  = array('imagen' => $imgMed) ;
                $reglas = array('imagen' => 'required||mimes:png,jpg,jpeg,gif,jpe,PNG,JPG,JPEG,GIF,JPE');
                $validator = Validator::make($input, $reglas);

                $input2  = array('imagen' => $imgMed) ;
                $reglas2 = array('imagen' => 'required|file:1,409600');
                $validatorF = Validator::make($input2, $reglas2);

                if ($validator->fails())
                {

                $segureImgMed=1;
                $msj="El archivo ingresado como imagen de Medidor no es una imagen válida, ingrese otro archivo o limpie el formulario ";
                $result='0';
                $selector='archivoMed';
                }
                elseif($validatorF->fails())
                {

                $segureImgMed=1;
                $msj="El archivo ingresado como imagen de Medidor tiene un tamaño no válido superior a los 40MB, ingrese otro archivo o limpie el formulario";
                $result='0';
                $selector='archivoMed';
                }

                else
                {
                    //$nombre=$imgMed->getClientOriginalName();
                    $extension=$imgMed->getClientOriginalExtension();
                    $nuevoNombre=$aux.".".$extension;

                    /* $imgMedR = Image::make($imgMed);
                    $imgMedR->resize(1500, 500, function ($constraint) {
                        $constraint->aspectRatio();
                    })->stream(); */

                    $subir=false;
                    $subir=Storage::disk('imgmedidor')->put($nuevoNombre, \File::get($imgMed));

                    if($subir){
                        $imagenMed=$nuevoNombre;

                    }
                    else{
                        $msj="Error al subir la imagen de Medidor, intentelo nuevamente luego";
                        $segureImgMed=1;
                        $result='0';
                        $selector='archivo';
                    }
                }
            }
            else{
                $msj="Debe de adjuntar una imagen de Medidor válida, ingrese un archivo";
                $segureImgMed=1;
                $result='0';
                $selector='archivo';

                Storage::disk('imgmedidor')->delete($imagenMed);
                return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
            }

        }
        else{
            if($imgMed != null && strlen($imgMed) > 0 && $imgMed != "null"){
                $imgMed = base64_decode(preg_replace('/^[^,]*,/', '', $imgMed));

                //$nombre=$imgMed->getClientOriginalName();
                $aux='imagen-'.date('d-m-Y').'-'.date('H-i-s');
                $extension="png";
                $nuevoNombre=$aux.".".$extension;

                $subir=false;
                $subir=Storage::disk('imgmedidor')->put($nuevoNombre, $imgMed);

                if($subir){
                    $imagenMed=$nuevoNombre;

                }
                else{
                    $msj="Error al subir la imagen de Medidor, intentelo nuevamente luego";
                    $segureImgMed=1;
                    $result='0';
                    $selector='archivo';
                }

            }else{
                $msj="Debe de adjuntar una imagen de Medidor válida, Tome bien la Fotografia";
                $segureImgMed=1;
                $result='0';
                $selector='archivo';

                Storage::disk('imgmedidor')->delete($imagenMed);
                return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
            }
        }

        if($segureImg==1 || $segureImgMed==1){
            Storage::disk('imagen')->delete($imagen);
            Storage::disk('imgmedidor')->delete($imagenMed);
            return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
        }
        
        $medidor = Medidor::find($id);
        $lectura_anterior = $medidor->lectura_ultima;
        
        //2 decimales
        $lecturaLectura_medidors = number_format(floatval($lecturaLectura_medidors), 2, '.', '');
        $lectura_anterior = number_format(floatval($lectura_anterior), 2, '.', '');

        $consumoKw =  number_format((floatval($lecturaLectura_medidors) - floatval($lectura_anterior)), 2, '.', '');

        $result = '1';
        $msj = '';
        $selector = '';

        if (floatval($consumoKw) <= 0)
        {
            Storage::disk('imagen')->delete($imagen);
            Storage::disk('imgmedidor')->delete($imagenMed);

            $result='0';
            $msj='El Resultado del Consumo no puede ser Negativo o 0';
            $selector='txtlecturaLectura_medidors';
        }
        else{
            $costoUnitarioKw = Config::where('name', 'costoUnitarioKwToSoles')->first();
            $consumoSoles = number_format((floatval($consumoKw) * floatval($costoUnitarioKw->value)), 2, '.', '');

            $registro = LecturaMedidor::findOrFail($idLectura_medidors);
            $registro->estado = "2";
            $registro->lectura_consistente = "1";
            $registro->lectura = $lecturaLectura_medidors;
            $registro->lectura_ultima = $lectura_anterior;
            $registro->consumo_kw = $consumoKw;
            $registro->consumo_soles = $consumoSoles;
            $registro->observaciones = $observacionesLectura_medidors;
            $registro->user_toma_lectura_id = $user;
            $registro->fecha_lectura = $fecha;
            
            $registro->save();
            
            
            $medidor->lectura_ultima = $lecturaLectura_medidors;
            $medidor->save();
            
            if($imagen != null && $imagen != ''){

                $regImagen = new Imagen;

                $regImagen->ruta_img=$imagen;
                $regImagen->consumo_kw_leido=$lecturaLectura_medidors;
                $regImagen->descripcion='';
                $regImagen->activo='1';
                $regImagen->borrado='0';
                $regImagen->lectura_medidor_id=$idLectura_medidors;

                $regImagen->save();
            }

            if($imagenMed != null && $imagenMed != ''){

                $regImagen = new Imagen;

                $regImagen->ruta_img=$imagenMed;
                $regImagen->consumo_kw_leido=$lecturaLectura_medidors;
                $regImagen->descripcion='';
                $regImagen->activo='2';
                $regImagen->borrado='0';
                $regImagen->lectura_medidor_id=$idLectura_medidors;

                $regImagen->save();
            }


            $msj='Toma de Lectura Realizada con Éxito';


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
        ini_set('upload_max_filesize','40M');

        $idLectura_medidors = $request->idLectura_medidors;
        $lecturaLectura_medidors = $request->lecturaLectura_medidors;
        $observacionesLectura_medidors = $request->observacionesLectura_medidors;

        $imagen="";
        $img=$request->imagen;
        $segureImg=0;
        $tipoImage = $request->tipoImage;

        $oldImg=$request->oldimg;

        $imagenMed="";
        $imgMed=$request->imagenMed;
        $segureImgMed=0;
        $tipoImageMed = $request->tipoImageMed;

        $oldImgMed=$request->oldimgMed;

        if($observacionesLectura_medidors == null){
            $observacionesLectura_medidors = '';
        }
        
        $fecha = date('Y-m-d H:i:s');
        $user = Auth::user()->id;
        if(intval($tipoImage) == 1){
            if ($request->hasFile('imagen')) { 

                $aux='imagen'.date('d-m-Y').'-'.date('H-i-s');
                $input  = array('image' => $img) ;
                $reglas = array('image' => 'required|mimes:png,jpg,jpeg,gif,jpe,PNG,JPG,JPEG,GIF,JPE');
                $validator = Validator::make($input, $reglas);

                $input2  = array('imagen' => $img) ;
                $reglas2 = array('imagen' => 'required|file:1,409600');
                $validatorF = Validator::make($input2, $reglas2);

                if ($validator->fails())
                {

                $segureImg=1;
                $msj="El archivo ingresado como imagen de display no es una imagen válida, ingrese otro archivo o limpie el formulario";
                $result='0';
                $selector='imagenE';
                }
                elseif($validatorF->fails())
                {

                $segureImg=1;
                $msj="El archivo ingresado como imagen de display tiene un tamaño no válido superior a los 40MB, ingrese otro archivo o limpie el formulario";
                $result='0';
                $selector='imagenE';
                }

                else
                {
                    //$nombre=$img->getClientOriginalName();
                    $extension=$img->getClientOriginalExtension();
                    $nuevoNombre=$aux.".".$extension;

                    /* $imgR = Image::make($img);
                    $imgR->resize(1500, 500, function ($constraint) {
                        $constraint->aspectRatio();
                    })->stream(); */

                    $subir=false;
                    $subir=Storage::disk('imagen')->put($nuevoNombre, \File::get($img));

                    if($subir){
                        $imagen=$nuevoNombre;

                    }
                    else{
                        $msj="Error al subir la imagen de display, intentelo nuevamente luego";
                        $segureImg=1;
                        $result='0';
                        $selector='imagenE';
                    }
                }
            }
        }
        if(intval($tipoImage) == 2){
            if($img != null && strlen($img) > 0 && $img != "null"){
                $img = base64_decode(preg_replace('/^[^,]*,/', '', $img));

                //$nombre=$img->getClientOriginalName();
                $aux='imagen-'.date('d-m-Y').'-'.date('H-i-s');
                $extension="png";
                $nuevoNombre=$aux.".".$extension;

                $subir=false;
                $subir=Storage::disk('imagen')->put($nuevoNombre, $img);

                if($subir){
                    $imagen=$nuevoNombre;

                }
                else{
                    $msj="Error al subir la imagen de display, intentelo nuevamente luego";
                    $segureImg=1;
                    $result='0';
                    $selector='archivo';
                }

            }
        }


        if(intval($tipoImageMed) == 1){
            if ($request->hasFile('imagenMed')) { 

                $aux='imagen'.date('d-m-Y').'-'.date('H-i-s');
                $input  = array('image' => $imgMed) ;
                $reglas = array('image' => 'required|mimes:png,jpg,jpeg,gif,jpe,PNG,JPG,JPEG,GIF,JPE');
                $validator = Validator::make($input, $reglas);

                $input2  = array('imagen' => $imgMed) ;
                $reglas2 = array('imagen' => 'required|file:1,409600');
                $validatorF = Validator::make($input2, $reglas2);

                if ($validator->fails())
                {

                $segureImgMed=1;
                $msj="El archivo ingresado como imagen de Medidor no es una imagen válida, ingrese otro archivo o limpie el formulario";
                $result='0';
                $selector='imagenEMed';
                }
                elseif($validatorF->fails())
                {

                $segureImgMed=1;
                $msj="El archivo ingresado como imagen de Medidor tiene un tamaño no válido superior a los 40MB, ingrese otro archivo o limpie el formulario";
                $result='0';
                $selector='imagenEMed';
                }

                else
                {
                    //$nombre=$imgMed->getClientOriginalName();
                    $extension=$imgMed->getClientOriginalExtension();
                    $nuevoNombre=$aux.".".$extension;

                    /* $imgMedR = Image::make($imgMed);
                    $imgMedR->resize(1500, 500, function ($constraint) {
                        $constraint->aspectRatio();
                    })->stream(); */

                    $subir=false;
                    $subir=Storage::disk('imgmedidor')->put($nuevoNombre, \File::get($imgMed));

                    if($subir){
                        $imagenMed=$nuevoNombre;

                    }
                    else{
                        $msj="Error al subir la imagen de Medidor, intentelo nuevamente luego";
                        $segureImgMed=1;
                        $result='0';
                        $selector='imagenEMed';
                    }
                }
            }
        }
        if(intval($tipoImageMed) == 2){
            if($imgMed != null && strlen($imgMed) > 0 && $imgMed != "null"){
                //var_dump($imgMed);
                //return
                $imgMed = base64_decode(preg_replace('/^[^,]*,/', '', $imgMed));

                //$nombre=$imgMed->getClientOriginalName();
                $aux='imagen-'.date('d-m-Y').'-'.date('H-i-s');
                $extension="png";
                $nuevoNombre=$aux.".".$extension;

                $subir=false;
                $subir=Storage::disk('imgmedidor')->put($nuevoNombre, $imgMed);

                if($subir){
                    $imagenMed=$nuevoNombre;

                }
                else{
                    $msj="Error al subir la imagen de Medidor, intentelo nuevamente luego";
                    $segureImgMed=1;
                    $result='0';
                    $selector='archivo';
                }

            }
        }

        if($segureImg==1 || $segureImgMed==1){

            Storage::disk('imagen')->delete($imagen);
            Storage::disk('imgmedidor')->delete($imagenMed);
            return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
        }
        
        $medidor = Medidor::find($id);
        $registro = LecturaMedidor::findOrFail($idLectura_medidors);
        
        $lectura_anterior = $registro->lectura_ultima;
        
        //2 decimales
        $lecturaLectura_medidors = number_format(floatval($lecturaLectura_medidors), 2, '.', '');
        $lectura_anterior = number_format(floatval($lectura_anterior), 2, '.', '');

        $consumoKw =  number_format((floatval($lecturaLectura_medidors) - floatval($lectura_anterior)), 2, '.', '');

        $result = '1';
        $msj = '';
        $selector = '';

        if (floatval($consumoKw) <= 0)
        {
            Storage::disk('imagen')->delete($imagen);
            Storage::disk('imgmedidor')->delete($imagenMed);
            $result='0';
            $msj='El Resultado del Consumo no puede ser Negativo o 0';
            $selector='txtlecturaLectura_medidorsE';

            Storage::disk('imagen')->delete($imagen);
        }
        else{
            $costoUnitarioKw = Config::where('name', 'costoUnitarioKwToSoles')->first();
            $consumoSoles = number_format((floatval($consumoKw) * floatval($costoUnitarioKw->value)), 2, '.', '');

            
            $registro->lectura_consistente = "1";
            $registro->lectura = $lecturaLectura_medidors;
            $registro->consumo_kw = $consumoKw;
            $registro->consumo_soles = $consumoSoles;
            $registro->observaciones = $observacionesLectura_medidors;
            $registro->user_toma_lectura_id = $user;
            $registro->fecha_lectura = $fecha;

            $registro->save();


            $medidor->lectura_ultima = $lecturaLectura_medidors;
            $medidor->save();

            if(strlen($imagen)>0){
                Storage::disk('imagen')->delete($oldImg);

                $registroOldImg = Imagen::where('lectura_medidor_id', $idLectura_medidors)->where('activo','1')->first();
                if($registroOldImg != null){
                    $registroOldImg->delete();
                }

                $regImagen = new Imagen;

                $regImagen->ruta_img=$imagen;
                $regImagen->consumo_kw_leido=$lecturaLectura_medidors;
                $regImagen->descripcion='';
                $regImagen->activo='1';
                $regImagen->borrado='0';
                $regImagen->lectura_medidor_id=$idLectura_medidors;

                $regImagen->save();
            }

            if(strlen($imagenMed)>0){
                Storage::disk('imgmedidor')->delete($oldImgMed);

                $registroOldImg = Imagen::where('lectura_medidor_id', $idLectura_medidors)->where('activo','2')->first();

                if($registroOldImg != null){
                    $registroOldImg->delete();
                }

                $regImagen = new Imagen;
    
                $regImagen->ruta_img=$imagenMed;
                $regImagen->consumo_kw_leido=$lecturaLectura_medidors;
                $regImagen->descripcion='';
                $regImagen->activo='2';
                $regImagen->borrado='0';
                $regImagen->lectura_medidor_id=$idLectura_medidors;

                $regImagen->save();
                
            }

            $msj='Toma de Lectura Actualizada con Éxito';


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
}

<div class="box box-primary panel-group">
    <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
    <h3 class="box-title">Reporte de Libro de Lecturas</h3>
      <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
      Volver</a>
    </div>
  
  <div class="box-body" style="border: 1px solid #3c8dbc;">
      <div class="form-group form-primary">
        {{-- <button type="button" class="btn btn-primary" id="btnCrear" @click.prevent="nuevo()"><i class="fa fa-money" aria-hidden="true" ></i> Nuevo Recibo</button> --}}

        <div class="col-md-12" style="padding-top: 10px;">
          <div class="form-group">
            <label for="cbuidProceso" class="col-sm-2 control-label">Periodo de Reporte:<spam style="color:red;">*</spam></label>
            <div class="col-sm-4">
              <select class="form-control" id="cbuidProceso" name="cbuidProceso" v-model="idProcesoLectura" @change="cambiarProcesoLectura">
                @foreach ($procesosLecturas as $dato)
                  <option value="{{$dato->id}}">{{$dato->mesNombre}}, {{$dato->anio}}</option> 
                @endforeach
              </select>
            </div>
          </div>
        </div>

        @if(accesoUser([1,2,3,4]))
        <div class="col-md-12" style="padding-top: 10px;">
          <div class="form-group" style="font-size: 12px;">
            <label for="txtubicacion" class="col-sm-2 control-label">Ubicación del Puesto:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control input" id="txtubicacion" name="txtubicacion" placeholder="Todos" maxlength="250"  v-model="ubicacion" @change="cambiarfiltro">
            </div>

            <label for="txtnombre" class="col-sm-1 control-label">Nombre del Puesto:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control input" id="txtnombre" name="txtnombre" placeholder="Todos" maxlength="250"  v-model="nombre" @change="cambiarfiltro">
            </div>
          </div>
        </div>

        <div class="col-md-12" style="padding-top: 10px;">
          <div class="form-group" style="font-size: 12px;">
              <label for="txtserie" class="col-sm-2 control-label">Serie de Medidor:</label>
              <div class="col-sm-4">
                <input type="text" class="form-control input" id="txtserie" name="txtserie" placeholder="Todos" maxlength="250"  v-model="serie" @change="cambiarfiltro">
              </div>
          </div>
        </div>
        @endif


        

          <div class="col-md-12" style="padding-top: 0px;">
              <hr style="border: 1px solid gray;"> 
            </div>


          <div class="col-md-12">
          <button type="button" class="btn btn-primary" id="btnCargarRep" @click.prevent="buscarDatos()" style="margin-top: 15px;"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Cargar Reporte</button>

          

          <button type="button" class="btn btn-warning" id="btnLimpiar" @click.prevent="cancelFiltros()" style="margin-top: 15px;"><i class="fa fa-list" aria-hidden="true" ></i> Limpiar Filtros</button>
        
        </div>

          <div v-show="divloaderNuevo" style="padding-top: 100px;">

            <div class="sk-circle" >
  
              <div class="sk-circle1 sk-child"></div>
              <div class="sk-circle2 sk-child"></div>
              <div class="sk-circle3 sk-child"></div>
              <div class="sk-circle4 sk-child"></div>
              <div class="sk-circle5 sk-child"></div>
              <div class="sk-circle6 sk-child"></div>
              <div class="sk-circle7 sk-child"></div>
              <div class="sk-circle8 sk-child"></div>
              <div class="sk-circle9 sk-child"></div>
              <div class="sk-circle10 sk-child"></div>
              <div class="sk-circle11 sk-child"></div>
              <div class="sk-circle12 sk-child"></div>
        
            </div>
            <center><h3 style="color:red"><b>Cargando Datos, Por Favor Espere un momento ...</b></h3></center>
          </div>
      </div>
      </div>
    </div>
  

  
  <div class="box box-primary" style="border: 1px solid #3c8dbc;" v-if="mostrartabla">
    <div class="box-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
      <h3 class="box-title">Reporte de Libro de Lecturas</h3>

    </div>


    <div class="col-md-12" style="padding-top: 15px;">
      <button type="button" class="btn btn-primary" id="btncrearReporte" @click.prevent="imprimirReporte()"><i class="fa fa-print" aria-hidden="true" ></i> Imprimir Reporte</button>
      <a type="button" class="btn btn-success" id="btnDescargarPlantilla" v-bind:href="'exportarExcel/reporte5?ubicacion='+ubicacion+'&idProcesoLectura='+idProcesoLectura+'&serie='+serie+'&nombre='+nombre" 
      data-placement="top" data-toggle="tooltip" title="Exportar en Excel Según filtros de búsqueda">
      <i class="fa fa-file-excel-o" aria-hidden="true" ></i> Exportar en Excel</a>
    </div>

    <div class="col-md-12" style="padding-top: 0px;">
      <hr style="border: 1px solid gray;"> 
    </div>


    <div class="col-md-12" style="padding-top: 0px;">
      <div class="col-md-6" v-if="idProcesoLectura!=null && idProcesoLectura!='0'">
        <h5><b>Periodo de Lectura: @{{procesoLectura}}</b></h5>
        {{-- <h5 v-if="fechaRegistro==null || fechaRegistro==''"><b>Fecha de Registro: Siempre</b></h5> --}}
      </div>

      <div class="col-md-6" v-if="ubicacion.trim().length>0">
        <h5><b>Ubicación del Puesto: @{{ubicacion}}</b></h5>
      </div> 

      <div class="col-md-6" v-if="nombre.trim().length>0">
        <h5><b>Nombre del Puesto: @{{nombre}}</b></h5>
      </div> 

      <div class="col-md-6" v-if="serie.trim().length>0">
        <h5><b>Serie de Medidor: @{{serie}}</b></h5>
      </div> 
 
    
    </div>
   
    <!-- /.box-header -->
    <div class="box-body table-responsive"> 

     

      <table class="table table-hover table-bordered table-dark table-condensed table-striped" id="tablaimp">
        <tbody><tr>
          <th style="border:1px solid #ddd;padding: 5px; width: 5%;">#</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 15%;">FECHA DE LECTURA</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 20%;">UBICACION PUESTO</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 15%;">NOMBRE PUESTO</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 10%;">SERIE MEDIDOR</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 10%;">ULTIMA LECTURA KW</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 25%;">FOTOGRAFIA</th>
        </tr>
        <tr v-for="registro, key in registros">
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{key+pagination.from}}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">
            <template v-if="registro.estado != '1'">
              @{{ registro.fecha_lectura.substring(0, 10) | pasfechaVista }} @{{ registro.fecha_lectura.substring(11) }}
            </template>
            <template v-if="registro.estado == '1'">
              LECTURA AUN NO TOMADA
            </template>
          </td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{ registro.nombreZona }} - @{{ registro.direccionPuestoLocal }}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{ registro.nombrePuestoLocal }} - N° @{{ registro.numeroPuestoLocal }}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{ registro.serieMedidor }}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">
            <template v-if="registro.estado != '1'">
              @{{ parseFloat(registro.lectura).toFixed(2) }}
            </template>
          </td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">
            <template v-if="registro.idImagens != '0'">
            <img v-bind:src="'{{ asset('/web/imagen/')}}'+'/'+registro.ruta_imgImagens" style="max-height: 200px;border: solid 1px black;" class="img-responsive" alt="Imagen de Lectura" id="imgLectura">
          </template>
          </td>
       </tr>
  
     </tbody></table>
  
   </div>
   <!-- /.box-body -->
   <div style="padding: 15px;">
     <div><h5>Registros por Página: @{{ pagination.per_page }}</h5></div>
     <nav aria-label="Page navigation example">
       <ul class="pagination">
        <li class="page-item" v-if="pagination.current_page>1">
         <a class="page-link" href="#" @click.prevent="changePage(1)">
          <span><b>Inicio</b></span>
        </a>
      </li>
  
      <li class="page-item" v-if="pagination.current_page>1">
       <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page-1)">
        <span>Atras</span>
      </a>
    </li>
    <li class="page-item" v-for="page in pagesNumber" v-bind:class="[page=== isActived ? 'active' : '']">
     <a class="page-link" href="#" @click.prevent="changePage(page)">
      <span>@{{ page }}</span>
    </a>
  </li>
  <li class="page-item" v-if="pagination.current_page< pagination.last_page">
   <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page+1)">
    <span>Siguiente</span>
  </a>
  </li>
  <li class="page-item" v-if="pagination.current_page< pagination.last_page">
   <a class="page-link" href="#" @click.prevent="changePage(pagination.last_page)">
    <span><b>Ultima</b></span>
  </a>
  </li>
  </ul>
  </nav>
  <div><h5>Registros Totales: @{{ pagination.total }}</h5></div>
  </div>
  </div>
















  <div class="box box-primary" style="display:none;">
    
      <div style="width: 100%; max-width: 30cm; height: auto; background-color: white; border: 1px solid white; margin-bottom:1cm!important;" id="divImp">
      <div style="padding-top: 0cm;;padding-left: 0cm; padding-right: 0cm;">

        <div id="titulo1" style="width:100%;">

          <div style="width:200px;position: absolute; font-size: 8px; float: left; text-align: left;">
            <b>Empresa Municipal de Mercados S.A.<b>
          </div>
          <div style="width:50px; position: absolute; font-size: 8px; float: right; right: 50px; top:0mm!important;" class="logorep">
            <img src="{{ asset('/img/emsa2.png') }}" class="img img-responsive">
          </div>
            <h3 class="box-title" style="padding-top:10px;font-size: 12px; text-align: center; font-weight: bold; width: 100%;    line-height: 2;"> 
              <center>REPORTE DE USUARIOS</center>
            </h3>
        </div>


        <div id="cabecera1" style="width:100%;">

          <div style="width:45%; display:inline-block;" v-if="idProcesoLectura!=null && idProcesoLectura!='0'">
            <h5 style="font-size:11px;"><b>Periodo de Lectura: @{{procesoLectura}}</b></h5>
            {{-- <h5 v-if="fechaRegistro==null || fechaRegistro==''"><b>Fecha de Registro: Siempre</b></h5> --}}
          </div>
    
          <div style="width:45%; display:inline-block;" v-if="ubicacion.trim().length>0">
            <h5 style="font-size:11px;"><b>Ubicación del Puesto: @{{ubicacion}}</b></h5>
          </div> 
    
          <div style="width:45%; display:inline-block;" v-if="nombre.trim().length>0">
            <h5 style="font-size:11px;"><b>Nombre del Puesto: @{{nombre}}</b></h5>
          </div> 
    
          <div style="width:45%; display:inline-block;" v-if="serie.trim().length>0">
            <h5 style="font-size:11px;"><b>Serie de Medidor: @{{serie}}</b></h5>
          </div> 
 
                  
        </div>


        <div class="box-body table-responsive" style="width:100%;">
          <table class="table table-hover table-bordered table-dark table-condensed table-striped" >
            <tbody><tr>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 5%;">#</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 15%;">FECHA DE LECTURA</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 20%;">UBICACION PUESTO</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 15%;">NOMBRE PUESTO</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 10%;">SERIE MEDIDOR</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 10%;">ULTIMA LECTURA KW</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 25%;">FOTOGRAFIA</th>
            </tr>


            <tr v-for="registro, key in registrosimp">
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{key+1}}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">
                <template v-if="registro.estado != '1'">
                  @{{ registro.fecha_lectura.substring(0, 10) | pasfechaVista }} @{{ registro.fecha_lectura.substring(11) }}
                </template>
                <template v-if="registro.estado == '1'">
                  LECTURA AUN NO TOMADA
                </template>
              </td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ registro.nombreZona }} - @{{ registro.direccionPuestoLocal }}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ registro.nombrePuestoLocal }} - N° @{{ registro.numeroPuestoLocal }}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ registro.serieMedidor }}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">
                <template v-if="registro.estado != '1'">
                  @{{ parseFloat(registro.lectura).toFixed(2) }}
                </template>
              </td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">
                <template v-if="registro.idImagens != '0'">
                <img v-bind:src="'{{ asset('/web/imagen/')}}'+'/'+registro.ruta_imgImagens" style="max-height: 200px;border: solid 1px black;" class="img-responsive" alt="Imagen de Lectura" id="imgLectura">
              </template>
              </td>
           </tr>
         </tbody></table>
        </div>
      </div>
      </div>
  </div>
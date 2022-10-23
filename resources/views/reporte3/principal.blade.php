<div class="box box-primary panel-group">
    <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
    <h3 class="box-title">Reporte de Puestos de Negocio</h3>
      <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
      Volver</a>
    </div>
  
  <div class="box-body" style="border: 1px solid #3c8dbc;">
      <div class="form-group form-primary">
        {{-- <button type="button" class="btn btn-primary" id="btnCrear" @click.prevent="nuevo()"><i class="fa fa-money" aria-hidden="true" ></i> Nuevo Recibo</button> --}}


        <div class="col-md-12" style="padding-top: 10px;">
          <div class="form-group" style="font-size: 12px;">
              <label for="txtfechaRegistro" class="col-sm-2 control-label">Fecha de Inicio de Actividades:</label>
               <div class="col-sm-3">
                    <input type="date" name="txtfechaRegistro" id="txtfechaRegistro" v-model="fechaRegistro" class="form-control input" @change="cambiarfiltro">
              </div>
          </div>
        </div>

        <div class="col-md-12" style="padding-top: 10px;">
          <div class="form-group"style="font-size: 12px;">
            <label for="txtnombrePuesto" class="col-sm-2 control-label">Nombre del Puesto:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control input" id="txtnombrePuesto" name="txtnombrePuesto" placeholder="Todos" maxlength="250"  v-model="nombrePuesto" @change="cambiarfiltro">
            </div>

            <label for="txtnumeroPuesto" class="col-sm-1 control-label">Número del Puesto:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control input" id="txtnumeroPuesto" name="txtnumeroPuesto" placeholder="Todos" maxlength="250"  v-model="numeroPuesto" @change="cambiarfiltro">
            </div>
          </div>
        </div> 

        <div class="col-md-12" style="padding-top: 10px;">
          <div class="form-group"style="font-size: 12px;">
            <label for="txtrazonSocial" class="col-sm-2 control-label">Razón Social:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control input" id="txtrazonSocial" name="txtrazonSocial" placeholder="Todos" maxlength="250"  v-model="razonSocial" @change="cambiarfiltro">
            </div>
          </div>
        </div>  
        

        <div class="col-md-12" style="padding-top: 10px;">
          <div class="form-group"style="font-size: 12px;">
            <label for="txtnombres" class="col-sm-2 control-label">Nombres del Cliente:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control input" id="txtnombres" name="txtnombres" placeholder="Todos" maxlength="250"  v-model="nombres" @change="cambiarfiltro">
            </div>

            <label for="txtapellidos" class="col-sm-1 control-label">Apellidos del Cliente:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control input" id="txtapellidos" name="txtapellidos" placeholder="Todos" maxlength="250"  v-model="apellidos" @change="cambiarfiltro">
            </div>
          </div>
        </div>  

        



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
      <h3 class="box-title">Reporte General de Puestos de Negocio</h3>

    </div>


    <div class="col-md-12" style="padding-top: 15px;">
      <button type="button" class="btn btn-primary" id="btncrearReporte" @click.prevent="imprimirReporte()"><i class="fa fa-print" aria-hidden="true" ></i> Imprimir Reporte</button>
      <a type="button" class="btn btn-success" id="btnDescargarPlantilla" v-bind:href="'exportarExcel/reporte3?fechaRegistro='+fechaRegistro+'&nombres='+nombres+'&apellidos='+apellidos+'&nombrePuesto='+nombrePuesto+'&numeroPuesto='+numeroPuesto+'&razonSocial='+razonSocial" 
      data-placement="top" data-toggle="tooltip" title="Exportar en Excel Según filtros de búsqueda">
      <i class="fa fa-file-excel-o" aria-hidden="true" ></i> Exportar en Excel</a>
    </div>

    <div class="col-md-12" style="padding-top: 0px;">
      <hr style="border: 1px solid gray;"> 
    </div>



    <div class="col-md-12" style="padding-top: 0px;">
      <div class="col-md-6" v-if="fechaRegistro!=null && fechaRegistro!=''">
        <h5><b>Fecha de Inicio de Actividades: @{{fechaRegistro | fecha}}</b></h5>
        {{-- <h5 v-if="fechaRegistro==null || fechaRegistro==''"><b>Fecha de Inicio de Actividades: Siempre</b></h5> --}}
      </div>

      <div class="col-md-6" v-if="nombrePuesto.trim().length>0">
        <h5 ><b>Nombre del Puesto: @{{nombrePuesto}}</b></h5>
      </div> 

      <div class="col-md-6" v-if="numeroPuesto.trim().length>0">
        <h5 ><b>Número del Puesto: @{{numeroPuesto}}</b></h5>
      </div> 

      <div class="col-md-6" v-if="razonSocial.trim().length>0">
        <h5 ><b>Razón Social: @{{razonSocial}}</b></h5>
      </div> 

      <div class="col-md-6" v-if="nombres.trim().length>0">
        <h5><b>Nombres del Cliente: @{{nombres}}</b></h5>
      </div> 

      <div class="col-md-6" v-if="apellidos.trim().length>0">
        <h5 ><b>Apellidos del Cliente: @{{apellidos}}</b></h5>
      </div>  

         
    </div>  
   
    <!-- /.box-header -->
    <div class="box-body table-responsive"> 

     

      <table class="table table-hover table-bordered table-dark table-condensed table-striped" id="tablaimp">
        <tbody><tr>
          <th style="border:1px solid #ddd;padding: 5px; width: 5%;">#</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 12%;">FECHA DE INICIO DE ACTIVIDADES</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 17%;">UBICACION PUESTO</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 15%;">NOMBRE PUESTO</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 13%;">RESPONSABLE PUESTO</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 14%;">RAZON SOCIAL</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 8%;">TIPO DE PUESTO</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 8%;">ESTADO DE PUESTO</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 8%;">ESTADO DE SERVICIO</th>
        </tr>
        <tr v-for="registro, key in registros">
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{key+pagination.from}}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{registro.alta | pasfechaVista}}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{registro.zona }} @{{registro.direccion }}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{registro.nombrePuesto }} - N° @{{registro.numeroPuesto}}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{registro.nombresperNat }} @{{registro.apellidosperNat }}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{registro.nombresperJur }}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{registro.tipo }}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">
            <template v-if="registro.activo=='1'">
              ACTIVO
            </template>
            <template v-if="registro.activo=='0'">
              INACTIVO
            </template>
          </td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">
            <template v-if="registro.estadoServicio=='1'">
              SIN CORTE
            </template>
            <template v-if="registro.estadoServicio=='0'">
              CON CORTE
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
              <center>REPORTE DE PUESTOS DE NEGOCIO</center>
            </h3>
        </div>


        <div id="cabecera1" style="width:100%;">
        
          <div style="width:45%; display:inline-block;">
            <h5 style="font-size:11px;" v-if="fechaRegistro!=null && fechaRegistro!=''"><b>Fecha de Inicio de Actividades: @{{fechaRegistro | fecha}}</b></h5>
          </div>

          <div style="width:45%; display:inline-block;">
            <h5 style="font-size:11px;" v-if="nombrePuesto.trim().length>0"><b>Nombre del Puesto: @{{nombrePuesto}}</b></h5>
          </div> 

          <div style="width:45%; display:inline-block;">
            <h5 style="font-size:11px;" v-if="numeroPuesto.trim().length>0"><b>Número del Puesto: @{{numeroPuesto}}</b></h5>
          </div> 
          
          <div style="width:45%; display:inline-block;">
            <h5 style="font-size:11px;" v-if="razonSocial.trim().length>0"><b>Razón Social: @{{razonSocial}}</b></h5>
          </div> 
        
          <div style="width:45%; display:inline-block;"> 
            <h5 style="font-size:11px;" v-if="nombres.trim().length>0"><b>Nombres del Cliente: @{{nombres}}</b></h5>
          </div>  
              
          <div style="width:45%; display:inline-block;">
            <h5 style="font-size:11px;" v-if="apellidos.trim().length>0"><b>Apellidos del Cliente: @{{apellidos}}</b></h5>
          </div>  
        </div>



        <div class="box-body table-responsive" style="width:100%;">
          <table class="table table-hover table-bordered table-dark table-condensed table-striped" >
            <tbody><tr>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 4%;">#</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 12%;">FECHA DE INICIO DE ACTIVIDADES</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 17%;">UBICACION PUESTO</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 15%;">NOMBRE PUESTO</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 13%;">RESPONSABLE PUESTO</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 14%;">RAZON SOCIAL</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 8%;">TIPO DE PUESTO</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 8%;">ESTADO DE PUESTO</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 8%;">ESTADO DE SERVICIO</th>
            </tr>

            <tr v-for="registro, key in registrosimp">


              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{key+1}}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{registro.alta | pasfechaVista}}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{registro.zona }} @{{registro.direccion }}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{registro.nombrePuesto }} - N° @{{registro.numeroPuesto}}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{registro.nombresperNat }} @{{registro.apellidosperNat }}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{registro.nombresperJur }}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{registro.tipo }}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">
                <template v-if="registro.activo=='1'">
                  ACTIVO
                </template>
                <template v-if="registro.activo=='0'">
                  INACTIVO
                </template>
              </td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">
                <template v-if="registro.estadoServicio=='1'">
                  SIN CORTE
                </template>
                <template v-if="registro.estadoServicio=='0'">
                  CON CORTE
                </template>
              </td>
           </tr>
         </tbody></table>
        </div>
      </div>
      </div>
  </div>
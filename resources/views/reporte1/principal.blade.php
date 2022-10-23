<div class="box box-primary panel-group">
    <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
    <h3 class="box-title">Reporte de Usuarios</h3>
      <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
      Volver</a>
    </div>
  
  <div class="box-body" style="border: 1px solid #3c8dbc;">
      <div class="form-group form-primary">
        {{-- <button type="button" class="btn btn-primary" id="btnCrear" @click.prevent="nuevo()"><i class="fa fa-money" aria-hidden="true" ></i> Nuevo Recibo</button> --}}


        <div class="col-md-12" style="padding-top: 10px;">
          <div class="form-group" style="font-size: 12px;">
              <label for="txtfechaRegistro" class="col-sm-2 control-label">Fecha de Registro:</label>
               <div class="col-sm-3">
                    <input type="date" name="txtfechaRegistro" id="txtfechaRegistro" v-model="fechaRegistro" class="form-control input" @change="cambiarfiltro">
              </div>
          </div>
        </div>

        <div class="col-md-12" style="padding-top: 10px;">
          <div class="form-group"style="font-size: 12px;">
            <label for="txtnombres" class="col-sm-2 control-label">Nombres:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control input" id="txtnombres" name="txtnombres" placeholder="Todos" maxlength="250"  v-model="nombres" @change="cambiarfiltro">
            </div>

            <label for="txtapellidos" class="col-sm-1 control-label">Apellidos:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control input" id="txtapellidos" name="txtapellidos" placeholder="Todos" maxlength="250"  v-model="apellidos" @change="cambiarfiltro">
            </div>
          </div>
        </div>  

        <div class="col-md-12" style="padding-top: 10px;">
          <div class="form-group">
            <label for="cbutipo_user_id" class="col-sm-2 control-label">Tipo de Usuario:<spam style="color:red;">*</spam></label>
            <div class="col-sm-4">
              <select class="form-control" id="cbutipo_user_id" name="cbutipo_user_id" v-model="tipo_user_id" @change="cambiarTipoUser">
                <option value="0">Todos</option>
                @foreach ($tipo_users as $dato)
                  <option value="{{$dato->id}}">{{$dato->nombre}}</option> 
                @endforeach
              </select>
            </div>
          </div>
        </div>

          <div class="col-md-12" style="padding-top: 0px;">
              <hr style="border: 1px solid gray;"> 
            </div>


          <div class="col-md-12">
          <button type="button" class="btn btn-primary" id="btnCargarRep" @click.prevent="buscarDatos()"  style="margin-top: 15px;"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Cargar Reporte</button>

          

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
      <h3 class="box-title">Reporte General de Usuarios</h3>

    </div>


    <div class="col-md-12" style="padding-top: 15px;">
      <button type="button" class="btn btn-primary" id="btncrearReporte" @click.prevent="imprimirReporte()"><i class="fa fa-print" aria-hidden="true" ></i> Imprimir Reporte</button>
      <a type="button" class="btn btn-success" id="btnDescargarPlantilla" v-bind:href="'exportarExcel/reporte1?fechaRegistro='+fechaRegistro+'&nombres='+nombres+'&apellidos='+apellidos+'&tipo_user_id='+tipo_user_id" 
      data-placement="top" data-toggle="tooltip" title="Exportar en Excel Según filtros de búsqueda">
      <i class="fa fa-file-excel-o" aria-hidden="true" ></i> Exportar en Excel</a>
    </div>

    <div class="col-md-12" style="padding-top: 0px;">
      <hr style="border: 1px solid gray;"> 
    </div>


    <div class="col-md-12" style="padding-top: 0px;">
      <div class="col-md-6" v-if="fechaRegistro!=null && fechaRegistro!=''">
        <h5><b>Fecha de Registro: @{{fechaRegistro | fecha}}</b></h5>
        {{-- <h5 v-if="fechaRegistro==null || fechaRegistro==''"><b>Fecha de Registro: Siempre</b></h5> --}}
      </div>

      <div class="col-md-6" v-if="nombres.trim().length>0">
        <h5><b>Nombres: @{{nombres}}</b></h5>
      </div> 

      <div class="col-md-6" v-if="apellidos.trim().length>0">
        <h5><b>Apellidos: @{{apellidos}}</b></h5>
      </div>  

      <div class="col-md-12" v-if="tipo_user_id>0">
        <h5><b>Tipo de Usuario: @{{tipoUsuario}} </b></h5>
      </div>    
    
    </div>
   
    <!-- /.box-header -->
    <div class="box-body table-responsive"> 

     

      <table class="table table-hover table-bordered table-dark table-condensed table-striped" id="tablaimp">
        <tbody><tr>
          <th style="border:1px solid #ddd;padding: 5px; width: 4%;">#</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 9%;">FECHA DE REGISTRO</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 9%;">NIVEL DE USUARIO</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 12%;">NOMBRES</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 12%;">APELLIDOS</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 8%;">DNI</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 9%;">CELULAR</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 13%;">CORREO ELECTRONICO</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 12%;">CARGO</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 12%;">OFICINA</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 12%;">PERMISOS</th>
        </tr>
        <tr v-for="registro, key in registros">
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{key+pagination.from}}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">
            <template v-if="registro.created_at != null && registro.created_at.length > 11">
              @{{ registro.created_at.substring(0, 10) | pasfechaVista }} @{{ registro.created_at.substring(11) }}
            </template>
          </td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{ registro.tipouser }}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{ registro.nombresPersona }}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{ registro.apellidosPersona }}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{ registro.num_documentoPersona }}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{ registro.telefonoPersona }}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{ registro.email }}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{ registro.cargoTrabajador }}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{ registro.nombreOficina }}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">
            <template v-if="registro.tipo_user_id == '1'">
              Todos
            </template>
            <template v-if="registro.tipo_user_id == '2'">
              <template v-for ="permisos, key2 in registro.permisosUsuario" >
                @{{ permisos.descripcion }} <br> <br>
              </template>
    
              <template v-if="registro.permisosUsuario.length == 0">
                Ninguno
              </template>
    
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
            <b>Corte Superior de Justicia de Ancash<b>
          </div>
          <div style="width:50px; position: absolute; font-size: 8px; float: right; right: 50px; top:0mm!important;" class="logorep">
            <img src="{{ asset('/img/Poder_Judicial_del_Peru.jpg') }}" class="img img-responsive">
          </div>
            <h3 class="box-title" style="padding-top:10px;font-size: 12px; text-align: center; font-weight: bold; width: 100%;    line-height: 2;"> 
              <center>REPORTE DE USUARIOS</center>
            </h3>
        </div>


        <div id="cabecera1" style="width:100%;">
        
          <div style="width:45%; display:inline-block;" v-if="fechaRegistro!=null && fechaRegistro!=''">
            <h5 style="font-size:11px;"><b>Fecha de Registro: @{{fechaRegistro | fecha}}</b></h5>
          </div>
        
          <div style="width:45%; display:inline-block;" v-if="nombres.trim().length>0"> 
            <h5 style="font-size:11px;"><b>Nombres: @{{nombres}}</b></h5>
          </div>  
              
          <div style="width:45%; display:inline-block;" v-if="apellidos.trim().length>0">
            <h5 style="font-size:11px;"><b>Apellidos: @{{apellidos}}</b></h5>
          </div>  
        
          <div style="width:45%; display:inline-block;" v-if="tipo_user_id>0">
            <h5 style="font-size:11px;"><b>Tipo de Usuario: @{{tipoUsuario}} </b></h5>
          </div>  
                  
        </div>


        <div class="box-body table-responsive" style="width:100%;">
          <table class="table table-hover table-bordered table-dark table-condensed table-striped" >
            <tbody><tr>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 4%;">#</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 9%;">FECHA DE REGISTRO</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 9%;">NIVEL DE USUARIO</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 12%;">NOMBRES</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 12%;">APELLIDOS</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 8%;">DNI</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 9%;">CELULAR</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 13%;">CORREO ELECTRONICO</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 12%;">CARGO</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 12%;">OFICINA</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 12%;">PERMISOS</th>

            </tr>


            <tr v-for="registro, key in registrosimp">
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{key+1}}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">
                <template v-if="registro.created_at != null && registro.created_at.length > 11">
                  @{{ registro.created_at.substring(0, 10) | pasfechaVista }} @{{ registro.created_at.substring(11) }}
                </template>
              </td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ registro.tipouser }}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ registro.nombresPersona }}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ registro.apellidosPersona }}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ registro.num_documentoPersona }}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ registro.telefonoPersona }}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ registro.email }}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ registro.cargoTrabajador }}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ registro.nombreOficina }}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">
                <template v-if="registro.tipo_user_id == '1'">
                  Todos
                </template>
                <template v-if="registro.tipo_user_id == '2'">
                  <template v-for ="permisos, key2 in registro.permisosUsuario" >
                    @{{ permisos.descripcion }} <br> <br>
                  </template>
        
                  <template v-if="registro.permisosUsuario.length == 0">
                    Ninguno
                  </template>
        
                </template>
              </td>
           </tr>
         </tbody></table>
        </div>
      </div>
      </div>
  </div>
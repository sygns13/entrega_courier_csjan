<div class="box box-primary panel-group">
    <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
    <h3 class="box-title">Reporte de Registros de Entrega Courier</h3>
      <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
      Volver</a>
    </div>
  
  <div class="box-body" style="border: 1px solid #3c8dbc;">
      <div class="form-group form-primary">
        {{-- <button type="button" class="btn btn-primary" id="btnCrear" @click.prevent="nuevo()"><i class="fa fa-money" aria-hidden="true" ></i> Nuevo Recibo</button> --}}


        <div class="col-md-12" style="padding-top: 10px;">
          <div class="form-group" style="font-size: 12px;">
              <label for="txtfecha_ingresoIni" class="col-sm-2 control-label">Fecha Inicial de Ingreso:</label>
               <div class="col-sm-4">
                    <input type="date" name="txtfecha_ingresoIni" id="txtfecha_ingresoIni" v-model="fecha_ingresoIni" class="form-control input" @change="cambiarfiltro" placeholder="Todas">
              </div>

              <label for="txtfecha_ingresoFin" class="col-sm-2 control-label">Fecha Final de Ingreso:</label>
               <div class="col-sm-4">
                    <input type="date" name="txtfecha_ingresoFin" id="txtfecha_ingresoFin" v-model="fecha_ingresoFin" class="form-control input" @change="cambiarfiltro" placeholder="Todas">
              </div>
          </div>
        </div>


        <div class="col-md-12" style="padding-top: 10px;">
          <div class="form-group"style="font-size: 12px;">
            <label for="txtcodigo_registro" class="col-sm-2 control-label">Código de Único de Registro:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control input" id="txtcodigo_registro" name="txtcodigo_registro" placeholder="Todos" maxlength="19"  v-model="codigo_registro" @change="cambiarfiltro">
            </div>
          </div>
        </div>  

        <div class="col-md-12" style="padding-top: 10px;">
          <div class="form-group"style="font-size: 12px;">
            {{-- <label for="txtcodigo_registro" class="col-sm-2 control-label">Origen del Sobre:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control input" id="txtcodigo_registro" name="txtcodigo_registro" placeholder="Todos" maxlength="500"  v-model="codigo_registro" @change="cambiarfiltro">
            </div> --}}
            <label for="cbudependencia_id" class="col-sm-2 control-label">Origen del Sobre:</label>
            <div class="col-sm-4">
              <select class="form-control" id="cbudependencia_id" name="cbudependencia_id" v-model="dependencia_id">
                <option disabled value="0">TODAS</option>
                @foreach ($dependencias as $dato)
                  <option value="{{$dato->id}}">{{$dato->nombre}}</option> 
                @endforeach
              </select>
            </div>

            <label for="txtorigen_sobre" class="col-sm-2 control-label">Número de Documento:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control input" id="txtorigen_sobre" name="txtorigen_sobre" placeholder="Todos" maxlength="500"  v-model="origen_sobre" @change="cambiarfiltro">
            </div>
          </div>
        </div> 

        <div class="col-md-12" style="padding-top: 10px;">
          <div class="form-group"style="font-size: 12px;">
            <label for="txtexpediente" class="col-sm-2 control-label">Expediente:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control input" id="txtexpediente" name="txtexpediente" placeholder="Todos" maxlength="500"  v-model="expediente" @change="cambiarfiltro">
            </div>

            <label for="txttelefono_origen" class="col-sm-2 control-label">Teléfono Contacto Origen:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control input" id="txttelefono_origen" name="txttelefono_origen" placeholder="Todos" maxlength="100"  v-model="telefono_origen" @change="cambiarfiltro">
            </div>
          </div>
        </div> 

        
        <div class="col-md-12" style="padding-top: 10px;">
          <div class="form-group"style="font-size: 12px;">
            <label for="cbutipo_envio" class="col-sm-2 control-label">Tipo de Envío:</label>
            <div class="col-sm-4">
              <select class="form-control" id="cbutipo_envio" name="cbutipo_envio" v-model="tipo_envio" @change="cambiarfiltro">
                <option value="">TODOS</option>
                <option value="AGENCIA DE TRANSPORTES">AGENCIA DE TRANSPORTES</option>
                <option value="OLVA COURIER">OLVA COURIER</option>
                <option value="OTRO">OTRO</option>
              </select>
            </div>

            <label for="txtdetalle_envio" class="col-sm-2 control-label">Detalle del Tipo de Envío:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control input" id="txtdetalle_envio" name="txtdetalle_envio" placeholder="Todos" maxlength="500"  v-model="detalle_envio" @change="cambiarfiltro">
            </div>
          </div>
        </div> 

        <div class="col-md-12" style="padding-top: 10px;">
          <div class="form-group"style="font-size: 12px;">
            <label for="txtorden_servicio" class="col-sm-2 control-label">Orden de Servicio:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control input" id="txtorden_servicio" name="txtorden_servicio" placeholder="Todos" maxlength="500"  v-model="orden_servicio" @change="cambiarfiltro">
            </div>
          </div>
        </div>

        <div class="col-md-12" style="padding-top: 10px;">
          <div class="form-group" style="font-size: 12px;">
              <label for="txtfecha_entregaIni" class="col-sm-2 control-label">Fecha Inicial de Entrega:</label>
               <div class="col-sm-4">
                    <input type="date" name="txtfecha_entregaIni" id="txtfecha_entregaIni" v-model="fecha_entregaIni" class="form-control input" @change="cambiarfiltro" placeholder="Todas">
              </div>

              <label for="txtfecha_entregaFin" class="col-sm-2 control-label">Fecha Final de Entrega:</label>
               <div class="col-sm-4">
                    <input type="date" name="txtfecha_entregaFin" id="txtfecha_entregaFin" v-model="fecha_entregaFin" class="form-control input" @change="cambiarfiltro" placeholder="Todas">
              </div>
          </div>
        </div>

        <div class="col-md-12" style="padding-top: 10px;">
          <div class="form-group" style="font-size: 12px;">
              <label for="txtusername1" class="col-sm-2 control-label">Usuario de Registro del Formulario 01:</label>
               <div class="col-sm-4">
                    <input type="date" name="txtusername1" id="txtusername1" v-model="username1" class="form-control input" @change="cambiarfiltro" placeholder="Todas">
              </div>

              <label for="txtusername2" class="col-sm-2 control-label">Usuario de Registro del Formulario 02:</label>
               <div class="col-sm-4">
                    <input type="date" name="txtusername2" id="txtusername2" v-model="username2" class="form-control input" @change="cambiarfiltro" placeholder="Todas">
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
      <h3 class="box-title">Reporte General de Entregas Courier</h3>

    </div>


    <div class="col-md-12" style="padding-top: 15px;">
      <button type="button" class="btn btn-primary" id="btncrearReporte" @click.prevent="imprimirReporte()"><i class="fa fa-print" aria-hidden="true" ></i> Imprimir Reporte</button>
      <a type="button" class="btn btn-success" id="btnDescargarPlantilla" v-bind:href="'exportarExcel/reporte2?fecha_ingresoIni='+fecha_ingresoIni+'&fecha_ingresoFin='+fecha_ingresoFin+'&codigo_registro='+codigo_registro+'&origen_sobre='+origen_sobre+'&expediente='+expediente+'&telefono_origen='+telefono_origen+'&tipo_envio='+tipo_envio+'&detalle_envio='+detalle_envio+'&orden_servicio='+orden_servicio+'&fecha_entregaIni='+fecha_entregaIni+'&fecha_entregaFin='+fecha_entregaFin+'&username1='+username1+'&username2='+username2" 
      data-placement="top" data-toggle="tooltip" title="Exportar en Excel Según filtros de búsqueda">
      <i class="fa fa-file-excel-o" aria-hidden="true" ></i> Exportar en Excel</a>
    </div>

    <div class="col-md-12" style="padding-top: 0px;">
      <hr style="border: 1px solid gray;"> 
    </div>



    <div class="col-md-12" style="padding-top: 0px;">
      <div class="col-md-6" v-if="fecha_ingresoIni!=null && fecha_ingresoIni!=''">
        <h5><b>Fecha Inicial de Ingreso: @{{fecha_ingresoIni | fecha}}</b></h5>
      </div>

      <div class="col-md-6" v-if="fecha_ingresoFin!=null && fecha_ingresoFin!=''">
        <h5><b>Fecha Final de Ingreso: @{{fecha_ingresoFin | fecha}}</b></h5>
      </div>

      <div class="col-md-12" v-if="codigo_registro.trim().length>0">
        <h5><b>Código de Único de Registro: @{{codigo_registro}}</b></h5>
      </div> 

      {{-- <div class="col-md-6" v-if="origen_sobre.trim().length>0">
        <h5 ><b>Origen del Sobre: @{{origen_sobre}}</b></h5>
      </div>   --}}

      <div class="col-md-6" v-if="dependencia_id != 0">
        <h5 ><b>Origen del Sobre: @{{dependencia.nombre}}</b></h5>
      </div>  

      <div class="col-md-6" v-if="expediente.trim().length>0">
        <h5 ><b>Expediente: @{{expediente}}</b></h5>
      </div> 

      <div class="col-md-6" v-if="telefono_origen.trim().length>0">
        <h5 ><b>Teléfono Contacto Origen: @{{telefono_origen}}</b></h5>
      </div>    

      <div class="col-md-6" v-if="tipo_envio.trim().length>0">
        <h5 ><b>Tipo de Envío: @{{tipo_envio}}</b></h5>
      </div>    

      <div class="col-md-6" v-if="detalle_envio.trim().length>0">
        <h5 ><b>Detalle del Tipo de Envío: @{{detalle_envio}}</b></h5>
      </div>    

      <div class="col-md-6" v-if="orden_servicio.trim().length>0">
        <h5 ><b>Orden de Servicio: @{{orden_servicio}}</b></h5>
      </div>    

      <div class="col-md-6" v-if="fecha_entregaIni!=null && fecha_entregaIni!=''">
        <h5><b>Fecha Inicial de Entrega: @{{fecha_entregaIni | fecha}}</b></h5>
      </div>

      <div class="col-md-6" v-if="fecha_entregaFin!=null && fecha_entregaFin!=''">
        <h5><b>Fecha Final de Entrega: @{{fecha_entregaFin | fecha}}</b></h5>
      </div>  

      <div class="col-md-6" v-if="username1.trim().length>0">
        <h5 ><b>Usuario de Registro del Formulario 01: @{{username1}}</b></h5>
      </div> 

      <div class="col-md-6" v-if="username2.trim().length>0">
        <h5 ><b>Usuario de Registro del Formulario 02: @{{username2}}</b></h5>
      </div> 
    </div>  
   
    <!-- /.box-header -->
    <div class="box-body table-responsive"> 

     

      <table class="table table-hover table-bordered table-dark table-condensed table-striped" id="tablaimp">
        <tbody><tr>

          <th style="border:1px solid #ddd;padding: 5px; width: 4%;">#</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 7%;">Código Único de Registro</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 7%;">Cantidad de Sobres</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 8%;">Origen del Sobre - Dependencia</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 6%;">Meta de Dependencia</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 8%;">N° de Documento</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 8%;">N° de Expediente</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 6%;">Teléfono Contacto Origen</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 6%;">Fecha Ingreso Logística</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 8%;">Destino / Dirección</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 8%;">Tipo de Envío</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 6%;">Fecha de Entrega a Destino</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 8%;">N° de Orden de Servicio</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 8%;">Observación</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 8%;">Usuario de Registro del Formulario 01</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 8%;">Usuario de Registro del Formulario 02</th>
        </tr>
        <tr v-for="registro, key in registros">

          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{key+pagination.from}}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{ registro.codigo_registro }}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{ registro.cantidad_sobres }}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">
            <template v-if="registro.dependencia_id > 0">
              @{{ registro.nombreDependencia }}
            </template>
            <template v-else>
              @{{ registro.origen_sobre }}
            </template>
          </td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">
            <template v-if="registro.dependencia_id > 0">
              @{{ registro.metaDependencia }}
            </template>
          </td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{ registro.numero_documento }}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{ registro.expediente }}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{ registro.telefono_origen }}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{ registro.fecha_ingreso | pasfechaVista }}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{ registro.dependencia }} / @{{ registro.direccion }} / @{{ registro.provincia }}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{ registro.tipo_envio }} @{{ registro.detalle_envio }}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{ registro.fecha_entrega | pasfechaVista }}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{ registro.orden_servicio }}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{ registro.observacion }}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{ registro.name1 }}</td>
          <td style="border:1px solid #ddd;font-size: 12px; padding: 5px;">@{{ registro.name2 }}</td>
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
              <center>REPORTE DE CLIENTES</center>
            </h3>
        </div>


        <div id="cabecera1" style="width:100%;">

          <div style="width:45%; display:inline-block;" v-if="fecha_ingresoIni!=null && fecha_ingresoIni!=''">
            <h5 style="font-size:11px;"><b>Fecha Inicial de Ingreso: @{{fecha_ingresoIni | fecha}}</b></h5>
          </div>
    
          <div style="width:45%; display:inline-block;" v-if="fecha_ingresoFin!=null && fecha_ingresoFin!=''">
            <h5 style="font-size:11px;"><b>Fecha Final de Ingreso: @{{fecha_ingresoFin | fecha}}</b></h5>
          </div>
    
          <div style="width:90%; display:inline-block;" v-if="codigo_registro.trim().length>0">
            <h5 style="font-size:11px;"><b>Código de Único de Registro: @{{codigo_registro}}</b></h5>
          </div> 
    
          {{-- <div style="width:45%; display:inline-block;" v-if="origen_sobre.trim().length>0">
            <h5 style="font-size:11px;"><b>Origen del Sobre: @{{origen_sobre}}</b></h5>
          </div>   --}}

          <div style="width:45%; display:inline-block;" v-if="dependencia_id != 0">
            <h5 style="font-size:11px;"><b>Origen del Sobre: @{{dependencia.nombre}}</b></h5>
          </div> 
    
          <div style="width:45%; display:inline-block;" v-if="expediente.trim().length>0">
            <h5 style="font-size:11px;"><b>Expediente: @{{expediente}}</b></h5>
          </div> 
    
          <div style="width:45%; display:inline-block;" v-if="telefono_origen.trim().length>0">
            <h5 style="font-size:11px;"><b>Teléfono Contacto Origen: @{{telefono_origen}}</b></h5>
          </div>    
    
          <div style="width:45%; display:inline-block;" v-if="tipo_envio.trim().length>0">
            <h5 style="font-size:11px;"><b>Tipo de Envío: @{{tipo_envio}}</b></h5>
          </div>    
    
          <div style="width:45%; display:inline-block;" v-if="detalle_envio.trim().length>0">
            <h5 style="font-size:11px;"><b>Detalle del Tipo de Envío: @{{detalle_envio}}</b></h5>
          </div>    
    
          <div style="width:45%; display:inline-block;"v-if="orden_servicio.trim().length>0">
            <h5 style="font-size:11px;" ><b>Orden de Servicio: @{{orden_servicio}}</b></h5>
          </div>    
    
          <div style="width:45%; display:inline-block;" v-if="fecha_entregaIni!=null && fecha_entregaIni!=''">
            <h5 style="font-size:11px;"><b>Fecha Inicial de Entrega: @{{fecha_entregaIni | fecha}}</b></h5>
          </div>
    
          <div style="width:45%; display:inline-block;" v-if="fecha_entregaFin!=null && fecha_entregaFin!=''">
            <h5 style="font-size:11px;"><b>Fecha Final de Entrega: @{{fecha_entregaFin | fecha}}</b></h5>
          </div>  
    
          <div style="width:45%; display:inline-block;" v-if="username1.trim().length>0">
            <h5 style="font-size:11px;"><b>Usuario de Registro del Formulario 01: @{{username1}}</b></h5>
          </div> 
    
          <div style="width:45%; display:inline-block;" v-if="username2.trim().length>0">
            <h5 style="font-size:11px;"><b>Usuario de Registro del Formulario 02: @{{username2}}</b></h5>
          </div> 
        </div>

        <div class="box-body table-responsive" style="width:100%;">
          <table class="table table-hover table-bordered table-dark table-condensed table-striped" >
            <tbody><tr>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 4%;">#</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 7%;">Código Único de Registro</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 7%;">Cantidad de Sobres</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 8%;">Origen del Sobre - Dependencia</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 6%;">Meta de Dependencia</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 8%;">N° de Documento</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 8%;">N° de Expediente</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 6%;">Teléfono Contacto Origen</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 6%;">Fecha Ingreso Logística</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 8%;">Destino / Dirección</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 8%;">Tipo de Envío</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 6%;">Fecha de Entrega a Destino</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 8%;">N° de Orden de Servicio</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 8%;">Observación</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 8%;">Usuario de Registro del Formulario 01</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 8%;">Usuario de Registro del Formulario 02</th>

            </tr>

            <tr v-for="registro, key in registrosimp">
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{key+1}}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ registro.codigo_registro }}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ registro.cantidad_sobres }}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">
                <template v-if="registro.dependencia_id > 0">
                  @{{ registro.nombreDependencia }}
                </template>
                <template v-else>
                  @{{ registro.origen_sobre }}
                </template>
              </td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">
                <template v-if="registro.dependencia_id > 0">
                  @{{ registro.metaDependencia }}
                </template>
              </td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ registro.numero_documento }}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ registro.expediente }}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ registro.telefono_origen }}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ registro.fecha_ingreso | pasfechaVista }}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ registro.dependencia }} / @{{ registro.direccion }} / @{{ registro.provincia }}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ registro.tipo_envio }} @{{ registro.detalle_envio }}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ registro.fecha_entrega | pasfechaVista }}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ registro.orden_servicio }}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ registro.observacion }}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ registro.name1 }}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ registro.name2 }}</td>
           </tr>
         </tbody></table>
        </div>
      </div>
      </div>
  </div>
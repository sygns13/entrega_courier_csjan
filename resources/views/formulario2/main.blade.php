<div class="panel panel-primary" v-if="mostrarPalenIni">
  <div class="panel-heading" style="padding-bottom: 15px;">
    <h3 class="panel-title">Registro del Formulario 2 Entrega Courier  <a style="float: right; padding: all; color: black;" type="button" class="btn btn-default btn-sm" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
    Volver</a></h3>
    
  </div>

  <div class="panel-body">

    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="txtcodigo_registro" class="col-sm-2 control-label">Código Único de Registro:</label>
        <div class="col-sm-2">
          <input type="text" class="form-control" id="txtcodigo_registro" name="txtcodigo_registro" placeholder="CUR_2022_0000000001"
            maxlength="19" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="codigo_registro">
        </div>
        <div class="col-sm-8">
          <button type="button" class="btn btn-primary btn-sm" id="btncrear" style="font-size: 14px;" @click.prevent="buscarCUR()"><i class="fa fa-plus-circle" aria-hidden="true" ></i> Buscar por CUR</button>
        </div>
      </div>
    </div>
    {{-- <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        
      </div>
    </div> --}}
  </div>
</div>



{{-- <div class="box box-success" v-if="divNuevo">
  <div class="box-header with-border" style="border: 1px solid rgb(0, 166, 90); background-color: rgb(0, 166, 90); color: white;">
    <h3 class="box-title" id="tituloAgregar">Nuevo Registro
    </h3>
  </div>
  @include('formulario2.formulario')  
</div> --}}


<div class="box box-primary" v-if="divEdit">
  <div class="box-header with-border" style="border: 1px solid #1a2bc2; background-color: #1b28e4; color: white;">
    <h3 class="box-title" id="tituloAgregar">Completar Registro: @{{ fillobject.codigo_registro }}
    </h3>
  </div>
   @include('formulario2.editar')
</div>

<div class="panel panel-primary" >
  <div class="panel-heading" style="padding-bottom: 20px;">
    <h3 class="panel-title">Listado de Registros de Entrega Courier

      <div class="box-tools" style="float: right;">
        <div class="input-group input-group-sm" style="max-width: 300px;">
          <input type="text" name="table_search" class="form-control pull-right" placeholder="Buscar" v-model="buscar" @keyup.enter="buscarBtn()">
  
          <div class="input-group-btn">
            <button type="submit" class="btn btn-default" @click.prevent="buscarBtn()"><i class="fa fa-search"></i></button>
          </div>
  
  
        </div>
      </div>
    </h3>

    
    
  </div>

  <!-- /.box-header -->
  <div class="box-body table-responsive">
    <table class="table table-hover table-bordered" >
      <tbody><tr>
        <th style=";border:1px solid #ddd; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; padding: 5px; width: 4%;">#</th>
        <th style=";border:1px solid #ddd; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; padding: 5px; width: 7%;">Código Único de Registro</th>
        <th style=";border:1px solid #ddd; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; padding: 5px; width: 7%;">Cantidad de Sobres</th>
        <th style=";border:1px solid #ddd; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; padding: 5px; width: 8%;">Origen del Sobre - Dependencia</th>
        <th style=";border:1px solid #ddd; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; padding: 5px; width: 6%;">Meta de Dependencia</th>
        <th style=";border:1px solid #ddd; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; padding: 5px; width: 8%;">N° de Documento</th>
        <th style=";border:1px solid #ddd; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; padding: 5px; width: 8%;">N° de Expediente</th>
        <th style=";border:1px solid #ddd; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; padding: 5px; width: 6%;">Teléfono Contacto Origen</th>
        <th style=";border:1px solid #ddd; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; padding: 5px; width: 6%;">Fecha Ingreso Logística</th>
        <th style=";border:1px solid #ddd; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; padding: 5px; width: 8%;">Destino / Dirección</th>
        <th style=";border:1px solid #ddd; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; padding: 5px; width: 8%;">Tipo de Envío</th>
        <th style=";border:1px solid #ddd; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; padding: 5px; width: 6%;">Fecha de Entrega a Destino</th>
        <th style=";border:1px solid #ddd; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; padding: 5px; width: 8%;">N° de Orden de Servicio</th>
        <th style=";border:1px solid #ddd; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; padding: 5px; width: 8%;">Observación</th>
        <th style=";border:1px solid #ddd; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; padding: 5px; width: 8%;">Gestión</th>
      </tr>
      <tr v-for="registro, key in registros">
        <td style=";border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px;">@{{key+pagination.from}}</td>
        <td style=";border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px;">@{{ registro.codigo_registro }}</td>
        <td style=";border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px;">@{{ registro.cantidad_sobres }}</td>
        <td style=";border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px;">
          <template v-if="registro.dependencia_id > 0">
            @{{ registro.nombreDependencia }}
          </template>
          <template v-else>
            @{{ registro.origen_sobre }}
          </template>
        </td>
        <td style=";border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px;">
          <template v-if="registro.dependencia_id > 0">
            @{{ registro.metaDependencia }}
          </template>
        </td>
        <td style=";border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px;">@{{ registro.numero_documento }}</td>
        <td style=";border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px;">@{{ registro.expediente }}</td>
        <td style=";border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px;">@{{ registro.telefono_origen }}</td>
        <td style=";border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px;">@{{ registro.fecha_ingreso | pasfechaVista }}</td>
        <td style=";border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px;">@{{ registro.dependencia }} / @{{ registro.direccion }} / @{{ registro.provincia }}</td>
        <td style=";border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px;">@{{ registro.tipo_envio }} @{{ registro.detalle_envio }}</td>
        <td style=";border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px;">@{{ registro.fecha_entrega | pasfechaVista }}</td>
        <td style=";border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px;">@{{ registro.orden_servicio }}</td>
        <td style=";border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px;">@{{ registro.observacion }}</td>
        <td style=";border:1px solid #ddd; font-size: 11px; padding: 5px;">

        <center>

        <a href="#" class="btn btn-primary btn-sm" v-on:click.prevent="edit(registro)" data-placement="top" data-toggle="tooltip" title="Registrar"><i class="fa fa-edit"></i> Registrar</a>

      </center>
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

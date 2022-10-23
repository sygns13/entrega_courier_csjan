<div class="panel panel-primary" v-if="mostrarPalenIni">
  <div class="panel-heading" style="padding-bottom: 15px;">
    <h3 class="panel-title">Programación de Rutas  <a style="float: right; padding: all; color: black;" type="button" class="btn btn-default btn-sm" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
    Volver</a></h3>
    
  </div>

  <div class="panel-body">
    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">

        @if($contProcesoLectura == 0)
          <h4 style="font-weight: bold; color: red;"><center>No hay Proceso de Lecturas Iniciado o Aprobado en Proceso, por lo que no se puede realizar programación de rutas </center></h4>
        @endif

        @if($contProcesoLectura > 0)
            <h4 style="font-weight: bold;"><center>Programación de Rutas del Proceso de Lectura del año: {{ $procesoLectura->anio }} y del mes: {{ $procesoLectura->mesNombre }}</center></h4>
        @endif

      </div>
    </div>
  </div>
</div>



{{-- <div class="box box-success" v-if="divNuevo">
  <div class="box-header with-border" style="border: 1px solid rgb(0, 166, 90); background-color: rgb(0, 166, 90); color: white;">
    <h3 class="box-title" id="tituloAgregar">Nueva Zona
    </h3>
  </div>
  @include('zona.formulario')  
</div>


<div class="box box-warning" v-if="divEdit">
  <div class="box-header with-border" style="border: 1px solid #f39c12; background-color: #f39c12; color: white;">
    <h3 class="box-title" id="tituloAgregar">Editar Zona: @{{ fillobject.nombre }}


    </h3>
  </div>

  @include('zona.editar')  

</div> --}}


@if($contProcesoLectura > 0)
  <div class="panel panel-primary" >
    <div class="panel-heading" style="padding-bottom: 20px;">
      <h3 class="panel-title">Listado de Puestos y Medidores Programables

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
          <th style=";border:1px solid #ddd; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px; width: 4%;">#</th>
          <th style=";border:1px solid #ddd; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px; width: 12%;">Zona</th>
          <th style=";border:1px solid #ddd; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px; width: 14%;">Puesto</th>
          <th style=";border:1px solid #ddd; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px; width: 14%;">Dirección</th>
          <th style=";border:1px solid #ddd; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px; width: 10%;">Serie Medidor</th>
          <th style=";border:1px solid #ddd; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px; width: 9%;">Estado</th>
          <th style=";border:1px solid #ddd; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px; width: 10%;">Fecha Programado</th>
          <th style=";border:1px solid #ddd; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px; width: 14%;">Lecturista Programado</th>
          <th style=";border:1px solid #ddd; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px; width: 13%;">Gestión</th>
        </tr>
        <tr v-for="registro, key in registros">
          <td style=";border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 11px; padding: 5px;">@{{key+pagination.from}}</td>
          <td style=";border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 11px; padding: 5px;">@{{ registro.nombreZona }}</td>
          <td style=";border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 11px; padding: 5px;">@{{ registro.puesto }} - N° @{{ registro.numeroPuesto }}</td>
          <td style=";border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 11px; padding: 5px;">@{{ registro.dirPuesto }}</td>
          <td style=";border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 11px; padding: 5px;">@{{ registro.serie }}</td>
          <td style=";border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 11px; padding: 5px; text-align: center;">
            <span style="font-size:100%;" class="label label-danger" v-if="registro.estadoLectura_medidors=='0'">No Programado</span>
            <span style="font-size:100%;" class="label label-primary" v-if="registro.estadoLectura_medidors=='1'">Programado</span>
            <span style="font-size:100%;" class="label label-success" v-if="registro.estadoLectura_medidors=='2'">Lectura Realizada</span> 
            <span style="font-size:100%;" class="label label-warning" v-if="registro.estadoLectura_medidors=='3'">Lectura No Realizada</span> 
        </td>
        <td style=";border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 11px; padding: 5px;">
          <template v-if="registro.estadoLectura_medidors!='0'">
            @{{ registro.fecha_programacionLectura_medidors.substring(0, 10) | pasfechaVista }} @{{ registro.fecha_programacionLectura_medidors.substring(11) }}
          </template>
        </td>
        <td style=";border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 11px; padding: 5px;">
          @{{ registro.nombresPersonas }} @{{ registro.apellidosPersonas }}
        </td>
        <td style=";border:1px solid #ddd; font-size: 11px; padding: 5px;">

          <center>

            <a href="#" v-if="registro.estadoLectura_medidors=='0'" class="btn btn-primary btn-sm" v-on:click.prevent="programar(registro)" data-placement="top" data-toggle="tooltip" title="Programar Lecturista"><i class="fa fa-cogs"></i> Programar</a>

            <a href="#" v-if="registro.estadoLectura_medidors=='1'" class="btn btn-warning btn-sm" v-on:click.prevent="editar(registro)" data-placement="top" data-toggle="tooltip" title="Editar Programación de Lecturista"><i class="fa fa-edit"></i> Editar</a>

            <a href="#" v-if="registro.estadoLectura_medidors=='1'" class="btn btn-danger btn-sm" v-on:click.prevent="borrar(registro)" data-placement="top" data-toggle="tooltip" title="Eliminar Programación de Lecturista"><i class="fa fa-trash"></i> Eliminar</a>



       {{--    <a href="#" v-if="registro.estadoLectura_medidors=='0'" class="btn bg-navy btn-sm" v-on:click.prevent="baja(registro)" data-placement="top" data-toggle="tooltip" title="Dar de baja registro"><i class="fa fa-arrow-circle-down"></i></a>

          <a href="#" v-if="registro.estadoLectura_medidors=='1'" class="btn btn-success btn-sm" v-on:click.prevent="alta(registro)" data-placement="top" data-toggle="tooltip" title="Dar de alta registro"><i class="fa fa-check-circle"></i></a>


          <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="edit(registro)" data-placement="top" data-toggle="tooltip" title="Editar registro"><i class="fa fa-edit"></i></a>
          <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrar(registro)" data-placement="top" data-toggle="tooltip" title="Borrar registro"><i class="fa fa-trash"></i></a> --}}

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
@endif



<form method="post" v-on:submit.prevent="procesarProgramacion(fillobject)">
  <div class="modal bs-example-modal-lg" id="modalProgramacion" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document" id="modaltamanioProgramacion">
      <div class="modal-content" style="border: 1px solid #3c8dbc;">
        <div class="modal-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="font-size: 35px;">&times;</span></button>
          <h4 class="modal-title" id="desProgramacionTitulo" style="font-weight: bold;text-decoration: underline;">@{{Programacion}} PROGRAMACION DE LECTURA</h4>

        </div> 
        <div class="modal-body">
          <input type="hidden" id="idServicio" value="0">

          <div class="row">

            <div class="box" id="o" style="border:0px; box-shadow:none;" >
              <div class="box-header with-border">
                <h3 class="box-title" id="boxTituloProgramacion">Puesto: @{{ fillobject.puesto }} - N°: @{{ fillobject.numeroPuesto }}</h3><br>
                <h3 class="box-title" id="boxTituloProgramacion" style="padding-top: 10px;">Medidor de Serie: @{{ fillobject.serie }}</h3><br>
              </div>
              <!-- /.box-header -->
              <!-- form start -->

              <div class="box-body">

                <div class="col-md-12" style="padding-top: 15px;">
                  <div class="form-group">
                    <label for="cbuidUser" class="col-sm-2 control-label">Operador:<spam style="color:red;">*</spam></label>
                    <div class="col-sm-10">
                      <select class="form-control" id="cbuidUser" name="cbuidUser" v-model="fillobject.idUsers">
                        <option disabled value="0">Seleccione un Operador</option>
                        @foreach ($operadores as $dato)
                          <option value="{{$dato->idUsers}}">{{$dato->nombresPersonas}} {{$dato->apellidosPersonas}}</option> 
                        @endforeach
                      </select>
                    </div>
          
                  </div>
                </div>
            
              </div>


            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="btnSaveProgramacion"><i class="fa fa-floppy-o" aria-hidden="true"></i> @{{procesar}}</button>

            <button type="button" id="btnCancelProgramacion" class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>

            <div class="sk-circle" v-show="divloaderProgramacion">
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

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</form>
<div class="panel panel-primary" v-if="mostrarPalenIni">
  <div class="panel-heading" style="padding-bottom: 15px;">
    <h3 class="panel-title">Gestión de Procesos de Lecturas  <a style="float: right; padding: all; color: black;" type="button" class="btn btn-default btn-sm" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
    Volver</a></h3>
    
  </div>

  <div class="panel-body">
    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <template v-if='contProcesoLectura == 0' >
          <button type="button" class="btn btn-primary btn-sm" id="btncrear" style="font-size: 14px; margin-top:15px;" @click.prevent="nuevo()"><i class="fa fa-plus-circle" aria-hidden="true" ></i> Iniciar Nuevo Proceso de Lectura</button>
        </template>

        <template v-if='contProcesoLectura > 0' >
          <template v-if='fillobject.estado == 1' >
            @if(accesoUser([1,2]))
            <button type="button" class="btn btn-danger btn-sm" id="btnAnular" style="font-size: 14px; margin-top:15px;" @click.prevent="anular(fillobject)"><i class="fa fa-trash" aria-hidden="true" ></i> Anular Proceso de Lectura</button>
            <button type="button" class="btn btn-success btn-sm" id="btnAprobar" style="font-size: 14px; margin-top:15px;" @click.prevent="aprobar(fillobject)"><i class="fa fa-check-square-o" aria-hidden="true" ></i> Aprobar Proceso de Lectura</button>
            @endif
            <button type="button" class="btn btn-warning btn-sm" id="btnEditar" style="font-size: 14px; margin-top:15px;" @click.prevent="editar(fillobject)"><i class="fa fa-edit" aria-hidden="true" ></i> Editar Proceso de Lectura</button>

            <a href="{{URL::to('programar_rutas')}}" class="btn btn-primary btn-sm" id="btnRutas" style="font-size: 14px; margin-top:15px;"><i class="fa fa-map" aria-hidden="true" ></i> Realizar Programación de Rutas</a>
          </template>

          <template v-if='fillobject.estado == 2' >
            @if(accesoUser([1,2]))
            <button type="button" class="btn btn-danger btn-sm" id="btnAnular" style="font-size: 14px; margin-top:15px;" @click.prevent="anular(fillobject)"><i class="fa fa-trash" aria-hidden="true" ></i> Anular Proceso de Lectura</button>
            <button type="button" class="btn btn-success btn-sm" id="btnFinalizar" style="font-size: 14px; margin-top:15px;" @click.prevent="finalizar(fillobject)"><i class="fa fa-save" aria-hidden="true" ></i> Finalizar Proceso de Lectura</button>
            @endif
            <a href="{{URL::to('programar_rutas')}}" class="btn btn-primary btn-sm" id="btnRutas" style="font-size: 14px; margin-top:15px;"><i class="fa fa-map" aria-hidden="true" ></i> Realizar Programación de Rutas</a>
          </template>
        </template>
      </div>
    </div>
  </div>
</div>



<div class="box box-success" v-if="divNuevo">
  <div class="box-header with-border" style="border: 1px solid rgb(0, 166, 90); background-color: rgb(0, 166, 90); color: white;">
    <h3 class="box-title" id="tituloAgregar">Nuevo Proceso de Lectura
    </h3>
  </div>
  @include('procesolectura.formulario')  
</div>


<div class="box box-warning" v-if="divEdit">
  <div class="box-header with-border" style="border: 1px solid #f39c12; background-color: #f39c12; color: white;">
    <h3 class="box-title" id="tituloAgregar">Editar Proceso de Lectura del año: @{{ fillobject.anio }} y del mes: @{{ fillobject.mesNombre }}


    </h3>
  </div>

  @include('procesolectura.editar')  

</div>

<template v-if='contProcesoLectura != 0' >
<div class="panel panel-primary" >
  <div class="panel-heading" style="padding-bottom: 20px;">
    <h3 class="panel-title">Proceso de Lectura </h3>
  </div>

  <div class="panel-body">

    <div class="col-md-12" style="padding-top: 15px;">
      <h4 style="font-weight: bold;"><center>Proceso de Lectura del año: @{{ fillobject.anio }} y del mes: @{{ fillobject.mesNombre }}</center></h4>
    </div>

    <div class="col-md-12" style="padding-top: 10px;">
      <div class="col-md-3"><h4>Estado del Proceso:</h4></div>
      <div class="col-md-9">
        <h4>
          <template v-if="fillobject.estado == '0'">
            Proceso de Lectura Finalizado
          </template>
          <template v-if="fillobject.estado == '1'">
            Proceso de Lectura Iniciado
          </template>
          <template v-if="fillobject.estado == '2'">
            Proceso de Lectura Aprobado en Proceso
          </template>
          <template v-if="fillobject.estado == '3'">
            Proceso de Lectura Finalizado
          </template>
        </h4>
      </div>
    </div>

    <div class="col-md-12" style="padding-top: 10px;">
      <div class="col-md-3"><h4>Orden de Trabajo:</h4></div>
      <div class="col-md-9">
        <h4>@{{ fillobject.orden_trabajo }}</h4>
      </div>
    </div>


    <div class="col-md-12" style="padding-top: 10px;">
      <div class="col-md-3"><h4>Fecha de Inicio del Proceso de Lectura:</h4></div>
      <div class="col-md-9">
        <h4>@{{ fillobject.fecha_generado.substring(0, 10) | pasfechaVista }}</h4>
      </div>
    </div>

    <div class="col-md-12" style="padding-top: 10px;">
      <div class="col-md-3"><h4>Hora de Inicio del Proceso de Lectura:</h4></div>
      <div class="col-md-9">
        <h4>@{{ fillobject.fecha_generado.substring(11) }}</h4>
      </div>
    </div>

    <template v-if="fillobject.estado == '2' || fillobject.estado == '3'">
      <div class="col-md-12" style="padding-top: 10px;">
        <div class="col-md-3"><h4>Fecha de Aprobación del Proceso de Lectura:</h4></div>
        <div class="col-md-9">
          <h4>@{{ fillobject.fecha_aprobado.substring(0, 10) | pasfechaVista }}</h4>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 10px;">
        <div class="col-md-3"><h4>Hora de Aprobación del Proceso de Lectura:</h4></div>
        <div class="col-md-9">
          <h4>@{{ fillobject.fecha_aprobado.substring(11) }}</h4>
        </div>
      </div>
    </template>

    <template v-if="fillobject.estado == '3'">
      <div class="col-md-12" style="padding-top: 10px;">
        <div class="col-md-3"><h4>Fecha de Finalización del Proceso de Lectura:</h4></div>
        <div class="col-md-9">
          <h4>@{{ fillobject.fecha_finalizado.substring(0, 10) | pasfechaVista }}</h4>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 10px;">
        <div class="col-md-3"><h4>Hora de Finalización del Proceso de Lectura:</h4></div>
        <div class="col-md-9">
          <h4>@{{ fillobject.fecha_finalizado.substring(11) }}</h4>
        </div>
      </div>
    </template>


    <div class="col-md-12" style="padding-top: 10px;">
      <div class="col-md-3"><h4>Observaciones del Inicio del Proceso:</h4></div>
      <div class="col-md-9">
        <h4>@{{ fillobject.observaciones_generacion }}</h4>
      </div>
    </div>

    <template v-if="fillobject.estado == '2' || fillobject.estado == '3'">
      <div class="col-md-12" style="padding-top: 10px;">
        <div class="col-md-3"><h4>Observaciones de la Aprobación del Proceso:</h4></div>
        <div class="col-md-9">
          <h4>@{{ fillobject.observaciones_aprobacion }}</h4>
        </div>
      </div>
    </template>

    <template v-if="fillobject.estado == '3'">
      <div class="col-md-12" style="padding-top: 10px;">
        <div class="col-md-3"><h4>Observaciones de la Finalización del Proceso:</h4></div>
        <div class="col-md-9">
          <h4>@{{ fillobject.observaciones_finalizacion }}</h4>
        </div>
      </div>
    </template>

  </div>

</div>
</template>





<form method="post" v-on:submit.prevent="procesarProceso(fillobject)">
  <div class="modal bs-example-modal-lg" id="modalProceso" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document" id="modaltamanioProceso">
      <div class="modal-content" style="border: 1px solid #3c8dbc;">
        <div class="modal-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="font-size: 35px;">&times;</span></button>
          <h4 class="modal-title" id="desProcesoTitulo" style="font-weight: bold;text-decoration: underline;">@{{proceso}} PROCESO DE LECTURA</h4>

        </div> 
        <div class="modal-body">
          <input type="hidden" id="idServicio" value="0">

          <div class="row">

            <div class="box" id="o" style="border:0px; box-shadow:none;" >
              <div class="box-header with-border">
                <h3 class="box-title" id="boxTituloProceso">Proceso de Lectura del año: @{{ fillobject.anio }} y del mes: @{{ fillobject.mesNombre }}</h3><br>
              </div>
              <!-- /.box-header -->
              <!-- form start -->

              <div class="box-body">

                <div class="col-md-12" style="padding-top: 15px;">
                  <div class="form-group">
                    <label for="txtobservacion" class="col-sm-2 control-label">Observaciones de la @{{procesamiento}}:</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" rows="4" placeholder="Ingrese Observaciones" id="txtobservacion" v-model="observacion"></textarea>
                    </div>
                  </div>
                </div>
              </div>


            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="btnSaveProceso"><i class="fa fa-floppy-o" aria-hidden="true"></i> @{{procesar}}</button>

            <button type="button" id="btnCancelProceso" class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>

            <div class="sk-circle" v-show="divloaderProceso">
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
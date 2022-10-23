<div class="panel panel-primary" v-if="mostrarPalenIni">
  <div class="panel-heading" style="padding-bottom: 15px;">
    <h3 class="panel-title">Gestión de Usuarios del Sistema <a style="float: right; padding: all; color: black;" type="button" class="btn btn-default btn-sm" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
    Volver</a></h3>
    
  </div>

  <div class="panel-body">
    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <button type="button" class="btn btn-primary btn-sm" id="btncrearusuario" style="font-size: 14px;" @click.prevent="nuevoUsuario()"><i class="fa fa-plus-circle" aria-hidden="true" ></i> Nuevo Usuario</button>
      </div>
    </div>
  </div>
</div>



<div class="box box-success" v-if="divNuevoUsuario">
  <div class="box-header with-border" style="border: 1px solid rgb(0, 166, 90); background-color: rgb(0, 166, 90); color: white;">
    <h3 class="box-title" id="tituloAgregar">Nuevo Usuario
    </h3>
  </div>
  @include('usuario.formulario')  
</div>


<div class="box box-warning" v-if="divEditUsuario">
  <div class="box-header with-border" style="border: 1px solid #f39c12; background-color: #f39c12; color: white;">
    <h3 class="box-title" id="tituloAgregar">Editar Usuario: @{{ filluser.name }} - @{{ filluser.apellidosPersona }} @{{ filluser.nombresPersona }} - @{{ filluser.cargoTrabajador }}


    </h3>
  </div>

  @include('usuario.editar')  

</div>

<div class="box box-info" >
  <div class="box-header">
    <h3 class="box-title">Listado de Usuarios del Sistema
    </h3>

    <div class="box-tools">
      <div class="input-group input-group-sm" style="max-width: 300px;">
        <input type="text" name="table_search" class="form-control pull-right" placeholder="Buscar" v-model="buscar" @keyup.enter="buscarBtn()">

        <div class="input-group-btn">
          <button type="submit" class="btn btn-default" @click.prevent="buscarBtn()"><i class="fa fa-search"></i></button>
        </div>


      </div>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body table-responsive">
    <table class="table table-hover table-bordered" >
      <tbody><tr>
        <th style="border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; padding: 5px; width: 3%;">#</th>
        <th style="border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; padding: 5px; width: 8%;">Tipo de Usuario</th>
        <th style="border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; padding: 5px; width: 8%;">Documento de Identidad</th>
        <th style="border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; padding: 5px; width: 12%;">Apellidos y Nombres</th>
        <th style="border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; padding: 5px; width: 8%;">Username</th> 
        <th style="border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; padding: 5px; width: 9%;">Oficina</th> 
        <th style="border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; padding: 5px; width: 8%;">Cargo</th> 
        <th style="border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; padding: 5px; width: 14%;">Email</th> 
        <th style="border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; padding: 5px; width: 6%;">Estado</th>
        <th style="border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; padding: 5px; width: 11%;">Permisos</th>
        <th style="border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; padding: 5px; width: 13%;">Gestión</th>
      </tr>
      <tr v-for="usuario, key in usuarios">
        <td style="border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px;">@{{key+pagination.from}}</td>
        <td style="border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px;">@{{ usuario.tipouser }}</td>
        <td style="border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px;">@{{ usuario.tipo_documentoPersona }}: @{{usuario.num_documentoPersona}}</td>
        <td style="border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px;">@{{ usuario.nombresPersona }} @{{usuario.apellidosPersona}}</td>
        <td style="border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px;">@{{ usuario.name }}</td>
        <td style="border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px;">@{{ usuario.nombreOficina }}</td>
        <td style="border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px;">@{{ usuario.cargoTrabajador }}</td>
        <td style="border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px;">@{{ usuario.email }}</td>
        <td style="border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px; text-align: center;">
         <span class="label label-success" v-if="usuario.activo=='1'">Activo</span>
         <span class="label label-warning" v-if="usuario.activo=='0'">Inactivo</span>
       </td>
       <td style="border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px;">
        <template v-if="usuario.tipo_user_id == '1'">
          Todos
        </template>
        <template v-if="usuario.tipo_user_id == '2'">
          <template v-for ="permisos, key2 in usuario.permisosUsuario" >
            @{{ permisos.descripcion }} <br> <br>
          </template>

          <template v-if="usuario.permisosUsuario.length == 0">
            Ninguno
          </template>

        </template>

       </td>
       <td style="border:1px solid #ddd;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; padding: 5px;">

        {{-- <a href="#" class="btn btn-info btn-sm" v-on:click.prevent="impFicha(usuario)" data-placement="top" data-toggle="tooltip" title="Imprimir Ficha de Usuario"><i class="fa fa-print"></i></a>
 --}}

      <template v-if="usuario.id > 1">
        <a href="#" v-if="usuario.activo=='1'" class="btn bg-navy btn-sm" v-on:click.prevent="bajaUsuario(usuario)" data-placement="top" data-toggle="tooltip" title="Desactivar Usuario"><i class="fa fa-arrow-circle-down"></i></a>
        <a href="#" v-if="usuario.activo=='0'" class="btn btn-success btn-sm" v-on:click.prevent="altaUsuario(usuario)" data-placement="top" data-toggle="tooltip" title="Activar Usuario"><i class="fa fa-check-circle"></i></a>
      </template>

        <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="editUsuario(usuario)" data-placement="top" data-toggle="tooltip" title="Editar usuario"><i class="fa fa-edit"></i></a>

        <template v-if="usuario.id > 1">
          <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrarUsuario(usuario)" data-placement="top" data-toggle="tooltip" title="Borrar usuario"><i class="fa fa-trash"></i></a>
        </template>
      </td>
    </tr>

  </tbody></table>

</div>
<!-- /.box-body -->
<div style="padding: 15px;">
 <div><h5>usuarios por Página: @{{ pagination.per_page }}</h5></div>
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
<div><h5>usuarios Totales: @{{ pagination.total }}</h5></div>
</div>
</div>



<form  v-on:submit.prevent="Imprimir()">
  <div class="modal fade bs-example-modal-lg" id="modalFicha" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document"  id="modaltamanio1">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="desEditarTitulo" style="font-weight: bold;text-decoration: underline;">IMPRIMIR FICHA DE USUARIO</h4>

        </div> 
        <div class="modal-body">


          <div class="row">

            <div class="box" id="o" style="border:0px; box-shadow:none;" >
              <div class="box-header with-border">
                <h3 class="box-title" id="boxTituloAgre"></h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <div id="FichaUsuario"> 
               @include('usuario.ficha')   

             </div>
           </div>



         </div>
         <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="btnImprimir"><i class="fa fa-print" aria-hidden="true"></i> Imprimir Ficha</button>

          <button type="button" id="btnCancelFoto" class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>



        </div>
      </div>
    </div>
  </div>
</div>
</form>

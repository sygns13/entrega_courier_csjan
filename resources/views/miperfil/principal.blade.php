<div class="box box-primary panel-group">
        <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
          <h3 class="box-title">Configuración</h3>
          <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
        </div>
      
      <div class="box-body" style="border: 1px solid #3c8dbc;">
          <div class="form-group form-primary">
            <button type="button" class="btn btn-info" id="btnCrear" @click.prevent="modifclave()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Modificar Password</button>
          </div>
          
          <h5><b>Nota:</b> En este módulo solo puede modificar su contraseña, en caso requiera modificar más datos, solicítelo al administrador del sistema.</h5>
          </div>
      

          
        </div>
        
     
        <div class="box box-primary" >
          <div class="box-header with-border" style="border: 1px solid #3c8dbc;; background-color: #3c8dbc;; color: white;">
            <h3 class="box-title" id="tituloAgregar">Mis Datos
        
        
            </h3>
          </div>
        
          @include('miperfil.perfil')  
        
        </div>     
   
      
      
       
        <form method="post" v-on:submit.prevent="updatepsw()">
          <div class="modal bs-example-modal-lg" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-lg" role="document" id="modaltamanio">
              <div class="modal-content" style="border: 1px solid #3c8dbc;">
                <div class="modal-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="font-size: 35px;">&times;</span></button>
                  <h4 class="modal-title" id="desEditarTitulo" style="font-weight: bold;text-decoration: underline;">MODIFICAR PASSWORD</h4>
        
                </div> 
                <div class="modal-body">
                  <input type="hidden" id="idServicio" value="0">
        
                  <div class="row">
        
                    <div class="box" id="o" style="border:0px; box-shadow:none;" >
                      <div class="box-header with-border">
                        <h3 class="box-title" id="boxTitulo">Usuario:</h3>
                      </div>
                      <!-- /.box-header -->
                      <!-- form start -->
        
                      <div class="box-body">
        

        
  
                      <div class="col-md-12" style="width:100%;background-color: rgb(150, 208, 222) !important;">

                        <label  for="txtdato1" class="col-sm-2 control-label"></label>
        
                      <div class="form-group">
                          <label  for="txtdato2" class="col-sm-4 control-label">Ingrese su Contraseña Actual</label>
        
                          <div class="col-sm-5">
                            <input type="password" class="form-control" id="txtdato2" name="txtdato2" placeholder="******" maxlength="250" v-model="pswa" required @keydown="$event.keyCode === 13 ? $event.preventDefault() : false">
                          </div>
                        </div>
                      </div>
        
                      <div class="col-md-12">
                        <hr>
                      </div>
        
                       <div class="col-md-12" style="width:100%;background-color: rgb(255, 227, 137) !important;">
        
                        <label  for="txtdato1" class="col-sm-2 control-label"></label>
        
                      <div class="form-group">
                          <label  for="txtdato3" class="col-sm-4 control-label">Ingrese su Nueva Contraseña</label>
        
                          <div class="col-sm-5">
                            <input type="password" class="form-control" id="txtdato3" name="txtdato3" placeholder="******" maxlength="250" v-model="pswn1" required @keydown="$event.keyCode === 13 ? $event.preventDefault() : false">
                          </div>
                        </div>
                      </div>
        
                      <div class="col-md-12">
                        <hr>
                      </div>
        
        
                      <div class="col-md-12" style="width:100%;background-color: rgb(255, 227, 137) !important;">
        
                        <label  for="txtdato1" class="col-sm-2 control-label"></label>
        
                      <div class="form-group">
                          <label  for="txtdato4" class="col-sm-4 control-label">Repita su Nueva Contraseña</label>
        
                          <div class="col-sm-5">
                            <input type="password" class="form-control" id="txtdato4" name="txtdato4" placeholder="******" maxlength="250" v-model="pswn2" required @keydown="$event.keyCode === 13 ? $event.preventDefault() : false">
                          </div>
                        </div>
                      </div>
        
        
        
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btnSaveE"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
        
                    <button type="button" id="btnCancelE" class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>
        
                    <div class="sk-circle" v-show="divloaderEdit">
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
        
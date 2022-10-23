<form v-on:submit.prevent="createUsuario">
  <div class="box-body" style="font-size: 14px;">



      <div class="col-md-12">
        <hr style="border-top: 3px solid #1b5f43;">
      </div>

      <center>
        <h4>Datos Personales</h4>
      </center>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="cbuoficina_idTrabajador" class="col-sm-2 control-label">Oficina:<spam style="color:red;">*</spam></label>
          <div class="col-sm-10">
            <select class="form-control" id="cbuoficina_idTrabajador" name="cbuoficina_idTrabajador" v-model="oficina_idTrabajador">
              <option disabled value="0">Seleccione una Oficina</option>
              @foreach ($oficinas as $dato)
                <option value="{{$dato->id}}">{{$dato->nombre}}</option> 
              @endforeach
            </select>
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
            <label for="txtcargoTrabajador" class="col-sm-2 control-label">Cargo:<spam style="color:red;">*</spam></label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="txtcargoTrabajador" name="txtcargoTrabajador" placeholder="Cargo"
                maxlength="250" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="cargoTrabajador">
            </div>
        </div>
      </div>



      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtnum_documentoPersona" class="col-sm-2 control-label">DNI:<spam style="color:red;">*</spam></label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="txtnum_documentoPersona" name="txtnum_documentoPersona" placeholder="N° de Doc" maxlength="8"
              autofocus v-model="num_documentoPersona" @keyup.enter="pressNuevoDNI()" required
              @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" :disabled="validated == 1"  @change="pressNuevoDNI()"
             >
          </div>
        </div>
      </div>
  
      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtnombresPersona" class="col-sm-2 control-label">Nombres:<spam style="color:red;">*</spam></label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="txtnombresPersona" name="txtnombresPersona" placeholder="Nombres"
              maxlength="250" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="nombresPersona">
          </div>
  
          <label for="apellidosPersona" class="col-sm-2 control-label">Apellidos:<spam style="color:red;">*</spam></label>
          <div class="col-sm-4">
              <input type="text" class="form-control" id="apellidosPersona" name="apellidosPersona" placeholder="Apellidos"
                maxlength="250" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="apellidosPersona">
            </div>
        </div>
      </div>
  
      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
            <label for="txtdireccionPersona" class="col-sm-2 control-label">Dirección:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="txtdireccionPersona" name="txtdireccionPersona" placeholder="Av. Jr. Psje."
                maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="direccionPersona">
            </div>
        </div>
      </div>
  
      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
            <label for="txttelefonoPersona" class="col-sm-2 control-label">Teléfono:</label>
            <div class="col-sm-2">
              <input type="text" class="form-control" id="txttelefonoPersona" name="txttelefonoPersona" placeholder="Telef / Cell"
                maxlength="50" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="telefonoPersona">
            </div>
        </div>
      </div>

      <div class="col-md-12">
        <hr>
      </div>

      <center>
        <h4>Datos de Usuario</h4>
      </center>


      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="cbutipo_user_id" class="col-sm-2 control-label">Tipo de Usuario:<spam style="color:red;">*</spam></label>
          <div class="col-sm-4">
            <select class="form-control" id="cbutipo_user_id" name="cbutipo_user_id" v-model="tipo_user_id">
              <option disabled value="0">Seleccione un Tipo de Usuario</option>
              @foreach ($tipo_users as $dato)
                <option value="{{$dato->id}}">{{$dato->nombre}}</option> 
              @endforeach
            </select>
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtemail" class="col-sm-2 control-label">Email:<spam style="color:red;">*</spam></label>
          <div class="col-sm-10">
            <input type="email" class="form-control" id="txtemail" name="txtemail" placeholder="example@domain.com"
              maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="email">
          </div>
        </div>
      </div>


      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtname" class="col-sm-2 control-label">Username:<spam style="color:red;">*</spam></label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="txtname" name="txtname" placeholder="Username" maxlength="500"
              @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="name">
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtpassword" class="col-sm-2 control-label">Password:<spam style="color:red;">*</spam></label>
          <div class="col-sm-10">
            <input type="password" class="form-control" id="txtpassword" name="txtpassword" placeholder="********"
              maxlength="500" v-model="password">
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="cbuactivo" class="col-sm-2 control-label">Estado:<spam style="color:red;">*</spam></label>
          <div class="col-sm-4">
            <select class="form-control" id="cbuactivo" name="cbuactivo" v-model="activo">
              <option value="1">Activado</option>
              <option value="0">Desactivado</option>
            </select>
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;" v-if="tipo_user_id == '2'">
        <div class="form-group">
          <label for="checkbox1" class="col-sm-2 control-label">Permisos:<spam style="color:red;">*</spam></label>
          <div class="col-sm-10">
            
            <input type="checkbox" id="checkbox1" v-model="permiso_form1">
            <label for="checkbox1">{{ $permisos[0]->descripcion }}</label>
            <br>
            <input type="checkbox" id="checkbox2" v-model="permiso_form2">
            <label for="checkbox2">{{ $permisos[1]->descripcion }}</label>
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;" v-if="tipo_user_id == '1'">
        <div class="form-group">
          <label for="checkbox1" class="col-sm-2 control-label">Permisos:<spam style="color:red;">*</spam></label>
          <div class="col-sm-10">
            
            <label for="checkbox1" class="control-label" style="font-weight:bold">Todos</label>
          </div>
        </div>
      </div>



  </div>

  <!-- /.box-body -->
  <div class="box-footer">
    <button  type="submit" class="btn btn-info" id="btnGuardar"><span
      class="fa fa-floppy-o"></span> Guardar</button>

  <button  type="reset" class="btn btn-warning" id="btnCancel"
    @click="cancelFormUsuario()"><span class="fa fa-rotate-left"></span> Cancelar</button>

    <button type="button" class="btn btn-danger" id="btnClose" @click.prevent="cerrarFormUsuario()"><span
        class="fa fa-power-off"></span> Cerrar</button>

    <div class="sk-circle" v-show="divloaderNuevo">
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
  <!-- /.box-footer -->

</form>
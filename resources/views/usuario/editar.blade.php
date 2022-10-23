<form method="post" v-on:submit.prevent="updateUsuario(filluser.id)">
  <div class="box-body" style="font-size: 14px;">

      <div class="col-md-12">
        <hr style="border-top: 3px solid rgb(208, 211, 51);">
      </div>

      <center>
        <h4>Datos Personales</h4>
      </center>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="cbuoficina_idTrabajadorE" class="col-sm-2 control-label">Oficina:<spam style="color:red;">*</spam></label>
          <div class="col-sm-10">
            <select class="form-control" id="cbuoficina_idTrabajadorE" name="cbuoficina_idTrabajadorE" v-model="filluser.oficina_idTrabajador">
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
            <label for="txtcargoTrabajadorE" class="col-sm-2 control-label">Cargo:<spam style="color:red;">*</spam></label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="txtcargoTrabajadorE" name="txtcargoTrabajadorE" placeholder="Cargo"
                maxlength="250" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filluser.cargoTrabajador">
            </div>
        </div>
      </div>



      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtnum_documentoPersonaE" class="col-sm-2 control-label">DNI:<spam style="color:red;">*</spam></label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="txtnum_documentoPersonaE" name="txtnum_documentoPersonaE" placeholder="N° de Doc" maxlength="8"
              autofocus v-model="filluser.num_documentoPersona" @keyup.enter="pressNuevoDNIE()" required
              @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" :disabled="validated == 1"  @change="pressNuevoDNIE()"
             >
          </div>
        </div>
      </div>
  
      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtnombresPersonaE" class="col-sm-2 control-label">Nombres:<spam style="color:red;">*</spam></label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="txtnombresPersonaE" name="txtnombresPersonaE" placeholder="Nombres"
              maxlength="250" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filluser.nombresPersona">
          </div>
  
          <label for="apellidosPersonaE" class="col-sm-2 control-label">Apellidos:<spam style="color:red;">*</spam></label>
          <div class="col-sm-4">
              <input type="text" class="form-control" id="apellidosPersonaE" name="apellidosPersonaE" placeholder="Apellidos"
                maxlength="250" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filluser.apellidosPersona">
            </div>
        </div>
      </div>
  
      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
            <label for="txtdireccionPersonaE" class="col-sm-2 control-label">Dirección:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="txtdireccionPersonaE" name="txtdireccionPersonaE" placeholder="Av. Jr. Psje."
                maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filluser.direccionPersona">
            </div>
        </div>
      </div>
  
      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
            <label for="txttelefonoPersonaE" class="col-sm-2 control-label">Teléfono:</label>
            <div class="col-sm-2">
              <input type="text" class="form-control" id="txttelefonoPersonaE" name="txttelefonoPersonaE" placeholder="Telef / Cell"
                maxlength="50" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filluser.telefonoPersona">
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
          <label for="cbutipo_user_idE" class="col-sm-2 control-label">Tipo de Usuario:*</label>
          <div class="col-sm-4">
            <select class="form-control" id="cbutipo_user_idE" name="cbutipo_user_idE" v-model="filluser.tipo_user_id" >
              <option disabled value="">Seleccione un Tipo de Usuario</option>
              @foreach ($tipo_users as $dato)
                <option value="{{$dato->id}}">{{$dato->nombre}}</option> 
              @endforeach
            </select>
          </div>
        </div>
      </div>


      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">

          <label for="txtemailE" class="col-sm-2 control-label">Email:</label>
          <div class="col-sm-4">
            <input type="email" class="form-control" id="txtemailE" name="txtemailE" placeholder="example@domain.com"
              maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filluser.email">
          </div>

            

        </div>
      </div>


      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtnameE" class="col-sm-2 control-label">Username:*</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="txtnameE" name="txtnameE" placeholder="Username" maxlength="500"
              @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filluser.name">
          </div>
        </div>
      </div>


      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="cbumodifpassword" class="col-sm-2 control-label">¿Modificar Password?:*</label>
          <div class="col-sm-4">
            <select class="form-control" id="cbumodifpassword" name="cbumodifpassword" v-model="filluser.modifpassword" @change="modifclave">
              <option value="0">No</option>
              <option value="1">Si</option>
            </select>
          </div>
        </div>
      </div>
      

      <div class="col-md-12" style="padding-top: 15px;" v-if="parseInt(filluser.modifpassword)==1">
        <div class="form-group">
          <label for="txtpasswordE" class="col-sm-2 control-label">Password:*</label>
          <div class="col-sm-4">
            <input type="password" class="form-control" id="txtpasswordE" name="txtpasswordE" placeholder="********"
              maxlength="500" v-model="filluser.password">
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="cbuactivoE" class="col-sm-2 control-label">Estado:*</label>
          <div class="col-sm-4">
            <select class="form-control" id="cbuactivoE" name="cbuactivoE" v-model="filluser.activo">
              <option value="1">Activado</option>
              <option value="0">Desactivado</option>
            </select>
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;" v-if="filluser.tipo_user_id == '2'">
        <div class="form-group">
          <label for="checkbox1" class="col-sm-2 control-label">Permisos:<spam style="color:red;">*</spam></label>
          <div class="col-sm-10">
            
            <input type="checkbox" id="checkbox1" v-model="filluser.permiso_form1">
            <label for="checkbox1">{{ $permisos[0]->descripcion }}</label>
            <br>
            <input type="checkbox" id="checkbox2" v-model="filluser.permiso_form2">
            <label for="checkbox2">{{ $permisos[1]->descripcion }}</label>
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;" v-if="filluser.tipo_user_id == '1'">
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
    <button type="submit" class="btn btn-primary" id="btnSaveE"><i class="fa fa-floppy-o" aria-hidden="true"></i>
      Modificar</button>

    <button type="button" class="btn btn-default" id="btnCloseE" @click.prevent="cerrarFormUsuarioE()">Cancelar</button>

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
  <!-- /.box-footer -->

</form>
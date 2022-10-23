<form method="post" v-on:submit.prevent="update(fillobject.id)">
  <div class="box-body" style="font-size: 14px;">


    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="cbutipoPersonaE" class="col-sm-2 control-label">Tipo:<spam style="color:red;">*</spam></label>
        <div class="col-sm-4">
          <select class="form-control" id="cbutipoPersonaE" name="cbutipoPersonaE" v-model="fillobject.tipoPersona" @change="pressNuevoDNIE()">
            <option value="1">Natural</option>
            <option value="2">Jurídico</option>
          </select>
        </div>
      </div>
    </div>

    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="txtnum_documentoPersonaE" class="col-sm-2 control-label">Documento de Identidad @{{tipoDocIdentidadE}}:<spam style="color:red;">*</spam></label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="txtnum_documentoPersonaE" name="txtnum_documentoPersonaE" placeholder="N° de Doc" maxlength="11"
            autofocus v-model="fillobject.num_documentoPersona" @keyup.enter="pressNuevoDNIE()" required
            @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" :disabled="validated == 1"  @change="pressNuevoDNIE()"
           >
        </div>
      </div>
    </div>

    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="txtnombresPersonaE" class="col-sm-2 control-label">@{{nombreClienteE}}:<spam style="color:red;">*</spam></label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="txtnombresPersonaE" name="txtnombresPersonaE" placeholder="Nombre"
            maxlength="250" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillobject.nombresPersona">
        </div>

        <template v-if="fillobject.tipoPersona == '1'">
        <label for="apellidosPersonaE" class="col-sm-2 control-label">Apellidos:<spam style="color:red;">*</spam></label>
        <div class="col-sm-4">
            <input type="text" class="form-control" id="apellidosPersonaE" name="apellidosPersonaE" placeholder="Apellidos"
              maxlength="250" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillobject.apellidosPersona">
          </div>
        </template>
      </div>
    </div>

    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">

        <label for="txtemailPersonaE" class="col-sm-2 control-label">Email:<spam style="color:red;">*</spam></label>
          <div class="col-sm-4">
            <input type="email" class="form-control" id="txtemailPersonaE" name="txtemailPersonaE" placeholder="example@domain.com"
              maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillobject.emailPersona">
          </div>

          <label for="txtdireccionPersonaE" class="col-sm-2 control-label">Dirección:</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="txtdireccionPersonaE" name="txtdireccionPersonaE" placeholder="Av. Jr. Psje."
              maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillobject.direccionPersona">
          </div>

      </div>
    </div>


    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
          <label for="txttelefonoPersonaE" class="col-sm-2 control-label">Teléfono:</label>
          <div class="col-sm-2">
            <input type="text" class="form-control" id="txttelefonoPersonaE" name="txttelefonoPersonaE" placeholder="Telef / Cell"
              maxlength="50" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillobject.telefonoPersona">
          </div>
      </div>
    </div>

    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="cbuactivoPersonaE" class="col-sm-2 control-label">Estado:<spam style="color:red;">*</spam></label>
        <div class="col-sm-4">
          <select class="form-control" id="cbuactivoPersonaE" name="cbuactivoPersonaE" v-model="fillobject.activo">
            <option value="1">Activado</option>
            <option value="0">Inactivo</option>
          </select>
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
        <label for="txtnameE" class="col-sm-2 control-label">Username:*</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="txtnameE" name="txtnameE" placeholder="Username" maxlength="500"
            @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillobject.name">
        </div>
      </div>
    </div>

    <div class="col-md-12" style="padding-top: 15px;" v-if="fillobject.idUsers!='0'">
      <div class="form-group">
        <label for="cbumodifpassword" class="col-sm-2 control-label">¿Modificar Password?:*</label>
        <div class="col-sm-4">
          <select class="form-control" id="cbumodifpassword" name="cbumodifpassword" v-model="fillobject.modifpassword" @change="modifclave">
            <option value="0">No</option>
            <option value="1">Si</option>
          </select>
        </div>
      </div>
    </div>

    <div class="col-md-12" style="padding-top: 15px;" v-if="parseInt(fillobject.modifpassword)==1">
      <div class="form-group">
        <label for="txtpasswordE" class="col-sm-2 control-label">Password:*</label>
        <div class="col-sm-4">
          <input type="password" class="form-control" id="txtpasswordE" name="txtpasswordE" placeholder="********"
            maxlength="500" v-model="fillobject.password">
        </div>
      </div>
    </div>
    


  </div>

  <!-- /.box-body -->
  <div class="box-footer">
    <button type="submit" class="btn btn-primary" id="btnSaveE"><i class="fa fa-floppy-o" aria-hidden="true"></i>
      Modificar</button>

    <button type="button" class="btn btn-default" id="btnCloseE" @click.prevent="cerrarFormE()">Cancelar</button>

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